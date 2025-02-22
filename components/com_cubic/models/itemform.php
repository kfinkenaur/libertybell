<?php
/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com> - http://raindropsinfotech.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

/**
 * Cubic model.
 */
class CubicModelItemForm extends JModelForm
{

	var $_item = null;

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since    1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('com_cubic');

		// Load state from the request userState on edit or from the passed variable on default
		if (JFactory::getApplication()->input->get('layout') == 'edit')
		{
			$id = JFactory::getApplication()->getUserState('com_cubic.edit.item.id');
		}
		else
		{
			$id = JFactory::getApplication()->input->get('id');
			JFactory::getApplication()->setUserState('com_cubic.edit.item.id', $id);
		}
		$this->setState('item.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();
		if (isset($params_array['item_id']))
		{
			$this->setState('item.id', $params_array['item_id']);
		}
		$this->setState('params', $params);

	}

	/**
	 * Method to get an ojbect.
	 *
	 * @param    integer    The id of the object to get.
	 *
	 * @return    mixed    Object on success, false on failure.
	 */
	public function &getData($id = null)
	{
		if ($this->_item === null)
		{
			$this->_item = false;

			if (empty($id))
			{
				$id = $this->getState('item.id');
			}

			// Get a level row instance.
			$table = $this->getTable();

			// Attempt to load the row.
			if ($table !== false && $table->load($id))
			{

				$user = JFactory::getUser();
				$id   = $table->id;
				if($id){
	$canEdit = $user->authorise('core.edit', 'com_cubic.item.'.$id) || $user->authorise('core.create', 'com_cubic.item.'.$id);
}
else{
	$canEdit = $user->authorise('core.edit', 'com_cubic') || $user->authorise('core.create', 'com_cubic');
}
				if (!$canEdit && $user->authorise('core.edit.own', 'com_cubic.item.'.$id))
				{
					$canEdit = $user->id == $table->created_by;
				}

				if (!$canEdit)
				{
					throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 500);
				}

				// Check published state.
				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published)
					{
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$properties  = $table->getProperties(1);
				$this->_item = JArrayHelper::toObject($properties, 'JObject');
			}
		}

		return $this->_item;
	}

	public function getTable($type = 'Item', $prefix = 'CubicTable', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_cubic/tables');

		return JTable::getInstance($type, $prefix, $config);
	}

	public function getItemIdByAlias($alias)
	{
		$table = $this->getTable();

		$table->load(array( 'alias' => $alias ));

		return $table->id;
	}

	/**
	 * Method to check in an item.
	 *
	 * @param    integer        The id of the row to check out.
	 *
	 * @return    boolean        True on success, false on failure.
	 * @since    1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int) $this->getState('item.id');

		if ($id)
		{

			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
			if (method_exists($table, 'checkin'))
			{
				if (!$table->checkin($id))
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Method to check out an item for editing.
	 *
	 * @param    integer        The id of the row to check out.
	 *
	 * @return    boolean        True on success, false on failure.
	 * @since    1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int) $this->getState('item.id');

		if ($id)
		{

			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = JFactory::getUser();

			// Attempt to check the row out.
			if (method_exists($table, 'checkout'))
			{
				if (!$table->checkout($user->get('id'), $id))
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Method to get the profile form.
	 *
	 * The base form is loaded from XML
	 *
	 * @param    array   $data     An optional array of data for the form to interogate.
	 * @param    boolean $loadData True if the form is to load its own data (default case), false if not.
	 *
	 * @return    JForm    A JForm object on success, false on failure
	 * @since    1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_cubic.item', 'itemform', array(
			'control'   => 'jform',
			'load_data' => $loadData
		));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return    mixed    The data for the form.
	 * @since    1.6
	 */
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_cubic.edit.item.data', array());
		if (empty($data))
		{
			$data = $this->getData();
		}
		

		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param    array        The form data.
	 *
	 * @return    mixed        The user id on success, false on failure.
	 * @since    1.6
	 */
	public function save($data)
	{
		$id    = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('item.id');
		$state = (!empty($data['state'])) ? 1 : 0;
		$user  = JFactory::getUser();

		if ($id)
		{
			//Check the user can edit this item
			$authorised = $user->authorise('core.edit', 'com_cubic.item.'.$id) || $authorised = $user->authorise('core.edit.own', 'com_cubic.item.'.$id);
			if ($user->authorise('core.edit.state', 'com_cubic.item.'.$id) !== true && $state == 1)
			{ //The user cannot edit the state of the item.
				$data['state'] = 0;
			}
		}
		else
		{
			//Check the user can create new items in this section
			$authorised = $user->authorise('core.create', 'com_cubic');
			if ($user->authorise('core.edit.state', 'com_cubic.item.'.$id) !== true && $state == 1)
			{ //The user cannot edit the state of the item.
				$data['state'] = 0;
			}
		}

		if ($authorised !== true)
		{
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$table = $this->getTable();
		if ($table->save($data) === true)
		{
			return $table->id;
		}
		else
		{
			return false;
		}

	}

	public function delete($data)
	{
		$id = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('item.id');
		if (JFactory::getUser()->authorise('core.delete', 'com_cubic.item.'.$id) !== true)
		{
			throw new Exception(403, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		$table = $this->getTable();
		if ($table->delete($data['id']) === true)
		{
			return $id;
		}
		else
		{
			return false;
		}
	}

	public function getCanSave()
	{
		$table = $this->getTable();

		return $table !== false;
	}

	

}
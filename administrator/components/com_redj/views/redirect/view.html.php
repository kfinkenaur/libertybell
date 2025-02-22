<?php
/**
 * ReDJ Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package ReDJ
 * @copyright Copyright 2009 - 2014
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.7.8
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once JPATH_COMPONENT.'/helpers/redj.php';

/**
 * HTML View class for the ReDJ Redirect component
 *
 * @package ReDJ
 *
 */
class ReDJViewRedirect extends JViewLegacy
{
  protected $form;
  protected $item;
  protected $state;

  /**
   * Display the view
   */
  public function display($tpl = null)
  {
    // Initialiase variables.
    $this->form = $this->get('Form');
    $this->item = $this->get('Item');
    $this->state = $this->get('State');

    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode("\n", $errors));
      return false;
    }

    $this->addToolbar();
    parent::display($tpl);
  }

  /**
   * Add the page title and toolbar
   *
   */
  protected function addToolbar()
  {
    JFactory::getApplication()->input->set('hidemainmenu', true);

    $user = JFactory::getUser();
    $userId = $user->get('id');
    $isNew = ($this->item->id == 0);
    $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
    $canDo = ReDJHelper::getActions();

    JToolBarHelper::title($isNew ? JText::_('COM_REDJ_REDIRECT_NEW') : JText::_('COM_REDJ_REDIRECT_EDIT'), 'redj.png');

    // If not checked out, can save the item
    if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_redj', 'core.create')) > 0)) {
      JToolBarHelper::apply('redirect.apply');
      JToolBarHelper::save('redirect.save');

      if ($canDo->get('core.create')) {
        //JToolBarHelper::save2new('redirect.save2new');
        JToolBarHelper::custom('redirect.save2new', 'save-new', '', 'JTOOLBAR_SAVE_AND_NEW', false);
      }
    }

    // If an existing item, can save to a copy
    if (!$isNew && $canDo->get('core.create')) {
      //JToolBarHelper::save2copy('redirect.save2copy');
      JToolBarHelper::custom('redirect.save2copy', 'save-copy', '', 'JTOOLBAR_SAVE_AS_COPY', false);
    }

    if (empty($this->item->id)) {
      JToolBarHelper::cancel('redirect.cancel');
    } else {
      JToolBarHelper::cancel('redirect.cancel', 'JTOOLBAR_CLOSE');
    }

  }

}

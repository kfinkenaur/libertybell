<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
class JFormFieldParentCategory extends JFormField {
 
	protected $type = 'parentcategory';
 
	public function getLabel() {
		return ' Parent Category';
	}
 
	public function getInput() {
		//select id,cat_name from #__cubic_categories where `state`=1 order by cat_name

		$db = JFactory::getDbo();
		 
		$cur_cate_id = JRequest::getVar('id');
		$category_cond = '';
		$parent_category = 0;
		if(!empty($cur_cate_id)){
			$category_cond = ' AND id <> '.$cur_cate_id;
			$catequery = $db->getQuery(true);
			$catequery->select($db->quoteName(array('parent_category')));
			$catequery->from($db->quoteName('#__cubic_categories'));
			$catequery->where($db->quoteName('state') . ' = 1 AND id = '.$cur_cate_id);
			$catequery->order('cat_name ASC');

			$db->setQuery($catequery);
			 
			$categoryresult = $db->loadObject();
			$parent_category = $categoryresult->parent_category;
		}

		$query = $db->getQuery(true);

		$query->select($db->quoteName(array('id','cat_name')));
		$query->from($db->quoteName('#__cubic_categories'));
		$query->where($db->quoteName('state') . ' = 1 AND parent_category = 0'.$category_cond);
		$query->order('cat_name ASC');
		 
		$db->setQuery($query);
		 
		$categoriesresults = $db->loadObjectList();

		//var_dump($categoriesresults);exit;

		$options_html = '';
		
		$select_start_html = '<select id="'.$this->id.'" name="'.$this->name.'">';
		$options_html .= '<option value="">No Parent</option>';
		$select_end_html = '</select>';

		foreach ($categoriesresults as $catkey => $category) {
			if($category->id == $parent_category){
				$selected_html = 'selected="selected"';	
			} else {
				$selected_html = '';
			}
			$options_html .= '<option '.$selected_html.' value="'.$category->id.'" >'.$category->cat_name.'</option>';
		}

		return $select_start_html.$options_html.$select_end_html;
	}
}
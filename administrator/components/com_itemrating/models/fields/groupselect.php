<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldGroupSelect extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'text';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		$scr="";
		$context= JFactory::getApplication()->input->getString('option','');
		$final_group=array();
		 $db = JFactory::getDBO();
		 $textforscore="";
		 $reviewsummary="";
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'customcategory')));
        $query->from('#__itemrating_group');
        $query->where(' state = 1');
          $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $results= $db->loadObjectList();
	if(($context=="com_content")&&($context=="com_k2"))
	{
	if($context=="com_content")
		{
			$scr.=" itemRating('#jform_catid').on('change', function(evt, params) {
			var cvalue=itemRating('#jform_catid').val();";
			$itemname="jformattribsgroupdata";
			$json=$this->form->getValue('attribs');
			if(!empty($json))
			{
				$textforscore=$json->textforscore;
				$reviewsummary=$json->reviewsummary;
			}
		}
		else if($context=="com_k2")
		{
			$scr.=" itemRating('#catid').on('change', function(evt, params) {
			var cvalue=itemRating('#catid').val();";
			$itemname="groupdata";
			$textforscore=$this->form->getValue('textforscore');
			$reviewsummary=$this->form->getValue('reviewsummary');
			
		}
			$c=1;
	foreach($results as $result)
	{
	
		$json=json_decode($result->customcategory,true);
		if(!empty($json[$context]))
		{
		foreach($json[$context] as $json)
		{
			if($c==1)
			{
		$scr.="if(cvalue==".$json.")
		{
		itemRating('#".$itemname."').val('".$result->id."');
		itemRating('#".$itemname."').trigger('liszt:updated');
		createRatingbox(".$result->id.");
		}";
			}
			else
			{
			$scr.="else if(cvalue==".$json.")
		{
		itemRating('#".$itemname."').val('".$result->id."');
		itemRating('#".$itemname."').trigger('liszt:updated');
		createRatingbox(".$result->id.");
		}";	
			}
			$c++;
		}
		}
	}
	if($c!=1){
			$scr.="
			else
			{
				itemRating('#".$itemname."').val('');
				itemRating('#".$itemname."').trigger('liszt:updated');
				createRatingbox(0);
			}";
	}
			$scr.="});";
	}
	
		 if($context=="com_k2")
		{
		$context_id= JFactory::getApplication()->input->getInt('cid');	
		}
		else if($context=="com_hikashop")
		{
		$c_id= JFactory::getApplication()->input->getVar('cid');
		$context_id= $c_id[0];
		$textforscore=$this->form->getValue('textforscore','attribs');
		$reviewsummary=$this->form->getValue('reviewsummary','attribs');
		
		}
		else
		{
		$context_id= JFactory::getApplication()->input->getInt('id');
		}
		
		if($context_id==0)
		{
		$context=null;
		$context_id=null;
		}
		$scr.="";
		if(!empty($this->value))
		{
		$scr.="createRatingbox(".$this->value.");";	
		}
		$script=<<<EOF
<script type="text/javascript">var itemRating = jQuery.noConflict();

itemRating(document).ready(


    function(event) {
    $scr
      itemRating('.groupdata').on('change', function(evt, params) {
        var value=itemRating('.groupdata').val();
        createRatingbox(value);
  });
    }
);
function createRatingbox(value)
{
        itemRating.post( 'index.php',{option:'com_itemrating',task:'items.createBox',tmpl:'component',id:value,context:'$context',context_id:'$context_id',reviewsummary:'$reviewsummary',textforscore:'$textforscore'}, function( data ) {
        itemRating('#rating_$this->id').html(data);
});
}
    
</script>
EOF;
        $html=$script;
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'title')));
        $query->where('state=1');
	$query->from('#__itemrating_group');
        $query->order('title ASC');
        $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $rows= $db->loadObjectList();
       
        $options[] = JHTML::_('select.option','',JText::_('JSELECT'));
        foreach ($rows as $key => $value) {
            $options[] = JHTML::_('select.option', $value->id, JText::_($value->title));    
        }

        $html.=JHTML::_('select.genericlist', $options, $this->name, 'class="groupdata"', 'value','text', $this->value );
         
        $html.="<br/><span id='rating_".$this->id."'></span>";
        
                       return $html;
	}
}
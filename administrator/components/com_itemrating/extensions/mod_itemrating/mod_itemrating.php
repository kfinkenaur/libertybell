<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
// No direct access

defined('_JEXEC') or die;
$lang = JFactory::getLanguage();
$app = JFactory::getApplication();
$count = $params->get('count',5);
$component = $params->get('context','com_content');
$mymenuitem = $params->get('mymenuitem');
$order=$params->get('ordering','user');
$score_type=$params->get('score_type',2);
$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('a.*,sum(rating_sum),sum(rating_value),sum(rating_value*rating_sum)/sum(rating_sum),sum(rating_value*rating_sum)/sum(rating_sum) as final_rate,sum(rating_sum) as final_count');
$query->select('k.*');
	$query->join('LEFT','#__itemrating_item as i ON a.rating_id = i.id');
 if($component=="com_k2")
            {
                $query->join('LEFT', '#__k2_items AS k ON k.id = a.context_id');
            
            }
            else if($component=="com_adsmanager")
            {
                $query->join('LEFT', '#__adsmanager_ads AS k ON k.id = a.context_id');
            
            }
            else if($component=="com_content")
            {
                $query->join('LEFT', '#__content AS k ON k.id = a.context_id');
            }
            else if($component=="com_zoo")
            {
                $query->join('LEFT', '#__zoo_item AS k ON k.id = a.context_id');
            }
            else if($component=="com_virtuemart")
            {
                if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_virtuemart'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'config.php');
                $vm=VmConfig::loadConfig();
            $query->join('LEFT', '#__virtuemart_products_'.$vm->get('vmlang').' AS k ON k.virtuemart_product_id = a.context_id');
            }
            else if($component=="com_hikashop")
            {
               $query->join('LEFT', '#__hikashop_product AS k ON k.product_id = a.context_id'); 
            
        }
        else if(($component=="com_community")||($component=="com_comprofiler"))
            {
               $query->join('LEFT', '#__users AS k ON k.id = a.context_id'); 
            }
	   else if($component=="com_mtree")
            {
               $query->join('LEFT', '#__mt_links AS k ON k.link_id = a.context_id'); 
            
        }
        else if($component=="com_sppagebuilder")
        {
               $query->join('LEFT', '#__sppagebuilder AS k ON k.id = a.context_id'); 
            
        }
        else if($component=="com_gmapfp")
        {
               $query->join('LEFT', '#__gmapfp AS k ON k.id = a.context_id'); 
            
        }
$query->from('#__itemrating_itemdata as a');
$query->where('context='.$db->quote($component));
if($component=="com_k2")
            {
                $query->where('k.published =1 AND k.trash=0');
            
            }
            else if($component=="com_adsmanager")
            {
               $query->where('k.ad_state=1');
            
            }
            else if($component=="com_content")
            {
                $query->where('k.state=1');
            }
            else if($component=="com_zoo")
            {
                 $query->where('k.state=1');
            }
            else if($component=="com_virtuemart")
            {
                $query->where('k.published =1');
            }
            else if($component=="com_hikashop")
            {
                $query->where('k.product_published =1');
              
            }
        else if(($component=="com_community")||($component=="com_comprofiler"))
            {
               $query->where('k.block =0');
            }
	   else if($component=="com_mtree")
            {
                $query->where('k.published =1');
            }
        else if($component=="com_sppagebuilder")
        {
               $query->where('k.published =1');
            
        }
        else if($component=="com_gmapfp")
        {
                $query->where('k.published =1');
            
        }
$query->where('i.type!=0');
$query->group('context_id');
if($order=="rating")
{
	$query->order('4 DESC');
}
if($order=="user")
{
	$query->order('sum(rating_sum) DESC');
}else
{
	$query->order('rand()');
}
$db->setQuery($query,0,$count);
$result = $db->loadObjectList();
ItemratingHelper::loadLanguage();
require JModuleHelper::getLayoutPath('mod_itemrating', $params->get('layout', 'default'));

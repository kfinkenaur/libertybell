<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
// No direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.model');

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.installer.installer');

/**
 * Itemrating custom installer class
 */
class com_itemratingInstallerScript {

    function postflight($type, $parent) {
        
        $db = JFactory::getDbo();

        $fields = $db->getTableColumns('#__itemrating_item');
        if (!array_key_exists('misc', $fields)) {
            $query = "ALTER TABLE #__itemrating_item ADD `misc` text NOT NULL  AFTER `hits`";
            $db->setQuery($query);
            $db->query();
        }
        if (!array_key_exists('fasetting', $fields)) {
            $query = "ALTER TABLE #__itemrating_item ADD `fasetting` varchar(255) NOT NULL  AFTER `hits`";
            $db->setQuery($query);
            $db->query();
        }
        
        $fields = $db->getTableColumns('#__itemrating_group');
        if (!array_key_exists('snippettype', $fields)) {
            $query = "ALTER TABLE #__itemrating_group ADD `snippettype`  varchar(255)  NOT NULL  AFTER `customcategory`";
            $db->setQuery($query);
            $db->query();
        }
        
         $fields = $db->getTableColumns('#__itemrating_itemdata');
        if (!array_key_exists('rating_value', $fields)) {
            $query = "ALTER TABLE #__itemrating_itemdata ADD `rating_value`  varchar(255)  NOT NULL  AFTER `rating_sum`";
            $db->setQuery($query);
            $db->query();
        }
        
        $tableExtensions = $db->quoteName("#__extensions");
        $columnElement = $db->quoteName("element");
        $columnType = $db->quoteName("type");
        $columnEnabled = $db->quoteName("enabled");
        $folder = $db->quoteName("folder");
        $installer = method_exists($parent, 'getParent') ? $parent->getParent() : $parent->parent;
        // Enable plugin
        $db->setQuery("UPDATE $tableExtensions SET $columnEnabled=1 WHERE $columnElement='itemrating' AND $columnType='plugin'");
        $db->query();
        $query = "SELECT COUNT(*) FROM #__itemrating_group";
        $db->setQuery($query);
        $num = $db->loadResult();
         if ($num == 0)
        {
                 $query = "
INSERT INTO `#__itemrating_group` (`ordering`, `state`, `checked_out`, `checked_out_time`, `created_by`, `title`, `display`, `textforscore`, `reviewsummary`, `styling`, `customcss`, `position`, `customcategory`) VALUES
( 1, 1, 0, '0000-00-00 00:00:00', '', 'Uncategorised', 1, '', '', '{\"outer_border\":\"#EEEEEE\",\"head_background\":\"#444444\",\"head_color\":\"#FFFFFF\",\"item_background\":\"#E0E0E0\",\"score_bg\":\"#FFFFFF\",\"link_color\":\"#666666\",\"bar_bg\":\"#4DB2EC\",\"vote_color\":\"#666666\",\"show_vote\":\"1\",\"score_position\":\"3\",\"score_type\":\"0\"}', '', '0', 'null');";
            $db->setQuery($query);
            $db->Query();
            $groupID = $db->insertid();
                 $query = "
INSERT INTO `#__itemrating_item` ( `state`, `checked_out`, `checked_out_time`, `created_by`, `title`, `rating`, `label`, `group_id`, `type`, `icon`, `number`, `ordering`, `hits`, `fasetting`, `misc`) VALUES
( 1, '0', '', '".JFactory::getUser()->id."', 'Our Rating', '100', '1', '".$groupID."', '1', 'stars', 0, 1, 1, '', '');";
            $db->setQuery($query);
            
            $db->Query();
            
            
        }
        //Instaler to install zoo element
         $path=JPATH_SITE.'/media/zoo/elements/';
                 if (JFolder::exists($path)) {
                        $installer = method_exists($parent, 'getParent') ? $parent->getParent() : $parent->parent;
                        $dst = JPATH_ROOT.'/media/zoo/elements/itemrating';
                        $src = $installer->getPath('source') .'/administrator/extensions/zoo/itemrating';
                        if(!JFolder::exists( $dst))
                        {
                            JFolder::create( $dst);
                        }
                        JFile::copy( $src. "/itemrating.php" , $dst. "/itemrating.php");
                        JFile::copy( $src. "/itemrating.xml" , $dst. "/itemrating.xml");
                               echo '<img src="'. JURI::root().'/components/com_itemrating/assets/images/tick.png" />Zoo Installation : '.JText::sprintf('OK','').'<br/>';
                    }
        $path=JPATH_SITE.'/components/com_sppagebuilder/addons/';
                 if (JFolder::exists($path)) {
                        $installer = method_exists($parent, 'getParent') ? $parent->getParent() : $parent->parent;
                        $dst = JPATH_ROOT.'/components/com_sppagebuilder/addons/itemrating/';
                        $src = $installer->getPath('source') .'/administrator/extensions/sppagebuilder/itemrating/';
                        if(!JFolder::exists( $dst))
                        {
                            JFolder::create( $dst);
                        }
                        JFile::copy( $src. "/admin.php" , $dst. "/admin.php");
                        JFile::copy( $src. "/site.php" , $dst. "/site.php");
                        echo '<img src="'. JURI::root().'/components/com_itemrating/assets/images/tick.png" />SP Page Builder Installation : '.JText::sprintf('OK','').'<br/>';
                    } 
          $manifest = $parent->get('manifest');
          $extensions = $manifest->extensions;
           JLoader::register('ItemRatingInstallerHelper', JPATH_ADMINISTRATOR . '/components/com_itemrating/helpers/installer.php');
           foreach($extensions->children() as $extension){
                        $folder = $extension->attributes()->folder;
                        $enable = $extension->attributes()->enable;
                        if(@ItemRatingInstallerHelper::install(JPATH_ADMINISTRATOR.'/components/com_itemrating/extensions/'.$folder,$enable)){
    //                        JFile::delete(JPATH_ADMINISTRATOR.'/components/com_sponsorshipreward/extensions/'.$folder);
                            echo '<img src="'. JURI::root().'/components/com_itemrating/assets/images/tick.png" />'.$folder.' : '.JText::sprintf('OK','').'<br/>';
                        }else{
                            echo '<img src="'. JURI::root().'/components/com_itemrating/assets/images/exclamation.png" />'.$folder.' : '.JText::sprintf('Not OK','').'<br/>';
                        }
                }
                
                           
    }
  
    function uninstall($parent)
        {
        $db = JFactory::getDBO();
        $status = new stdClass;
        $status->modules = array();
        $status->plugins = array();
        $manifest = $parent->get('manifest');
        $extensions = $manifest->extensions;
        
        foreach($extensions->children() as $plugin)
        {
            $name = (string)$plugin->attributes()->group;
            $query = "SELECT `extension_id` FROM #__extensions WHERE `type`='plugin' AND element = ".$db->Quote($name);
            $db->setQuery($query);
            $extensions = $db->loadColumn();
            if (count($extensions))
            {
                foreach ($extensions as $id)
                {
                    $installer = new JInstaller;
                    $result = $installer->uninstall('plugin', $id);
                }
            
            }
            
        }
        }
        
    
        /**
        * Method to get the version of a component
        * @param string $option
        * @return null
        */
        private function getVersion($option){
                $manifest = self::getManifest($option);
                if(property_exists($manifest, 'version')){
                         return $manifest->version;
                }
                return null;
        }
        
        /**
        * Method to get an object containing the manifest values
        * @param string $option
        * @return object
        */
        private function getManifest($option){
//                $component = JComponentHelper::getComponent($option);
                $dbo = JFactory::getDbo();
                $query = 'SELECT extension_id FROM #__extensions WHERE element='.$dbo->quote($option).' AND type="component"';
                if(!$dbo->setQuery($query)){
                    return false;
                }
                if(!$dbo->query()){
                    return false;
                }
                $component = $dbo->loadResult();
                if(!$component){
                    return false;
                }
                $table	= JTable::getInstance('extension');
                // Load the previous Data
                if (!$table->load($component,false)) {
                         return false;
                }
                return json_decode($table->manifest_cache);
        }
    
   

}
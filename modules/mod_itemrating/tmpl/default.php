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
$com_path = JPATH_SITE . '/components/com_content/';
require_once $com_path . 'helpers/route.php';
?>
<ul class="itemrating <?php echo htmlspecialchars( $params->get( 'moduleclass_sfx' ) );?> nav menu">
<?php foreach($result as $item) {  
    $item->categoryview=1;
    $item->voteallowed=1;
    $item->slug    = $item->id . ':' . $item->alias;
    if($component=="com_k2")
    {

                require_once (JPATH_SITE .'/components/com_k2/helpers/route.php');
                require_once (JPATH_SITE . '/components/com_k2/helpers/utilities.php');
                $link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id . ':' . urlencode($item->alias), $item->catid)));
                 $data=json_decode($item->plugins);
                $item->attribs=json_encode(array("groupdata"=>$data->itemratinggroupdata,'textforscore'=>$data->itemratingtextforscore,'reviewsummary'=>$data->itemratingreviewsummary));
                $item->authorName=JFactory::getUser($item->created_by)->name;
    }
    else
    {
        $link=JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
    }
    ?>
<li class="pull-left" style="width:100%;">
    <a href="<?php echo $link; ?>">
    <?php echo $item->title;?>
    </a>
    <?php
    echo ItemratingHelper::getFinalScoreWidget($score_type,$item->final_rate,$item->final_count);?>
    

</li>
<?php }?>
</ul>
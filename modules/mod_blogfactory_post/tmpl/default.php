<?php

/**
-------------------------------------------------------------------------
blogfactory - Blog Factory 4.3.0
-------------------------------------------------------------------------
 * @author thePHPfactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thePHPfactory.com
 * Technical Support: Forum - http://www.thePHPfactory.com/forum/
-------------------------------------------------------------------------
*/

defined('_JEXEC') or die;

?>

<div class="mod_blogfactory_post<?php echo $moduleclass_sfx; ?>">
  <ul>
    <?php foreach ($list as $item): ?>
      <li>
        <?php echo ModBlogFactoryPostHelper::renderItem($item, $params); ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

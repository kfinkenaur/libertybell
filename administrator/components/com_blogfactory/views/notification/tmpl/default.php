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

<div class="blogfactory-view view-<?php echo $this->getName(); ?>">
  <form action="<?php echo BlogFactoryRoute::_('view=' . $this->getName() . '&id=' . (int)$this->item->id); ?>" method="POST" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)): ?>
      <div id="j-sidebar-container" class="span2"><?php echo $this->sidebar; ?></div>
    <?php endif;?>

    <div id="j-main-container" class="<?php echo !empty($this->sidebar) ? 'span10' : ''; ?>">
      <div class="row-fluid">
        <div class="span4">
          <?php echo $this->loadFieldset('details'); ?>
        </div>

        <div class="span8">
          <?php echo $this->loadFieldset('content'); ?>
        </div>
      </div>
    </div>

    <input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
  </form>
</div>

<?php


class SupsysticSliderPro_Settings_Module extends SupsysticSlider_Settings_Module
{
    public function onInit()
    {
    	parent::onInit();
        $this->setOverloadController(true);
    }

    public function getTemplatesAliases()
    {
        return array(
            'settings.index' => '@settings_pro/index.twig'
        );
    }
}
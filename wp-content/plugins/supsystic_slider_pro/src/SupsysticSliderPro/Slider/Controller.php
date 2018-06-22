<?php


class SupsysticSliderPro_Slider_Controller extends SupsysticSlider_Slider_Controller
{
    /**
     * Constructor.
     *
     * @param Rsc_Environment  $environment
     * @param Rsc_Http_Request $request
     */
    public function __construct(
        Rsc_Environment $environment,
        Rsc_Http_Request $request
    ) {
        parent::__construct(
            $environment,
            $request
        );

        $dispatcher = $this->getEnvironment()->getDispatcher();

        $dispatcher->on(
            SupsysticSlider_Slider_Model_Sliders::EVENT_COMPILE,
            array($this->getModel('videos'), 'getSliderVideos')
        );
    }

    protected function getModelAliases()
    {
        return array_merge(
            parent::getModelAliases(),
            array(
                'videos'    => 'SupsysticSliderPro_Photos_Model_Videos',
                'resources' => 'SupsysticSliderPro_Slider_Model_Resources'
            )
        );
    }
} 
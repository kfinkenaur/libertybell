<?php


class SupsysticSliderPro_Slider_Twig_Video extends Twig_Extension
{

    private $youtube;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->youtube = new SupsysticSliderPro_Slider_Youtube();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Twig Video';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('youtube_preview', array(
                $this,
                'getYoutubePreview'
            ))
        );
    }


    /**
     * Returns preview image URL for Youtube video.
     *
     * @param string $videoId
     * @param string $type
     * @return string
     */
    public function getYoutubePreview($videoId, $type = null)
    {
        return $this->youtube->getPreview($videoId, $type);
    }
}
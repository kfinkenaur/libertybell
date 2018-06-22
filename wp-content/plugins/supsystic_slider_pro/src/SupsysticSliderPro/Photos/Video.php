<?php


class SupsysticSliderPro_Photos_Video implements SupsysticSliderPro_Photos_VideoInterface
{

    /**
     * @var array
     */
    protected $available;

    /**
     * @var SupsysticSliderPro_Photos_VideoInterface
     */
    protected $handler;

    protected $serviceName;

    /**
     * Constructor.
     *
     * @param string $url Video URL.
     */
    public function __construct($url)
    {
        $this->available = array(
            'youtube',
            'vimeo'
        );

        $this->serviceName = $this->identify($url);

        if($this->serviceName == 'youtube') {
            $this->handler = new SupsysticSliderPro_Photos_Youtube($url);
        } else {
            $this->handler = new SupsysticSliderPro_Photos_Vimeo($url);
        }
    }

    /**
     * Returns video id.
     *
     * @return string|int
     */
    public function getId()
    {
        return $this->handler->getId();
    }

    public function getServiceName() {

        return $this->serviceName;
    }

    /**
     * Returns URL to the thumbnail of the video.
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        return $this->handler->getThumbnailUrl();
    }

    /**
     * Returns video URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->handler->getUrl();
    }

    /**
     * Returns video title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->handler->getTitle();
    }

    protected function identify($url)
    {
        foreach ($this->available as $service) {
            //$pattern = sprintf('/%s/i', $service);

            if (strpos($url, $service)) {
                return $service;
            }
        }

        return null;
    }
}
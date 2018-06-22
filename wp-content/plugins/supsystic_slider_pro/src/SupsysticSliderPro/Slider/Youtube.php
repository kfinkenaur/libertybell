<?php


class SupsysticSliderPro_Slider_Youtube
{

    const TYPE_DEFAULT        = 'default';
    const TYPE_HIGH           = 'hqdefault';
    const TYPE_MEDIUM         = 'mqdefault';
    const TYPE_STANDART       = 'sddefault';
    const TYPE_MAX_RESOLUTION = 'maxresdefault';
    const BASE_URL            = 'http://img.youtube.com/vi';
    const EXTENSION           = 'jpg';

    /**
     * Returns preview URL for the YouTube.com video.
     *
     * @param string $videoId Video Id.
     * @param string $type    Preview thumbnail quality.
     * @return string
     */
    public function getPreview($videoId, $type = self::TYPE_DEFAULT)
    {
        $types = array(
            self::TYPE_DEFAULT,
            self::TYPE_HIGH,
            self::TYPE_MAX_RESOLUTION,
            self::TYPE_MEDIUM,
            self::TYPE_STANDART
        );

        if (!in_array($type, $types)) {
            $type = self::TYPE_DEFAULT;
        }

        return $this->compilePreview($videoId, $type);
    }

    protected function compilePreview($videoId, $type)
    {
        return self::BASE_URL
        . '/'
        . $videoId
        . '/'
        . $type
        . '.'
        . self::EXTENSION;
    }

} 
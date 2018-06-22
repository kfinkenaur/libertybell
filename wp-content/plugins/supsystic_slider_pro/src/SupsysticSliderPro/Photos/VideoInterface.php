<?php


interface SupsysticSliderPro_Photos_VideoInterface
{
    /**
     * Returns video id.
     *
     * @return string|int
     */
    public function getId();

    /**
     * Returns URL to the thumbnail of the video.
     *
     * @return string
     */
    public function getThumbnailUrl();

    /**
     * Returns video URL.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Returns video title.
     *
     * @return string
     */
    public function getTitle();
}
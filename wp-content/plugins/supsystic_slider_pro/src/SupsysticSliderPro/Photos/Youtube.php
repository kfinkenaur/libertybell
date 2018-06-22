<?php


class SupsysticSliderPro_Photos_Youtube implements SupsysticSliderPro_Photos_VideoInterface
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $thumbnailUrl;

    /**
     * @var string
     */
    protected $title;

    /**
     * Constructor.
     *
     * @param string $url Video URL.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Returns video id.
     *
     * @return string|int
     */
    public function getId()
    {
        if (!$this->id) {
            $queryString = parse_url($this->getUrl(), PHP_URL_QUERY);
            $segments    = $this->queryStringToArray($queryString);

            if (!isset($segments['v'])) {
                $this->id = null;
            }

            $this->id = $segments['v'];
        }

        return $this->id;
    }

    /**
     * Returns URL to the thumbnail of the video.
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        if (!$this->thumbnailUrl) {
            if (!$id = $this->getId()) {
                return null;
            }

            $baseUrl = 'http://img.youtube.com/vi/' . $id . '/';
            $maxRes  = 'maxresdefault.jpg';
            $default = 'default.jpg';

            $this->thumbnailUrl = $baseUrl . $maxRes;

            $response = wp_remote_get($baseUrl . $maxRes);

            if (404 == wp_remote_retrieve_response_code($response)) {
                $this->thumbnailUrl = $baseUrl . $default;
            }
        }

        return $this->thumbnailUrl;
    }

    /**
     * Returns video URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    protected function queryStringToArray($queryString)
    {
        $elements = explode('&', $queryString);
        $query    = array();

        foreach ($elements as $element) {
            $keyValue = explode('=', $element);

            if (is_array($keyValue)) {
                if (count($keyValue) == 1) {
                    $query[$keyValue[0]] = null;
                } elseif (count($keyValue) == 2) {
                    list($key, $value) = $keyValue;

                    $query[$key] = $value;
                }
            }
        }

        return $query;
    }

    /**
     * Returns video title.
     *
     * @return string
     */
    public function getTitle()
    {
        if (!$this->title) {
            $pattern  = 'http://gdata.youtube.com/feeds/api/videos/%s?v=2&alt=jsonc';

            if (!$id = $this->getId()) {
                return null;
            }

            $response = json_decode(
                file_get_contents(sprintf($pattern, $id)),
                true
            );

            if (!is_array($response)) {
                return null;
            }

            if (!isset($response['data'])) {
                return null;
            }

            $data = $response['data'];

            if (isset($data['title'])) {
                $this->title = $data['title'];
            }
        }

        return $this->title;
    }
}
<?php


class SupsysticSliderPro_Photos_Vimeo implements SupsysticSliderPro_Photos_VideoInterface
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

	protected $_clientId = '0ab83ce5b4ee0b0c52ce8e4f7bf3ac3125244043';
	protected $_clientSecrets = 'vMAqHUdxflSuTFMhfvZ+ewyXbnTqQdYaW8kak3aOIJhel8q4Ptc+LpeFbcUXCI2owV0r0IKYBaC8zqMVMKNXHUDiNA6eGVUWcCCE/YSqZFcV7Tuo3DONtncmE1vkY79T';
	protected $_clientAccessToken = '30186826041a804bfc0fd892ab7222ab';

    /**
     * Returns video id.
     *
     * @return string|int
     */
    public function getId()
    {
		$urlPattern = '`(https?:\/\/)?(www.)?(player.)?vimeo.com/([a-z]*/)*([0-9]{6,11})[?]?.*`';
		$videoUrl = $this->getUrl();
		$this->id = null;

		if(preg_match($urlPattern, $videoUrl, $output_array)) {

			$vimeoApi = new SupsysticSliderPro_Photos_vendors_vimeo_api_Vimeo($this->_clientId, $this->_clientSecrets, $this->_clientAccessToken);
			$reqResult = $vimeoApi->request('/videos/' . $output_array[5], array());

			$this->id = $output_array[5];
			if($reqResult['status'] == 200) {

				if(!empty($reqResult['body']['name'])) {
					$this->title = $reqResult['body']['name'];
				} else {
					$this->title = null;
				}
			}
		}
		return $this->id;

		// NOT WORKING
//        if (!$this->id) {
//            $queryString = parse_url($this->getUrl());
//            $url = 'https://vimeo.com/api/oembed.json?url=https%3A//' . $queryString['host'] . $queryString['path'];
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            $result = curl_exec($ch);
//            curl_close($ch);
//            $result = json_decode($result, true);
//
//            if (!isset($result['video_id'])) {
//                $this->id = null;
//            }
//
//            if (!isset($result['title'])) {
//                $this->title = null;
//            } else {
//                $this->title = $result['title'];
//            }
//
//            $this->id = $result['video_id'];
//        }
//
//        return $this->id;
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

            $baseUrl = 'http://vimeo.com/api/v2/video/' . $id . '.php';
            $resolution = 'thumbnail_small';

            $hash = unserialize(file_get_contents($baseUrl));

            $response = wp_remote_get($hash[0][$resolution]);

            if (200 == wp_remote_retrieve_response_code($response)) {
                $this->thumbnailUrl = $hash[0][$resolution];
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
        return $this->title;
    }
}
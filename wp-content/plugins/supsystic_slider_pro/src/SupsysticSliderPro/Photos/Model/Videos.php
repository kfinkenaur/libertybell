<?php


class SupsysticSliderPro_Photos_Model_Videos extends SupsysticSlider_Core_BaseModel
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->table = $this->db->prefix . 'rs_videos';
    }

    public function getFromMainScope()
    {
        return $this->getFromFolder(0);
    }

    public function getFromFolder($folderId)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('folder_id', '=', (int)$folderId);

        if (!$videos = $this->db->get_results($query->build())) {
            $this->setLastError($this->db->last_error);

            return false;
        }

        // Rewrite for extending.
        foreach ($videos as $video) {
            $attachment = wp_prepare_attachment_for_js($video->attachment_id);

            $video->attachment = $attachment;
        }

        return $videos;
    }

    public function getById($id)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from($this->getTable())
            ->where('id', '=', (int)$id);

        $video = $this->db->get_row($query->build());

        if (!$video) {
            return null;
        }

        $video->attachment = wp_prepare_attachment_for_js($video->attachment_id);

        return $video;
    }

    public function getByVideoId($id)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from($this->getTable())
            ->where('attachment_id', '=', (int)$id);

        $video = $this->db->get_row($query->build());

        if (!$video) {
            return null;
        }

        $video->attachment = wp_prepare_attachment_for_js($video->attachment_id);

        return $video;
    }

    public function getSliderVideos($slider)
    {
        $videos = array();

        if (!is_object($slider)) {
            throw new InvalidArgumentException(sprintf(
                'Parameter 1 must be a object, %s given.',
                gettype($slider)
            ));
        }

        if (!property_exists($slider, 'resources')) {
            // Nothing to process
            return $slider;
        }


        if (!is_array($slider->resources)) {
            throw new InvalidArgumentException(sprintf(
                'The "resources" property must be an array, %s given.',
                gettype($slider->resources)
            ));
        }

        foreach ($slider->resources as $resource) {
            if ($resource->resource_type === 'video') {
                $video = $this->getById($resource->resource_id);
                $video->rid = $resource->id;

                $videos[] = $video;
            }
        }

        if (property_exists($slider, 'videos')) {
            $slider->videos = array_merge($slider->videos, $videos);
        } else {
            $slider->videos = $videos;
        }

        return $slider;
    }

    /**
     * @param string|SupsysticSliderPro_Photos_VideoInterface $video Video URL or
     *                                                           instance of the video handler.
     *
     * @return bool
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function add($video)
    {
        if (!$video instanceof SupsysticSliderPro_Photos_VideoInterface) {
            if (!filter_var($video, FILTER_VALIDATE_URL)) {
                throw new InvalidArgumentException(
                    'Parameter 1 must be a valid URL or instance of the ' .
                    'SupsysticSliderPro_Photos_VideoInterface'
                );
            }

            $video = new SupsysticSliderPro_Photos_Video($video);
        }

        $uploads    = wp_upload_dir();
        $uploadPath = $uploads['path'];
		$urlPath = $uploads['url'] . '/' . $video->getId() . '.jpg';
		$filePath = $uploads['path'] . '/' . $video->getId() . '.jpg';

        if (!is_writable($uploadPath)) {
            throw new RuntimeException(sprintf(
                'Directory %s is not writable.',
                $uploadPath
            ));
        }

        $videoUrl = $video->getThumbnailUrl();

        $response = wp_remote_get($videoUrl);

        if (200 !== wp_remote_retrieve_response_code($response)) {
            throw new RuntimeException(sprintf(
                'Failed tp download thumbnail: %s',
                $videoUrl
            ));
        }

        $thumbnail = wp_remote_retrieve_body($response);

        if (false === @file_put_contents($filePath, $thumbnail)) {
            throw new RuntimeException(sprintf(
                'Failed to upload thumbnail to the %s',
                $filePath
            ));
        }

        $attachment = array(
            'guid'           => $urlPath,
            'post_mime_type' => 'image/jpg',
            //'post_title'     => $video->getTitle(),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        $attachmentId = wp_insert_attachment($attachment, $filePath, 0);

        if ($attachmentId === 0) {
            throw new RuntimeException('Failed to save WordPress attachment.');
        }

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $metadata = wp_generate_attachment_metadata($attachmentId, $filePath);
        wp_update_attachment_metadata($attachmentId, $metadata);

        $query = $this->getQueryBuilder()
            ->insertInto($this->table)
            ->fields('folder_id', 'attachment_id', 'video_id', 'url')
            ->values(0, $attachmentId, $video->getId(), $video->getUrl());

        if (!$this->db->query($query->build())) {
            $this->setLastError($this->db->last_error);

            return false;
        }

        $this->setInsertId($this->db->insert_id);

        return $attachmentId;
    }
} 
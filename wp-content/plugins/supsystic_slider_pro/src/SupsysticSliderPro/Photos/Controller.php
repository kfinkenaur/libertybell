<?php


class SupsysticSliderPro_Photos_Controller extends SupsysticSlider_Photos_Controller
{

    /**
     * {@inheritdoc}
     */
    protected function getModelAliases()
    {
        return array_merge(
            parent::getModelAliases(),
            array(
                'resources' => 'SupsysticSliderPro_Slider_Model_Resources',
                'videos'    => 'SupsysticSliderPro_Photos_Model_Videos',
                'sliders'   => 'SupsysticSlider_Slider_Model_Sliders'
            )
        );
    }

    /**
     * Index Action
     *
     * Shows the list of the all photos
     */
    public function indexAction(Rsc_Http_Request $request)
    {
        if ('gird-gallery-images' === $request->query->get('page')) {
            $redirectUrl = $this->generateUrl('photos');

            return $this->redirect($redirectUrl);
        }

        $folders  = $this->getModel('folders');
        $photos   = $this->getModel('photos');
        $videos   = $this->getModel('videos');
        $position = $this->getModel('position');

        $images = array_map(
            array($position, 'setPosition'),
            $photos->getAllWithoutFolders()
        );

        return $this->response(
            '@photos/index.twig',
            array(
                'entities' => array(
                    'images'  => $position->sort($images),
                    'folders' => $folders->getAll(),
                    'videos'  => $videos->getFromMainScope(),
                ),
                'view_type' => $request->query->get('view', self::STD_VIEW),
                'ajax_url'  => admin_url('admin-ajax.php'),
            )
        );
    }

    /**
     * Imports videos to the slider.
     *
     * @param Rsc_Http_Request $request
     *
     * @return Rsc_Http_Response
     */
    public function importVideoAction(Rsc_Http_Request $request)
    {
        $url = $request->post->get('url');
        $sliderId = $request->post->get('id');
        $slider = $this->getModel('sliders')->getById($sliderId);


        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData('Invalid URL specified.')
            );
        }

        if (!$service = $this->getServiceName($url)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    'Plugin supports only Youtube and Vimeo URLs.'
                )
            );
        }

        if($slider->plugin == 'jssor' && $service!='youtube') {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    'Jssor slider supports only youtube videos'
                )
            );
        }

        $videos = $this->getVideos();
        $resources = $this->getModel('resources');

        try {
            $videoId = $videos->add($url);
        } catch (Exception $e) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    sprintf('Error while import video: %s', $e->getMessage())
                )
            );
        }

        $videoId = $videos->getByVideoId($videoId)->id;
        if($sliderId && $videoId) {
            $resources->addVideo($sliderId, $videoId);
            $message = 'Successfully attached to slider';
            $this->getModule('cache')->clean($sliderId);
        } else {
            $message = 'Error importing video to Slider';
        }

        return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getSuccessResponseData(
                $message,
                array(
                    'service' => $service,
                    'url'     => $url,
                    'html'    => $this->renderVideo($videos->getInsertId())
                )
            )
        );
    }

    public function getServiceName($url)
    {
        $services = array('youtube', 'vimeo');
        $url      = strtolower($url);

        foreach ($services as $service) {
            if (preg_match(sprintf('/%s/', $service), $url)) {
                return $service;
            }
        }

        return null;
    }

    protected function renderVideo($videoId)
    {
        $video = $this->getVideos()->getById($videoId);

        if (!$video) {
            return null;
        }

        return $this->getEnvironment()
            ->getTwig()
            ->render(
                '@ui/list/video.twig',
                array(
                    'video' => $video,
                )
            );
    }

    /**
     * @return SupsysticSliderPro_Photos_Model_Videos
     */
    protected function getVideos()
    {
        return $this->getModel('videos');
    }

	/**
	 * Add Action
	 * Adds new photos to the database
	 *
	 * @param Rsc_Http_Request $request
	 * @return Rsc_Http_Response
	 */
	public function addAction(Rsc_Http_Request $request)
	{
		$env = $this->getEnvironment();
		$resources = $this->getModel('resources');
		$sliders = $this->getModel('sliders');

		$photos = new SupsysticSlider_Photos_Model_Photos();
		if ($env->getConfig()->isEnvironment(
			Rsc_Environment::ENV_DEVELOPMENT
		)
		) {
			$photos->setDebugEnabled(true);
		}

		$attachment = get_post($request->post->get('attachment_id'));
		$viewType = $request->post->get('view_type');
		$sliderId = $request->post->get('id');


		$stats = $this->getEnvironment()->getModule('stats');
		$stats->save('photos.add');

		if (!$photos->add($attachment->ID, $request->post->get('folder_id', 0))) {
			$response = array(
				'error'   => true,
				'photo'   => null,
				'message' => sprintf(
					$env->translate('Unable to save chosen photo %s: %s'),
					$attachment->post_title,
					$photos->getLastError()
				),
			);
		} else {

			if($sliderId && $imageId = $photos->getByAttachmentId($attachment->ID)->id) {
				$cur_slider_obj = $sliders->getById($sliderId);

				if($cur_slider_obj->plugin === 'comparison'){
					$cur_slider_resorse = $resources->getBySliderId($sliderId);
					$count = 0;
					foreach ( $cur_slider_resorse as $resorce ){
						if( $resorce->resource_type === 'image'){
							$count++;
						}
					}
					if($count < 2){
						$resources->add($sliderId, 'image', $imageId);
					}else{
						$message = 'Error - your can upload only two photos';
					}
				}else{
					$resources->add($sliderId, 'image', $imageId);
					$attachmentImage = wp_get_attachment_image_src($attachment->ID, array('60', '60'));
					$imageUrl = $attachmentImage[0];
					$message = '<img src="' . $imageUrl . '"/>Image was successfully imported to the Slider';
					$this->getModule('cache')->clean($sliderId);
				}
			} else {
				$message = 'Error importing image %s to Slider';
			}

			$response = array(
				'error'   => false,
				'message' => sprintf(
					$env->translate($message),
					$attachment->post_title
				),
			);
		}
		return $this->response(Rsc_Http_Response::AJAX, $response);
	}
}
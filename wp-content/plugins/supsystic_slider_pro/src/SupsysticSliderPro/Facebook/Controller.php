<?php


class SupsysticSliderPro_Facebook_Controller extends SupsysticSlider_Core_BaseController
{

    /**
     * Index page of the Facebook module.
     * If user is not authorized yet, then we ask for authorization.
     * Otherwise we show page about current user.
     *
     * @return Rsc_Http_Response
     */

    protected function getModelAliases()
    {
        return array(
            'photos' => 'SupsysticSlider_Photos_Model_Photos',
            'slider' => 'SupsysticSlider_Slider_Model_Sliders',
        );
    }

    public function indexAction(Rsc_Http_Request $request)
    {
        $sliderId = $request->query->get('id');
		$sliders = new SupsysticSlider_Slider_Model_Sliders;
        $id = get_option('facebook_slider_id');
        if($sliderId) {
            if($sliderId != $id) {
                update_option('facebook_slider_id', $sliderId);
            }
        } else {
			$sliderId = $id;
        }

        if (!get_option('facebook_token')) {
            return $this->redirect(
                $this->generateUrl('facebook', 'authorization')
            );
        }

        return $this->response(
            '@facebook/index.twig',
            array(
                'images' => get_option('facebook_photos'), 'id' => $sliderId, 'sliderName' => $sliders->getById($sliderId)->title
            )
        );
    }

    /**
     * Asks user to authorize with Facebook.
     *
     * @return Rsc_Http_Response
     */
    public function authorizationAction()
    {
        $client = $this->getClient();

        try {
            return $this->response(
                '@facebook/authorization.twig',
                array('url' => $client->getAuthorizationUrl())
            );
        } catch (Exception $e) {
            return $this->response(
                'error.twig',
                array('message' => $e->getMessage())
            );
        }
    }

    public function completeAction(Rsc_Http_Request $request)
    {
        $code = $request->query->get('code');
        update_option('facebook_token', $code);

        if (!$code) {
            $message = $this->translate('Authorization code is not specified.');

            return $this->response(
                'error.twig',
                array(
                    'message' => $message,
                )
            );
        }

        try {
            $client = $this->getClient();
            $client->startLoginSession($code);
            update_option('facebook_photos', $client->getUserPhotos());
        } catch (Exception $e) {
            return $this->response(
                'error.twig',
                array(
                    'message' => $e->getMessage(),
                )
            );
        }

        return $this->redirect($this->generateUrl('facebook'));
    }

    public function saveAction(Rsc_Http_Request $request)
    {
        $selectedImages = $request->post->get('urls');
        $photos = $this->getModel('photos');
        $attachID = array();
        $photoId = array();

        $userImages = get_option('facebook_photos');

        foreach ($userImages as $image) {
            if (in_array($image, $selectedImages))
                $attachID[] = $this->media_sideload_image($image, 0);
        }

        foreach ($attachID as $id) {
            $photos->add($id);
            $photoId[] = $photos->getByAttachmentId($id)->id;
        }


        return $this->response(Rsc_Http_Response::AJAX, array('msg' => 'Loaded', 'ids' => $photoId));
    }

    public function refreshAction(Rsc_Http_Request $request)
    {
        $savedThumbs = get_option('facebook_photos');
        $client = $this->getClient();
        $thumbs = $client->getUserPhotos('refresh');

        foreach ($thumbs as $url) {
            if (!in_array($url, $savedThumbs)) {
                $images[] = $url;
            }
        }
        update_option('facebook_photos', $thumbs);
        return $this->response(Rsc_Http_Response::AJAX, array('images' => $images));
    }

    public function listAction(Rsc_Http_Request $request)
    {

        return $this->response(
            Rsc_Http_Response::AJAX,
            array(
                'galleries' => $this->getModel('galleries')->getList(),
            )
        );

    }

    public function media_sideload_image($file, $post_id, $desc = null)
    {
        if (!empty($file)) {
            // Set variables for storage, fix file filename for query strings.
            preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches);
            $file_array = array();
            $file_array['name'] = basename($matches[0]);

            // Download file to temp location.
            $file_array['tmp_name'] = download_url($file);

            // If error storing temporarily, return the error.
            if (is_wp_error($file_array['tmp_name'])) {
                return $file_array['tmp_name'];
            }

            // Do the validation and storage stuff.
            $id = media_handle_sideload($file_array, $post_id, $desc);

            // If error storing permanently, unlink.
            if (is_wp_error($id)) {
                @unlink($file_array['tmp_name']);
                return $id;
            }

            $src = wp_get_attachment_url($id);
        }

        // Finally check to make sure the file has been saved, then return the HTML.
        if (!empty($src)) {
            $alt = isset($desc) ? esc_attr($desc) : '';
            $html = "<img src='$src' alt='$alt' />";
            return $id;
        }
    }

    public function logoutAction()
    {
        delete_option('facebook_token');
        delete_option('facebook_photos');

        @session_destroy();

        return $this->redirect($this->generateUrl('facebook'));
    }

    /**
     * @return GridGallery_Facebook_Client
     */
    protected function getClient()
    {
        /** @var GridGallery_Facebook_Module $facebook */
        $facebook = $this->getModule('facebook');

        return $facebook->getClient();
    }

} 
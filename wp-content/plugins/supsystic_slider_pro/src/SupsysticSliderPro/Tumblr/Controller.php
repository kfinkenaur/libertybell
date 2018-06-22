<?php


class SupsysticSliderPro_Tumblr_Controller extends SupsysticSlider_Core_BaseController
{

    /**
     * Index page of the Tumblr module.
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
        $id = get_option('tumblr_slider_id');
        if($sliderId) {
            if($sliderId != $id) {
                update_option('tumblr_slider_id', $sliderId);
            }
        } else {
			$sliderId = $id;
        }

        if (!get_option('tumblr_token')) {
            return $this->redirect(
                $this->generateUrl('tumblr', 'authorization')
            );
        }

        return $this->response(
            '@tumblr/index.twig',
            array(
                'images' => get_option('tumblr_photos'), 'id' => $sliderId, 'sliderName' => $sliders->getById($sliderId)->title
            )
        );
    }

    /**
     * Asks user to authorize with Tumblr.
     *
     * @return Rsc_Http_Response
     */
    public function authorizationAction()
    {
        $client = $this->getClient();

        try {
            return $this->response(
                '@tumblr/authorization.twig',
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
        $oauth_verifier = $request->query->get('oauth_verifier');
        $oauth_token = $request->query->get('oauth_token');
        $oauth_token_secret = $request->query->get('oauth_token_secret');

        if (!$oauth_verifier) {
            $message = $this->translate('Authorization oauth_verifier is not specified.');

            return $this->response(
                'error.twig',
                array(
                    'message' => $message,
                )
            );
        }

        try {
            $client = $this->getClient();
            $tumblr = $client->getTumblr($oauth_verifier, $oauth_token, $oauth_token_secret);
            update_option('tumblr_photos', $client->getUserPhotos());
        } catch (Exception $e) {
            return $this->response(
                'error.twig',
                array(
                    'message' => $e->getMessage(),
                )
            );
        }

        return $this->redirect($this->generateUrl('tumblr'));
    }

    public function saveAction(Rsc_Http_Request $request)
    {
        $selectedImages = $request->post->get('urls');
        $photos = $this->getModel('photos');

        $userImages = get_option('tumblr_photos');

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
        delete_option('tumblr_token');
        delete_option('tumblr_photos');

        return $this->redirect($this->generateUrl('tumblr'));
    }

    /**
     * @return GridGallery_Tumblr_Client
     */
    protected function getClient()
    {
        /** @var GridGallery_Tumblr_Module $tumblr */
        $tumblr = $this->getModule('tumblr');

        return $tumblr->getClient();
    }

} 
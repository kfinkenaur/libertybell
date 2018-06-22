<?php


class SupsysticSliderPro_License_Controller extends SupsysticSlider_Core_BaseController
{
    public function indexAction(Rsc_Http_Request $request)
    {
        $helper = $this->getHelper();
        $options = $this->getOptions();
        if(!$helper->isActive($options)) {
            return $this->response(
                '@license/index.twig'
            );
        } else {
            $daysLeft = $options->get('license_days_left');
            return $this->response(
                '@license/active.twig',
                array('days' => $daysLeft)
            );
        }
    }

    public function activateAction(Rsc_Http_Request $request) {
        $data = $request->post->all();
        $options = $this->getOptions();
        $status = false;
		$errors = array();

        if($this->getHelper()->activate($data, $options)) {
            $status = true;
		} else {
			$errors = $this->getHelper()->getErrors();
        }

        return $this->response(Rsc_Http_Response::AJAX, array('status' => $status, 'errors' => $errors));
    }

    protected function getOptions()
    {
        return $this->getModule('license')->getOptions();
    }

    protected function getHelper()
    {
        return $this->getModule('license')->getHelper();
    }
	public function dismissNoticeAction(Rsc_Http_Request $request) {
		$this->getOptions()->save('dismiss_pro_opt', 1);	// Just save it
	}
} 
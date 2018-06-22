<?php
global $sgrb;
$sgrb->includeController('Controller');
$sgrb->includeView('Admin');
$sgrb->includeView('Review');
$sgrb->includeView('CommentForm');
$sgrb->includeModel('CommentForm');
$sgrb->includeModel('Review');
$sgrb->includeModel('Comment');
$sgrb->includeModel('Template');
$sgrb->includeModel('Category');
$sgrb->includeModel('Comment_Rating');
$sgrb->includeModel('Rate_Log');
$sgrb->includeCore('Form');

class SGRB_CommentFormController extends SGRB_Controller
{

	public function index()
	{
		global $sgrb;
		$sgrb->includeScript('core/scripts/main');
		$sgrb->includeScript('page/scripts/commentForm/save');
		$sgrb->includeScript('core/scripts/sgrbRequestHandler');
		$form = new SGRB_CommentFormView();
		$createNewUrl = $sgrb->adminUrl('CommentForm/save');

		SGRB_AdminView::render('CommentForm/index', array(
			'createNewUrl' => $createNewUrl,
			'form' => $form
		));
	}

	public function save()
	{
		global $sgrb;
		global $wpdb;
		$sgrb->includeScript('page/scripts/commentForm/save');
		$sgrb->includeScript('core/scripts/main');
		$sgrb->includeScript('core/scripts/sgrbRequestHandler');
		$sgrb->includeStyle('page/styles/commentForm/save');
		$sgrb->includeStyle('page/styles/general/sg-box-cols');
		$sgrbFormId = 0;
		$sgrbDataArray = array();
		$sgrbSaveUrl = $sgrb->adminUrl('CommentForm/save');;

		isset($_GET['id']) ? $sgrbFormId = (int)$_GET['id'] : 0;

		//check if id = 1;my form,don't allow to edit
		$sgrbForm = SGRB_CommentFormModel::finder()->findByPk($sgrbFormId);
		if ($sgrbForm) {
			$title = $sgrbForm->getTitle();
			$options = $sgrbForm->getOptions();
			$options = json_decode($options, true);

			$sgrbDataArray['title'] = $title;
			$sgrbDataArray['options'] = $options;
		}
		else {
			$sgrbForm = new SGRB_CommentFormModel();
		}
		SGRB_AdminView::render('CommentForm/save', array(
			'sgrbFormId' => $sgrbFormId,
			'sgrbSaveUrl' => $sgrbSaveUrl,
			'sgrbDataArray' => $sgrbDataArray
		));
	}

	public function ajaxDelete()
	{
		global $sgrb;
		$id = (int)$_POST['id'];
		SGRB_CommentFormModel::finder()->deleteByPk($id);
		exit();
	}

	public function ajaxSave()
	{
		global $wpdb;
		global $sgrb;
		$sgrbFormId = 0;
		$options = array();
		$sgrbFormNamePrefix = '';
		$defaultTitleName = 'sgrb_addTitle';
		$defaultCommentName = 'sgrb_addComment';
		$defaultUsernameName = 'sgrb_addName';

		if (count($_POST)) {
			$title = @$_POST['title'];
			$mainCreatedFormHtml = @$_POST['mainCreatedFormHtml'];
			$sgrbFormId = (int)$_POST['sgrb-form-id'];
			$form = new SGRB_CommentFormModel();
			$isUpdate = false;
			if ($sgrbFormId) {
				$isUpdate = true;
				$form = SGRB_CommentFormModel::finder()->findByPk($sgrbFormId);
				if (!$form) {
					echo false;
					exit();
				}/*
				$options = $form->getOptions();
				$options = json_decode($options, true);*/
			}

			$index = 0;

			foreach ($mainCreatedFormHtml as $formHtml) {
				$options[$index]['code'] = $formHtml;
				$fieldLabel = $this->getLabel($formHtml);

				$text = preg_match_all("#(\[(sgrb_text +)(.+?)])#", $formHtml);
				if ($text) {
					$sgrbFormNamePrefix = 'sgrb_text_';
					$fieldType = SGRB_FORM_FIELD_TYPE_TEXT;
				}
				$email = preg_match_all("#(\[(sgrb_email +)(.+?)])#", $formHtml);
				if ($email) {
					$sgrbFormNamePrefix = 'sgrb_email_';
					$fieldType = SGRB_FORM_FIELD_TYPE_EMAIL;
				}
				$number = preg_match_all("#(\[(sgrb_number +)(.+?)])#", $formHtml);
				if ($number) {
					$sgrbFormNamePrefix = 'sgrb_number_';
					$fieldType = SGRB_FORM_FIELD_TYPE_NUMBER;
				}
				$textarea = preg_match_all("#(\[(sgrb_textarea +)(.+?)])#", $formHtml);
				if ($textarea) {
					$sgrbFormNamePrefix = 'sgrb_textarea_';
					$fieldType = SGRB_FORM_FIELD_TYPE_TEXTAREA;
				}

				////////
				if (strpos($formHtml, 'as=title') !== false) {
					$options[$index]['name'] = $defaultTitleName;
				}
				else if (strpos($formHtml, 'as=comment') !== false) {
					$options[$index]['name'] = $defaultCommentName;
				}
				else if (strpos($formHtml, 'as=username') !== false) {
					$options[$index]['name'] = $defaultUsernameName;
				}
				else {
					$options[$index]['name'] = $sgrbFormNamePrefix.substr(md5(microtime().$index), 0, 4);
				}
				if (strpos($formHtml, 'hidden') !== false) {
					$options[$index]['show'] = 0;
				}
				else {
					$options[$index]['show'] = 1;
				}
				$options[$index]['type'] = $fieldType;
				$options[$index]['label'] = $fieldLabel['label'];
				$options[$index]['ordering'] = $index;
				$index++;
			}
			$options = json_encode($options);

			$form->setTitle($title);
			$form->setOptions($options);
			$res = $form->save();
			if ($form->getId()) {
				$lastId = $form->getId();
			}
			else {
				if (!$res) return false;
				$lastId = $wpdb->insert_id;
			}
		}
		echo $lastId;
		exit();
	}

	public function ajaxCloseBanner()
	{
		$result = delete_option(SG_REVIEW_BANNER);
		echo $result;
		exit();
	}

	public function getLabel ($attribute)
	{
		$array = explode(' ', $attribute);
		$new_array = array();
		$options = array();

		foreach ($array as $key) {
			$key = explode('=', $key);
			if ($key[0] == 'label') {
				$options['label'] = $key[1];
			}
		}
		return $options;
	}
}
?>

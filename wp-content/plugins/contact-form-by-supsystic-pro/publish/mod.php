<?php
class publishCfs extends moduleCfs {
	public function publish( $fields, $form ) {
		$savePostData = array();
		$supportedKeys = array(
			'post_content' => array('req' => true, 'label' => __('Post Content', CFS_LANG_CODE)),
			'post_title' => array('req' => true, 'label' => __('Post Title', CFS_LANG_CODE)),
			'post_excerpt' => array('req' => false, 'label' => __('Post Excerpt', CFS_LANG_CODE)),
		);
		$addedFields = array();
		$custFields = array();
		foreach($supportedKeys as $k => $kData) {
			if($kData['req'] && (!isset($fields[ $k ]) || empty($fields[ $k ]))) {
				$this->pushError(sprintf(__('Required field %s for post is empty.', CFS_LANG_CODE), $kData['label']));
				continue;
			}
			if(isset($fields[ $k ])) {
				$savePostData[ $k ] = $fields[ $k ];
				$addedFields[] = $k;
			}
		}
		if(isset($form['params']['fields'])) {
			foreach($form['params']['fields'] as $f) {
				$htmlType = $f['html'];
				if(in_array($htmlType, array('submit', 'reset', 'button', 'recaptcha'))) continue;
				$name = $f['name'];
				if(empty($name)) continue;
				if(isset($fields[ $name ]) && !in_array($name, $addedFields)) {
					$custFields[ $name ] = $fields[ $name ];
				}
			}
		}
		if(!$this->haveErrors()) {
			$savePostData['post_status'] = $form['params']['tpl']['pub_post_status'];
			$savePostData['post_type'] = $form['params']['tpl']['pub_post_type'];
			if(isset($form['params']['tpl']['pub_post_category']) && !empty($form['params']['tpl']['pub_post_category'])) {
				$savePostData['post_category'] = $form['params']['tpl']['pub_post_category'];
			}
			$pid = wp_insert_post( $savePostData );
			if($pid && !is_wp_error( $pid )) {
				if(!empty($custFields)) {
					foreach($custFields as $k => $v) {
						update_post_meta($pid, $k, $v);
					}
				}
				return true;
			} else {
				$this->pushError(is_wp_error($pid) ? $pid->get_error_message() : __('There was some problem inserting post to database. Please try it later or with other data / form configuration.'));
			}
		}
		return false;
	}
	public function registrate( $fields, $form ) {
		$res = frameCfs::_()->getModule('wp_subscribe')->getModel()->subscribe( $fields, $form, false, true );
		if( !$res ) {
			$this->pushErrors( frameCfs::_()->getModule('wp_subscribe')->getModel()->getErrors() );
		}
		return $res;
	}
}


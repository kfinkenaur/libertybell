<?php
class fontsPps extends modulePps {
	private $_appendFontsHtml = array();
	private $_loadedFonts = array();
	public function init() {
		parent::init();
		dispatcherPps::addFilter('popupCss', array($this, 'modifyPopupCss'), 10, 2);
		dispatcherPps::addFilter('popupHtml', array($this, 'modifyPopupHtml'), 10, 2);
	}
	public function modifyPopupCss($css, $popup) {
		$this->_appendFontsHtml[ $popup['id'] ] = array();
		$fontKeyToSelector = array(
			'font_label' => '.ppsPopupLabel, .ppsPopupLabel *',
			'font_footer' => '.ppsFootNote',
		);
		$fontColorKeyToSelector = array(
			'label_font_color' => '.ppsPopupLabel, .ppsPopupLabel *',
			'footer_font_color' => '.ppsFootNote',
		);

		if(isset($popup['params']['opts_attrs']['txt_block_number']) && $popup['params']['opts_attrs']['txt_block_number'] > 0 && $popup['params']['opts_attrs']['txt_block_number'] < 100) {
			for($ind1 = 0; $ind1 < $popup['params']['opts_attrs']['txt_block_number']; $ind1++) {
				$fontKeyToSelector['font_txt_' . $ind1] = '.ppsPopupTxt_' . $ind1. ', .ppsPopupTxt_'. $ind1. ' *';
				$fontColorKeyToSelector['text_font_color_' . $ind1] = '.ppsPopupTxt_' . $ind1. ', .ppsPopupTxt_'. $ind1. ' *';
			}
		}

		foreach($fontKeyToSelector as $key => $selector) {
			$font = isset($popup['params']['tpl'][ $key ]) ? $popup['params']['tpl'][ $key ] : false;
			if($font && $font != PPS_DEFAULT) {
				$css .= '#ppsPopupShell_'. $popup['view_id']. ' '. $selector. ' {font-family: '. $font. ' !important;}';
				$this->_addFontUsed($font, $popup['id']);
			}
		}
		foreach($fontColorKeyToSelector as $key => $selector) {
			$fontColor = isset($popup['params']['tpl'][ $key ]) ? $popup['params']['tpl'][ $key ] : false;
			if($fontColor) {
				$css .= '#ppsPopupShell_'. $popup['view_id']. ' '. $selector. ' {color: '. $fontColor. ' !important;}';
			}
		}
		return $css;
	}
	public function modifyPopupHtml($html, $popup) {
		if(isset($this->_appendFontsHtml[ $popup['id'] ]) && !empty($this->_appendFontsHtml[ $popup['id'] ])) {
			$loadFonts = array();
			foreach($this->_appendFontsHtml[ $popup['id'] ] as $font) {
				if(!in_array($font, $this->_loadedFonts)) {
					$this->_loadedFonts[] = $font;
					$loadFonts[] = $font;
				}
			}
			if(!empty($loadFonts)) {
				$html = '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family='. implode('|', array_map('urlencode', $loadFonts)). '">'. $html;
			}
		}
		return $html;
	}
	private function _addFontUsed($font, $pid) {
		if(!isset($this->_appendFontsHtml[ $pid ]))
			$this->_appendFontsHtml[ $pid ] = array();
		if(!in_array($font, $this->_appendFontsHtml[ $pid ]))
			$this->_appendFontsHtml[ $pid ][] = $font;
	}
}
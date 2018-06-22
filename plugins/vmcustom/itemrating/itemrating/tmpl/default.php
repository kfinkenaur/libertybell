<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
	defined('_JEXEC') or die();
	require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
		 $item=new stdClass();
		 $product = $viewData[0];
		$params = $viewData[1];
		$currencyDisplay = CurrencyDisplay::getInstance( );
		
	     $item->id=$product->virtuemart_product_id;
	     $item->introtext=$product->product_s_desc;
	     $item->title=$product->product_name;
	     $item->created=JFactory::getDate($product->created_on)->Format('d-m-Y');
	     $item->modified=JFactory::getDate($product->modified_on)->Format('d-m-Y');
	     $item->author=JFactory::getUser($product->created_by)->name;
	     $item->productcategory=$product->category_name;
	     $item->quantity=$product->quantity;
	     $item->brand=$product->mf_name;
	    $item->productprice=$currencyDisplay->priceDisplay($product->prices['salesPrice'],0,1,false);
		$product_model = VmModel::getModel('product');
		$product_model->addImages($product);
		$image = $product->images[0];
		preg_match_all("/<img .*?(?=src)src=\"([^\"]+)\"/si", $image->displayMediaFull("",false), $m);
		$item->image=str_replace(JURI::base(),'',$m[1][0]);
	    $item->voteallowed=1;
		$currency_model = VmModel::getModel('currency');
		$displayCurrency = $currency_model->getCurrency( $product->prices['product_currency'] );
		$item->currency=$displayCurrency->currency_code_3;
	    $stockhandle = VmConfig::get ('stockhandle', 'none');
				if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') ) {
					$item->quanitity=$product->product_in_stock - $product->product_ordered;
				}
				else
				{
					$item->quanitity=1;	
				}
	     $item->attribs=json_encode(array("groupdata"=>$params->custom_groupdata,'textforscore'=>$params->custom_textforscore,'reviewsummary'=>$params->custom_reviewsummary));
	     
	     $html = ItemratingHelper::loadWidget($item,"top");
		 if(!$html)
		 {
			 $html = ItemratingHelper::loadWidget($item,"bottom");
		 }
		echo $html;
?>

	
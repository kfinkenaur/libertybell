<?php

error_reporting (E_ALL ^ E_NOTICE);

require_once('web_connect.php'); ?>

<?php


$customer = $_REQUEST['option_selection1'];

$amount = $_REQUEST['payment_gross'];

$current_date = date("m/d/y");

$debug_export = var_export($_REQUEST, true);



echo "made it past the connection state for the invoice";





        $Cart_found_records6_find = $WebStore->newFindCommand('StorageBilling_NEW_Table');
		$Cart_found_records6_findCriterions = array('CustomerName'=>$customer,);
		foreach($Cart_found_records6_findCriterions as $key=>$value) {
			$Cart_found_records6_find->AddFindCriterion($key,$value);
		}
		
		fmsSetPage($Cart_found_records6_find,'Cart_found_records6',1000); 
	
		$Cart_found_records6_result = $Cart_found_records6_find->execute(); 
		
		if(FileMaker::isError($Cart_found_records6_result)) {
			
			echo "error finding customer in storage billing table";
			
		}else{
			
		fmsSetLastPage($Cart_found_records6_result,'Cart_found_records6',1000); 
		
		$Cart_found_records6_row = current($Cart_found_records6_result->getRecords());
		
		$job_id = $Cart_found_records6_row->getField('_MovingJobIDfk');
		
		$unit_rec_id = $Cart_found_records6_row->getRecordId();
			
			
		}
		
		
		echo "made it through step 1";
		
		
		
		
		$found_records6_find = $WebStore->newFindCommand('StorageBilling_Invoices');
		$found_records6_findCriterions = array('JobID'=>$job_id,);
		foreach($found_records6_findCriterions as $key=>$value) {
			$found_records6_find->AddFindCriterion($key,$value);
		}
		
		fmsSetPage($found_records6_find,'found_records6',1000); 
		
		$found_records6_find->addSortRule('Invoice_Date',1,FILEMAKER_SORT_DESCEND);
	
		$found_records6_result = $found_records6_find->execute(); 
		
		if(FileMaker::isError($found_records6_result)) {
			
			echo "error finding invoice record";
			
		}else{
			
			
		fmsSetLastPage($found_records6_result,'found_records6',1000); 
		
		$found_records6_row = current($found_records6_result->getRecords());
		
		$invoice_balance = $found_records6_row->getField('InvoiceBalance');
		
		echo "BALANCE:" . $invoice_balance;
		
		$my_rec_id = $found_records6_row->getRecordId();
			
			
		}
		
		
		echo "made it through step 2";
		
		
		
		
		
			
			/// --  EDIT THE INVOICE RECORD WITH THE AMOUNT PAID -- //
			
			
			$A_DavesEdit1_edit = $WebStore->newEditCommand('StorageBilling_Invoices',$my_rec_id);
			$A_DavesEdit1_fields = array('AmountPaid'=>$amount,'PayPalDump'=>$debug_export);
			foreach($A_DavesEdit1_fields as $key=>$value) {
			$A_DavesEdit1_edit->setField($key,$value);
			}
		
			$A_DavesEdit1_result = $A_DavesEdit1_edit->execute(); 
		
			$A_DavesEdit1_row = current($A_DavesEdit1_result->getRecords());
			
			
			echo "made it through step 3";
			
			
			
			
			
				/// --  EDIT THE UNIT RECORD WITH THE LAST PAID DATE -- //
			
			
			$B_DavesEdit1_edit = $WebStore->newEditCommand('StorageBilling_NEW_Table',$unit_rec_id);
			$B_DavesEdit1_fields = array('LastPaymentRec'=>$current_date);
			foreach($B_DavesEdit1_fields as $key=>$value) {
			$B_DavesEdit1_edit->setField($key,$value);
			}
		
			$B_DavesEdit1_result = $B_DavesEdit1_edit->execute(); 
		
			$B_DavesEdit1_row = current($B_DavesEdit1_result->getRecords());
			
			
			echo "made it through step 4";
			
		
				
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>

		<!--	<script language="javascript" type="text/javascript">
			
			window.location.href = 'http://www.libertybellmoving.com';
			
			</script> -->


</body>
</html>

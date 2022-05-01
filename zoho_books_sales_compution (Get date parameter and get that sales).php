<?php
$startDate = $_POST["saleStartDate"] ;
$endDate = $_POST["saleEndDate"] ;

	define("Zoho_Books_Token" , "e960c89076dceb70b3f80f48f51c899f");
	define("Organization_ID" , "48024775");
	set_time_limit(0);
	function get_invoice_total($Date = "" , $Status = ""){
		$total_sale = 0;
		$page = 1;
		$per_page = 200;
		$repeat =false;
		Repeat :
		if ($repeat) {
			$page++;
		}
		$repeat = false;
		$p_true_url = "https://books.zoho.com/api/v3/invoices?organization_id=".Organization_ID."&date=".$Date."&status=$Status&page=$page&per_page=$per_page";
		$p_true1 = curl_init();
		curl_setopt($p_true1, CURLOPT_URL, $p_true_url);
		curl_setopt($p_true1, CURLOPT_HTTPHEADER, array("Authorization: Zoho-authtoken ".Zoho_Books_Token , "Content-Type: application/json;charset=UTF-8") );
		curl_setopt($p_true1, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($p_true1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($p_true1, CURLOPT_TIMEOUT, 60);
		// curl_setopt($p_true1, CURLOPT_POST, 1);
		curl_setopt($p_true1, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($p_true1, CURLOPT_POSTFIELDS, $post);
		$p_true_response = curl_exec($p_true1);
		curl_close($p_true1);
		echo "<pre>";
		
		$response = json_decode($p_true_response);

		if ($response->code == 0) {
			// print_r($response) ;
			$invoices = $response->invoices;
			foreach ($invoices as $key => $invoice) {
				$total_sale += $invoice->total - $invoice->balance;
			}
			if ($response->page_context->has_more_page) {
				$repeat = true;
				goto Repeat;
			}	
		}

		return $total_sale;
	}

	$last = strtotime($startDate);
	$now = strtotime($endDate);
	$datediff = $now - $last;

	$days = round($datediff / (60 * 60 * 24));
	$endDateInDateFormat= date('Y-m-d', strtotime($endDate));
	$total_sale = 0;
	for ($i=1; $i <=$days ; $i++) { 
		$newDate = strtotime("-$i days",strtotime($endDateInDateFormat));
		$Date = date('Y-m-d', $newDate);	
		print_r($Date."</br>") ;
		$total_sale += get_invoice_total($Date , "paid");
		$total_sale += get_invoice_total($Date , "partially_paid");
	}


	$authToken = "ffa79eadb6a409e3f5c3111578b482d3";		
	$updateRequest = "https://people.zoho.com/people/api/forms/xml/sale/updateRecord" ;
	$xml = "<Request><Record><field name='Monthly_Sales'>".$total_sale."</field></Record></Request>";
	$updateRequest_param = "authtoken=" . $authToken . "&inputData=".$xml."&recordId=".$_POST["recordId"] ;

	$ch = curl_init(); curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $updateRequest_param); 
	curl_setopt($ch, CURLOPT_URL, $updateRequest); 
	curl_setopt($ch, CURLOPT_POST, TRUE); curl_setopt($ch, CURLOPT_HEADER, TRUE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	$response = curl_exec($ch); 
	$response_info = curl_getinfo($ch); 
	curl_close($ch); 
	$response_body = substr($response, $response_info['header_size']); 

	var_dump($response_body) ;


?>
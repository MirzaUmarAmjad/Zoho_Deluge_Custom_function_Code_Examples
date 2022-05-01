<?php

require "vendor/autoload.php" ;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\exception\ZCRMException;
require "zohoFunction.php" ;

initialize();


$data = file_get_contents('php://input');;

$data = json_decode($data) ;

$billing = $data->billing ;
$shipping = $data->shipping ;


$accountId = null ;
$contactId = searchContactByEmail($billing->email) ;


if ($contactId == 0) {
    if (!empty($billing->company)) {
    $accountId = createAccount($billing,$shipping) ;
    }
    $contactId = createContact($billing,$shipping,$accountId) ;
}

createInvoice($data,$accountId,$contactId) ;
?>

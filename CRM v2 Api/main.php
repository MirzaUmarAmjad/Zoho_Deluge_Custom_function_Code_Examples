<?php

require "vendor/autoload.php" ;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\crud\ZCRMRecord;


$configuration =array(  "client_id"=>'1000.YODYMYPE1T1V14095VL6BELN0AO1ZH',
                        "client_secret"=>'1b9ad27ab65ff5136d66b2c97594f206709ab578a1',
                        "redirect_uri"=>'https://www.genotecq.com/ZohoDeveloper/controlfreqgsm/redirect.php',
                        "currentUserEmail"=>'noel@controlfreqgsm.com',
                        "token_persistence_path"=>__DIR__."/",
                        "applicationLogFilePath"=>__DIR__."/",
                    );
ZCRMRestClient::initialize($configuration);

$moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Leads"); // To get module instance
        $response = $moduleIns->getRecord("3724227000001590001"); // To get module records
        $record = $response->getData(); // To get response data

		// var_dump($record) ;
        echo $record->getFieldValue("Lead_Status"); // To get particular field value

?>

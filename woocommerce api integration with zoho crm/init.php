<?php

require "vendor/autoload.php" ;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;


$configuration =array(  "client_id"=>'1000.YODYMYPE1T1V14095VL6BELN0AO1ZH',
                        "client_secret"=>'1b9ad27ab65ff5136d66b2c97594f206709ab578a1',
                        "redirect_uri"=>'https://www.genotecq.com/ZohoDeveloper/controlfreqgsm/redirect.php',
                        "currentUserEmail"=>'noel@controlfreqgsm.com',
                        "token_persistence_path"=>__DIR__."/",
                        "applicationLogFilePath"=>__DIR__."/",
                    );
ZCRMRestClient::initialize($configuration);
$oAuthClient = ZohoOAuth::getClientInstance();
$grantToken = "1000.40c046daf75244bae52c18650901f5e1.e0977200c818b3b78f1c2dc67c4e871f";
$oAuthTokens = $oAuthClient->generateAccessToken($grantToken);

var_dump($oAuthTokens) ;

?>

<?php

include 'userclass.php';

function getCustomerRecordsALL()
{
$token = '2a6ada323686a4e058c305809211e738'; //'$this->token;
    $url = "https://recruit.zoho.com/recruit/private/xml/Candidates/getRecordById";
    $param= "authtoken=".$token."&scope=recruitapi&id=434794000000198208&version=2&selectColumns=Candidates(Email,CANDIDATEID,Skill Set)";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

    // FIX THIS
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);        

    $result = curl_exec($ch);
    curl_close($ch);

    // First deal with problem with Simple XML and CDATA
    $sxo = simplexml_load_string($result, null, LIBXML_NOCDATA);
    #$sxo = simplexml_load_string(file_get_contents('testdata.txt'), null, LIBXML_NOCDATA); // TESTING ONLY

    $data = ($sxo->xpath('/response/result/Candidates/row'));

    //Set the variables you're expecting to capture
    $arrVariables = array("Email", "CANDIDATEID", "Skill Set");
    $retArr = NULL;

    foreach($data as $row)                      // Iterate over all the results
    {
        foreach($arrVariables as $arrVar)       // Iterate through the variables we're looking for
        {
            $rowData = ($row->xpath('FL[@val="'.$arrVar.'"]'));
            @$arrReturn[$arrVar] = (string)$rowData[0][0];
        }
        $retArr[] = $arrReturn;
    }

    return $retArr;     
}



$candidateId = 0 ;
$email = "" ;
$skillSet = "" ;
$userDB = new user() ;
$userDB->dbconect();
//function end here
print_r(getCustomerRecordsALL());
foreach (getCustomerRecordsALL() as $key) {
        
        $candidateId = $key['CANDIDATEID'] ;
        $email  = $key['Email'] ;
        $skillSet = $key['Skill Set'] ;
        $userDB->register($candidateId,$email,$skillSet) ;    
}

?>
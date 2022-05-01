<?php

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

function initialize()
{
    $configuration =array(  "client_id"=>'1000.YODYMYPE1T1V14095VL6BELN0AO1ZH',
                        "client_secret"=>'1b9ad27ab65ff5136d66b2c97594f206709ab578a1',
                        "redirect_uri"=>'https://www.genotecq.com/ZohoDeveloper/controlfreqgsm/redirect.php',
                        "currentUserEmail"=>'noel@controlfreqgsm.com',
                        "token_persistence_path"=>__DIR__."/",
                        "applicationLogFilePath"=>__DIR__."/",
                    );
    ZCRMRestClient::initialize($configuration);
}

function searchContactByEmail($emailPara)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contacts"); // To get module instance
        $email= $emailPara;//email id  to search for
        $page=1;//page number
        $perPage=200;//records per page

        try {
        $response = $moduleIns->searchRecordsByEmail($email, $page, $perPage);
        } catch (ZCRMException $ex) {
            return 0;
        }

        $records = $response->getData(); // To get response data
        try {
            foreach ($records as $record) {
                return $record->getEntityId();
                
        } 
    }
        catch (ZCRMException $ex) {
            return 0 ;
        }

}

function createAccount($billing,$shipping)
{
    $moduleIns=ZCRMRestClient::getInstance()->getModuleInstance("Accounts"); //to get the instance of the module
        $records=array();
        $record=ZCRMRecord::getInstance("Accounts",null);  //To get ZCRMRecord instance
        $record->setFieldValue("Account_Name",$billing->company); 
        $record->setFieldValue("Account_Type","Customer"); 
        $record->setFieldValue("Phone",$billing->phone); 

        $record->setFieldValue("Billing_Street",$billing->address_1); 
        $record->setFieldValue("Billing_City",$billing->city); 
        $record->setFieldValue("Billing_State",$billing->state); 
        $record->setFieldValue("Billing_Code",$billing->postcode); 
        $record->setFieldValue("Billing_Country",$billing->country); 

        $record->setFieldValue("Shipping_Street",$shipping->address_1); 
        $record->setFieldValue("Shipping_City",$shipping->city); 
        $record->setFieldValue("Shipping_State",$shipping->state); 
        $record->setFieldValue("Shipping_Code",$shipping->postcode); 
        $record->setFieldValue("Shipping_Country",$shipping->country); 

        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            $recordId =  json_encode($responseIns->getDetails());
            $recordId =  json_decode($recordId);
            return $recordId->id;
        }
}

function createContact($billing,$shipping,$accountId = null)
{
    $moduleIns=ZCRMRestClient::getInstance()->getModuleInstance("Contacts"); //to get the instance of the module
        $records=array();
        $record=ZCRMRecord::getInstance("Contacts",null);  //To get ZCRMRecord instance
        $record->setFieldValue("First_Name",$billing->first_name); 
        $record->setFieldValue("Last_Name",$billing->last_name); 
        $record->setFieldValue("Account_Name",$accountId); 
        $record->setFieldValue("Email",$billing->email); 
        $record->setFieldValue("Phone",$billing->phone); 

        $record->setFieldValue("Mailing_Street",$billing->address_1); 
        $record->setFieldValue("Mailing_City",$billing->city); 
        $record->setFieldValue("Mailing_State",$billing->state); 
        $record->setFieldValue("Mailing_Zip",$billing->postcode); 
        $record->setFieldValue("Mailing_Country",$billing->country); 

        $record->setFieldValue("Other_Street",$shipping->address_1); 
        $record->setFieldValue("Other_City",$shipping->city); 
        $record->setFieldValue("Other_State",$shipping->state); 
        $record->setFieldValue("Other_Zip",$shipping->postcode); 
        $record->setFieldValue("Other_Country",$shipping->country); 

        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            $recordId =  json_encode($responseIns->getDetails());
            $recordId =  json_decode($recordId);
            return $recordId->id;
        }
}


function createProduct($lineItem)
{
    $moduleIns=ZCRMRestClient::getInstance()->getModuleInstance("Products"); //to get the instance of the module
        $records=array();
        $record=ZCRMRecord::getInstance("Products",null);  //To get ZCRMRecord instance
        $record->setFieldValue("Product_Name",$lineItem->name); 
        $record->setFieldValue("Product_Code",$lineItem->sku); 
        $record->setFieldValue("Unit_Price",$lineItem->price); 
        $data = array("Vat"); //for adding in multiselect
        $record->setFieldValue("Tax",$data);

        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            $recordId =  json_encode($responseIns->getDetails());
            $recordId =  json_decode($recordId);
            return $recordId->id;
        }
}

function createShipmentProduct($shipping_line)
{
    $moduleIns=ZCRMRestClient::getInstance()->getModuleInstance("Products"); //to get the instance of the module
    $shiprecords=array();
    $shiprecord=ZCRMRecord::getInstance("Products",null);  //To get ZCRMRecord instance
    $shiprecord->setFieldValue("Product_Name",$shipping_line->method_title); 
    $shiprecord->setFieldValue("Product_Code",$shipping_line->method_id);
    $data = array("Vat"); //for adding in multiselect
    $shiprecord->setFieldValue("Tax",$data);

    array_push($shiprecords, $shiprecord);
    $responseIn = $moduleIns->createRecords($shiprecords);
    foreach ($responseIn->getEntityResponses() as $responseIns) {
        $recordId =  json_encode($responseIns->getDetails());
        $recordId =  json_decode($recordId);
        return $recordId->id;
        }
}

function searchProduct($skuPara)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Products"); // To get module instance
        $criteria="(Product_Code:equals:$skuPara)";//criteria to search for

        try {
        $response = $moduleIns->searchRecordsByCriteria($criteria);
        } catch (ZCRMException $ex) {
            return 0;
        }

        $records = $response->getData(); // To get response data
        try {
            foreach ($records as $record) {
                return $record->getEntityId();
                
        } 
    }
        catch (ZCRMException $ex) {
            return 0 ;
        }

}

function createInvoice($data,$accountId = null,$contactId = null)
{

        $moduleIns=ZCRMRestClient::getInstance()->getModuleInstance("Invoices"); //to get the instance of the module
        $records=array();
        $record=ZCRMRecord::getInstance("Invoices",null);  //To get ZCRMRecord instance
        $record->setFieldValue("Subject","$data->id");
        $record->setFieldValue("Payment_Method_Title",$data->payment_method_title);
        $record->setFieldValue("Account_Name",$accountId); //This function is for Invoices module
        $record->setFieldValue("Payment_Method",$data->payment_method);
        $record->setFieldValue("Contact_Name",$contactId);
        $record->setFieldValue("Status","Created");

        $dateTime = date("Y-m-d",strtotime($data->date_created)) ;
        $record->setFieldValue("Invoice_Date",$dateTime);

        $record->setFieldValue("Billing_Street",$data->billing->address_1); 
        $record->setFieldValue("Billing_City",$data->billing->city); 
        $record->setFieldValue("Billing_State",$data->billing->state); 
        $record->setFieldValue("Billing_Code",$data->billing->postcode); 
        $record->setFieldValue("Billing_Country",$data->billing->country); 

        $record->setFieldValue("Shipping_Street",$data->shipping->address_1); 
        $record->setFieldValue("Shipping_City",$data->shipping->city); 
        $record->setFieldValue("Shipping_State",$data->shipping->state); 
        $record->setFieldValue("Shipping_Code",$data->shipping->postcode); 
        $record->setFieldValue("Shipping_Country",$data->shipping->country); 

        /** Following methods are being used only by Inventory modules **/
        foreach ($data->line_items as $line_item) {
            
        $lineItem=ZCRMInventoryLineItem::getInstance(null);  //To get ZCRMInventoryLineItem instance
        // $lineItem->setDescription("Product_description");  //To set line item description
        // $lineItem ->setDiscount(5);  //To set line item discount
        $lineItem->setListPrice($line_item->price);  //To set line item list price
        
        $taxInstance1=ZCRMTax::getInstance("Vat");  //To get ZCRMTax instance
        $taxInstance1->setPercentage(($line_item->total_tax/$line_item->total)*100);  //To set tax percentage
        $lineItem->addLineTax($taxInstance1);  //To set line tax to line item
        
        //search product or create product
        $productId = searchProduct($line_item->sku) ;
            
        if ($productId == 0) {
            $productId = createProduct($line_item) ;
            $lineItem->setProduct(ZCRMRecord::getInstance("Products",$productId));  //To set product to line item
        }
        else
        {
            $lineItem->setProduct(ZCRMRecord::getInstance("Products",$productId));  //To set product to line item
        }


        $lineItem->setQuantity($line_item->quantity);  //To set product quantity to this line item
        
        $record->addLineItem($lineItem);   //to add the line item to the record
        
        }


        //add shipping
        if (!empty($data->shipping_lines)) {
            foreach ($data->shipping_lines as $shipping_line) {

                $lineItem=ZCRMInventoryLineItem::getInstance(null);  //To get ZCRMInventoryLineItem instance
                $lineItem->setListPrice(intval($shipping_line->total));  //To set line item list price
                
                $taxInstance1=ZCRMTax::getInstance("Vat");  //To get ZCRMTax instance
                $taxInstance1->setPercentage(($shipping_line->total_tax/$shipping_line->total)*100);  //To set tax percentage
                $lineItem->addLineTax($taxInstance1);  //To set line tax to line item
                
                //search product or create product
                $shipId = searchProduct($shipping_line->method_id) ;

                if ($shipId != 0) {
                    $lineItem->setProduct(ZCRMRecord::getInstance("Products",$shipId));  //To set product to line item
                }
                else
                {

                    $shipId = createShipmentProduct($shipping_line) ;
                    $lineItem->setProduct(ZCRMRecord::getInstance("Products","$shipId"));  //To set product to line item
                }


                $lineItem->setQuantity(1);  //To set product quantity to this line item
                
                $record->addLineItem($lineItem);   //to add the line item to the record
        

            }
        }
        
        array_push($records, $record); // pushing the record to the array.
        $responseIn = $moduleIns->createRecords($records); // updating the records.$trigger,$lar_id are optional
        foreach ($responseIn->getEntityResponses() as $responseIns) {
             echo "HTTP Status Code:" . $responseIn->getHttpStatusCode(); // To get http response code
            echo "Status:" . $responseIns->getStatus(); // To get response status
            echo "Message:" . $responseIns->getMessage(); // To get response message
            echo "Code:" . $responseIns->getCode(); // To get status code
            echo "Details:" . json_encode($responseIns->getDetails());
        }

}

?>

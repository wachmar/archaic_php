<?php
session_start();
require('../inc/fce.php');
require('../inc/cfg.php');
if($clearance>0):
if($_POST['process_type']): $process_type = $_POST['process_type']; else: $process_type = $_GET['process_type']; endif;  
    switch ($process_type):
      case "insert":
        $continue = 1;
        $price_per_kg = str_replace(",", ".", $_POST['price_per_kg']);
        $assessed_quantity = str_replace(",", ".", $_POST['assessed_quantity']);
        if(!$_POST['name']){$continue = 0;};
        if(!$_POST['city']){$continue = 0;};
        if(!$_POST['address_main']){$continue = 0;};
        if(!$_POST['address_branch']){$continue = 0;};
        if(!is_numeric($price_per_kg)){$continue = 0;};
        if(!is_numeric($assessed_quantity)){$continue = 0;};
        if(!$_POST['contract_date']){$continue = 0;};
        if($continue):
          $agent = $_SESSION['userid'];
          $customer_type = $_POST['customer_type'];
          $country = $_POST['country'];
          $transaction_type = $_POST['transaction_type']; 
          $name = $_POST['name']; 
          $city = $_POST['city'];
          if($country==1): $province = $_POST['province']; else: $province==0; endif; 
          $address_main = $_POST['address_main']; 
          $address_branch = $_POST['address_branch'];
          $contract = $_POST['contract'];
          $membership_payed = $_POST['membership_payed'];
          $contract_date = $_POST['contract_date'];
          $entry_date = date('Y-m-d');
          $last_change_date = date('Y-m-d H:i:s');
          
          $contact1 = $_POST['contact1']; $cell1 = $_POST['cell1']; $landline1 = $_POST['landline1']; $email1 = $_POST['email1'];
          $contact2 = $_POST['contact2']; $cell2 = $_POST['cell2']; $landline2 = $_POST['landline2']; $email2 = $_POST['email2'];
          $contact3 = $_POST['contact3']; $cell3 = $_POST['cell3']; $landline3 = $_POST['landline3']; $email3 = $_POST['email3'];
          
          $notes = $_POST['notes'];
    
          $sql1 = "INSERT INTO `$db_name`.`aedb_customers` (`Id`, `Customer_type`, `Country`, `Transaction_type`, `Name`, `City`, `Province`, `Address_Main`, `Address_Branch`, `Price_per_kg`, `Contract`, `Membership_payed`, `Agent`, `Assessed_quantity`, `Contract_date`, `Entry_date`, `Last_change_date`, `Contact1`, `Cell1`, `Landline1`, `Email1`, `Contact2`, `Cell2`, `Landline2`, `Email2`, `Contact3`, `Cell3`, `Landline3`, `Email3`, `Notes`) 
                        VALUES (NULL, '$customer_type', '$country', '$transaction_type', '$name', '$city', '$province', '$address_main', '$address_branch', '$price_per_kg', '$contract', '$membership_payed', '$agent', '$assessed_quantity', '$contract_date', '$entry_date', '$last_change_date', '$contact1', '$cell1', '$landline1', '$email1', '$contact2', '$cell2', '$landline2', '$email2', '$contact3', '$cell3', '$landline3', '$email3', '$notes');";
          $vysledek1 = MySql_Db_Query($db_name,$sql1,$conn1); 
        endif;
        header("Location: ../index.php?page=customers"); 
      break;
      case "update":
        $id = $_POST['id'];
        $continue = 1;
        $price_per_kg = str_replace(",", ".", $_POST['price_per_kg']);
        $assessed_quantity = str_replace(",", ".", $_POST['assessed_quantity']);
        if(!$_POST['name']){$continue = 0;};
        if(!$_POST['city']){$continue = 0;};
        if(!$_POST['address_main']){$continue = 0;};
        if(!$_POST['address_branch']){$continue = 0;};
        if(!is_numeric($price_per_kg)){$continue = 0;};
        if(!is_numeric($assessed_quantity)){$continue = 0;};
        if(!$_POST['contract_date']){$continue = 0;};
        if($continue):
          $agent = $_SESSION['userid'];
          $customer_type = $_POST['customer_type'];
          $country = $_POST['country'];
          $transaction_type = $_POST['transaction_type']; 
          $name = $_POST['name']; 
          $city = $_POST['city'];
          if($country==1): $province = $_POST['province']; else: $province==0; endif; 
          $address_main = $_POST['address_main']; 
          $address_branch = $_POST['address_branch'];
          $contract = $_POST['contract'];
          $membership_payed = $_POST['membership_payed'];
          $contract_date = $_POST['contract_date'];
          $entry_date = date('Y-m-d');
          $last_change_date = date('Y-m-d H:i:s');
          
          $contact1 = $_POST['contact1']; $cell1 = $_POST['cell1']; $landline1 = $_POST['landline1']; $email1 = $_POST['email1'];
          $contact2 = $_POST['contact2']; $cell2 = $_POST['cell2']; $landline2 = $_POST['landline2']; $email2 = $_POST['email2'];
          $contact3 = $_POST['contact3']; $cell3 = $_POST['cell3']; $landline3 = $_POST['landline3']; $email3 = $_POST['email3'];
          
          $notes = $_POST['notes'];
    
          $sql1 = "UPDATE `$db_name`.`aedb_customers` SET `Transaction_type` = '$transaction_type',
                    `Name` = '$name',
                    `City` = '$city',
                    `Customer_type` = '$customer_type',
                    `Country` = '$country',
                    `Province` = '$province',
                    `Address_Main` = '$address_main',
                    `Address_Branch` = '$address_branch',
                    `Price_per_kg` = '$price_per_kg',
                    `Contract` = '$contract',
                    `Membership_payed` = '$membership_payed',
                    `Assessed_quantity` = '$assessed_quantity',
                    `Contract_date` = '$contract_date',
                    `Last_change_date` = '$last_change_date',
                    `Contact1` = '$contact1',
                    `Cell1` = '$cell1',
                    `Landline1` = '$landline1',
                    `Email1` = '$email1',
                    `Contact2` = '$contact2',
                    `Cell2` = '$cell2',
                    `Landline2` = '$landline2',
                    `Email2` = '$email2',
                    `Contact3` = '$contact3',
                    `Cell3` = '$cell3',
                    `Landline3` = '$landline3',
                    `Email3` = '$email3',
                    `Notes` = '$notes' WHERE `aedb_customers`.`Id` = $id;";
          $vysledek1 = MySql_Db_Query($db_name,$sql1,$conn1); 
        endif;
        header("Location: ../index.php?page=customers");    
          
      break;
      case "delete":
          $id = $_GET['id']; 
          $sql1 = "DELETE FROM `$db_name`.`aedb_customers` WHERE `aedb_customers`.`Id` = $id";
          $vysledek1 = MySql_Db_Query($db_name,$sql1,$conn1);
          
          $sql1 = "DELETE FROM `$db_name`.`aedb_cases` WHERE `aedb_cases`.`company` = $id";
          $vysledek1 = MySql_Db_Query($db_name,$sql1,$conn1);
          header("Location: ../index.php?page=customers"); 
      break;
    endswitch;
endif;

?>

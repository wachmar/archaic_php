<?php
session_start();
require('../inc/fce.php');
require('../inc/cfg.php');
if($clearance>0):
    if($_POST['process_type']): $process_type = $_POST['process_type']; else: $process_type = $_GET['process_type']; endif; 
    switch ($process_type):
      case "insert":
        $continue = 1;
        $quantity = str_replace(",", ".", $_POST['quantity']);
        $price = str_replace(",", ".", $_POST['price']);
        if(!is_numeric($quantity)){$continue = 0;};
        if(!is_numeric($price)){$continue = 0;};
        if(!$_POST['contact_person']){$continue = 0;};
        if(!$_POST['case_date']){$continue = 0;};
        if($continue):
          $transaction_type = $_POST['transaction_type']; 
          $company = $_POST['company']; 
          $product_type = $_POST['product_type'];
          $transport_method = $_POST['transport_method'];
          $contact_person = $_POST['contact_person'];
          if(is_null($_POST['customer_payed'])): $customer_payed = "NULL"; else:  $customer_payed = $_POST['customer_payed']; endif;
          if(is_null($_POST['agent_payed'])): $agent_payed = "NULL"; else:  $agent_payed = $_POST['agent_payed']; endif;
          $case_date = $_POST['case_date'];
          $last_change_date = date('Y-m-d H:i:s');
          $notes = $_POST['notes'];
          
          $sql1 = "INSERT INTO `$db_name`.`aedb_cases` (`Id`, `Transaction_type`, `Company`, `Product_type`, `Quantity`, `Price`, `Transport_method`, `Contact_person`, `Customer_payed`, `Agent_payed`, `Case_date`, `Last_change_date`, `Notes`) 
                        VALUES (NULL, '$transaction_type', '$company', '$product_type', '$quantity', '$price', '$transport_method', '$contact_person', $customer_payed, $agent_payed, '$case_date', '$last_change_date', '$notes');";
          $vysledek1 = MySql_Db_Query($db_name,$sql1,$conn1); 
        endif;
        header("Location: ../index.php?page=cases"); 
      break;
      case "update":
            $id = $_POST['id'];
            $continue = 1;
            $quantity = str_replace(",", ".", $_POST['quantity']);
            $price = str_replace(",", ".", $_POST['price']);
            if(!is_numeric($quantity)){$continue = 0;};
            if(!is_numeric($price)){$continue = 0;};
            if(!$_POST['contact_person']){$continue = 0;};
            if(!$_POST['case_date']){$continue = 0;};
            if($continue):
              $transaction_type = $_POST['transaction_type']; 
              $company = $_POST['company']; 
              $product_type = $_POST['product_type'];
              $transport_method = $_POST['transport_method'];
              $contact_person = $_POST['contact_person'];
              if($clearance>2): $customer_payed = $_POST['customer_payed']; endif;
              if($clearance>2): $agent_payed = $_POST['agent_payed']; endif;
              $case_date = $_POST['case_date'];
              $last_change_date = date('Y-m-d H:i:s');
              $notes = $_POST['notes'];
           
              echo $sql1 = "UPDATE `$db_name`.`aedb_cases` SET `Transaction_type` = '$transaction_type',
                          `Company` = '$company',
                          `Product_type` = '$product_type',
                          `Quantity` = '$quantity',
                          `Price` = '$price',
                          `Transport_method` = '$transport_method',
                          `Contact_person` = '$contact_person',
                          `Customer_payed` = '$customer_payed',
                          `Agent_payed` = '$agent_payed',
                          `case_date` = '$case_date',
                          `Last_change_date` = '$last_change_date',
                          `Notes` = '$notes' WHERE `aedb_cases`.`Id` = $id;";
            $vysledek1 = MySql_Db_Query($db_name,$sql1,$conn1);
            header("Location: ../index.php?page=cases");
            endif;
      break;
      case "delete": 
              $id = $_GET['id']; 
              $sql1 = "DELETE FROM `$db_name`.`aedb_cases` WHERE `aedb_cases`.`Id` = $id";
              $vysledek1 = MySql_Db_Query($db_name,$sql1,$conn1);
              header("Location: ../index.php?page=cases");
      break;
    endswitch;
endif;

?>

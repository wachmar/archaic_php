<?php
session_start();
require("inc/cfg.php"); 
if($_SESSION['admin_logged']):                                                                            //BEZPEČNOST
    $image      = $_POST['image'];
    $popisek    = $_POST['popisek'];
    $s1         = $_POST['s1'];
    $s2         = $_POST['s2'];
    $secret     = $_POST['secret'];
    $edit       = $_POST['edit'];
    $id         = $_POST['id']; 

   if(!$secret){$secret = 0;}
   $fail = 0;
   if($edit==1):                                                                                          //Nahrání
        define ("MAX_SIZE","1000");
        $uploadedfile = $_FILES['image']['tmp_name']; 
        if(isset($uploadedfile) AND isset($s2)):
            function getExtension($str) {
                                         $i = strrpos($str,".");
                                         if (!$i) { return ""; }
                                         $l = strlen($str) - $i;
                                         $ext = substr($str,$i+1,$l);
                                         return $ext;
                                 }
            $filename = stripslashes($_FILES['image']['name']);                     
            $extension = getExtension($filename);
 		        $extension = strtolower($extension);
 
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
               		{
               			$fail=1;
               		}
               		
            $size=filesize($_FILES['image']['tmp_name']);
            if ($size > MAX_SIZE*1024)
              {
              	$fail=2;
              }
            /* zjisteni nejvyssi id */  
              $conn1 = MySql_Connect($db_server,$db_user,$db_pass);
              $sql2 = "SELECT * FROM fotky ORDER BY id DESC";
              $vysledek2 = MySql_Db_Query($db_name,$sql2,$conn1);
              
              if (!$vysledek2):
              	$fail=3;
              else:
                if(mysql_numrows($vysledek2)>0):
                    $high_id = mysql_result($vysledek2, 0, "id");
                else:
                    $high_id = 0;    
                endif;  
              endif;
            $high_id = $high_id+1;  
            $newname = $high_id.'.'.$extension;
            
            if ($fail==0)
              {
                $uploadedfile = $_FILES['image']['tmp_name'];
                if($extension=="jpg" || $extension=="jpeg" )
                  {
                  $src = imagecreatefromjpeg($uploadedfile);
                  }
                  else if($extension=="png")
                  {
                  $src = imagecreatefrompng($uploadedfile);
                  }
                  else 
                  {
                  $src = imagecreatefromgif($uploadedfile);
                  }
                list($width,$height)=getimagesize($uploadedfile);

                $newwidth=1024;
                $newheight=($height/$width)*$newwidth;
                $tmp=imagecreatetruecolor($newwidth,$newheight);
                
                $newwidth1=640;
                $newheight1=($height/$width)*$newwidth1;
                $tmp1=imagecreatetruecolor($newwidth1,$newheight1);
                
                $newwidth2=150;
                $newheight2=($height/$width)*$newwidth2;
                $tmp2=imagecreatetruecolor($newwidth2,$newheight2);
                
                imagecopyresized($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                
                imagecopyresized($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
                
                imagecopyresized($tmp2,$src,0,0,0,0,$newwidth2,$newheight2,$width,$height);
                                
                $filename = "upload/hq/".$newname;
                $filename1 = "upload/".$newname;
                $filename2 = "upload/thumbs/".$newname;
                
                $saved = imagejpeg($tmp, $filename,100);
                $saved1 = imagejpeg($tmp1,$filename1,100);
                $saved2 = imagejpeg($tmp2,$filename2,100);
                
                imagedestroy($src);
                imagedestroy($tmp);
                imagedestroy($tmp1);
                imagedestroy($tmp2);
              	//$copied = copy($_FILES['image']['tmp_name'], $newname);
              } 
            if (!$saved OR !$saved1): 
            	$fail=5;
            else:
            $sql2 = "INSERT INTO `$db_name`.`fotky` (
                                                                `id` ,
                                                                `kategorie` ,
                                                                `secret` ,
                                                                `popisek` 
                                                                )
                                                                VALUES (
                                                                NULL , '$s2', '$secret', '$popisek'
                                                                );";
            $vysledek3 = MySql_Db_Query($db_name,$sql2,$conn1);
            if (!$vysledek3)
              {
              	$fail=4;
              }
            endif;
            
            
        endif;   
   elseif($edit==2):                                                                                              //Editace
          $fail = 0;
          if(isset($s2) AND isset($id)):
              $conn1 = MySql_Connect($db_server,$db_user,$db_pass);
              $sql2 = "UPDATE `$db_name`.`fotky` SET `popisek` = '$popisek' WHERE `fotky`.`id` = $id;";
              $vysledek2 = MySql_Db_Query($db_name,$sql2,$conn1);
              if(!$vysledek2){$fail = 2;};
          else:
              $fail = 1;  
          endif;       
   elseif($edit==3):                                                                                              //Smazání
          $fail = 0;
          if(isset($id)):
              $conn1 = MySql_Connect($db_server,$db_user,$db_pass);
              $sql2 = "DELETE FROM `$db_name`.`fotky` WHERE `fotky`.`id` = $id";
              $vysledek2 = MySql_Db_Query($db_name,$sql2,$conn1);
              if($vysledek2):
                  $filename  = "upload/".$id.".jpg";
                  $filename1 = "upload/thumbs/".$id.".jpg";
                  unlink($filename);
                  unlink($filename1);
              else:  
                  $fail = 2;    
              endif;
          else:
              $fail = 1;  
          endif;
   endif;   
endif;

header("Location: index.php?s1=$s1&s2=$s2&secret=$secret&fail=$fail&edit=$edit");        
?>

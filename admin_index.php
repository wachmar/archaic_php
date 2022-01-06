<?
include "..\system\pripojeni.php"; pripojeni();
//bezpeènost
session_start();
//rozlišení že jde o administraèní stránky
$admin = 1;

/*DEFAULT SOUBOR*/
$file = "page/prihlasit.php";
$title_plus = "Pøihlášení";

/*KONTORLUJE ZDA JE ÈLOVÌK PØIHLÁŠEN*/
$logged = 0;
if($_SESSION['ip']):
	$sql = "SELECT * FROM admin_users";
	$vysledek = MySQL_Query($sql);
	$pocet_zaznamu = MySQL_NumRows($vysledek);
	for($i=0;$i<$pocet_zaznamu;$i++):
		if(MySQL_Result($vysledek,$i,name)==$_SESSION['name']):
			if(MySQL_Result($vysledek,$i,pass)==$_SESSION['pass']):
				//zaznam o pøihlášení
				$ip = $_SESSION['ip'];
				$_SESSION['user_id'] = $id = MySQL_Result($vysledek,$i,id);
				$sql2 = "UPDATE admin_users
							SET from_ip = '$ip', last_login = now()
							WHERE id = $id";
				$vysledek2 = MySQL_Query($sql2);
				
				//naètení základní stránky
				$file = "page/uvod.php";
				$title_plus = "Úvod";
				$logged = 1;
				//èeština
				//require('inc/autoczech.php');
				
				//stránka
				if($page=="pridat"):
					$file = "page/pridat.php";
					$title_plus = "Pøidání nového záznamu";
				elseif($page=="editovat"):
					$file = "page/editovat.php";
					$title_plus = "Editace existujícího záznamu";
				elseif($page=="img_upload"):
					$file = "page/img_upload.php";
					$title_plus = "Nahrání doplòujících obrázkù";
				elseif($page=="img_delete"):
					$file = "page/img_delete.php";
					$title_plus = "Smazání doplòujících obrázkù";
				elseif($page=="smazat"):
					$file = "page/smazat.php";
					$title_plus = "Smazání záznamu";
				endif;
				//-------
			endif;
		endif;
	endfor;
	if($logged==0):
		$znovu=1;
		session_unset();
		session_destroy();
	endif;
endif;
?>
<?php //nahrání souborù
include "..\_hlavicka.php";
include "..\_fce.php"; 
?>
<!-- výpis - záznam_Start -->    
<br>
<?php //menu
if($logged):
?>
<div class="admin_menu1">
	<span class="admin_menu2"><a href="?page=pridat&<?php echo "s1=$_GET[s1]&s2=$_GET[s2]&s3=$_GET[s3]";?>" target="_self">pøidat</a></span>
	<span class="admin_menu2"><a href="?page=editovat&<?php echo "s1=$_GET[s1]&s2=$_GET[s2]&s3=$_GET[s3]";?>" target="_self">editovat</a></span>
	<span class="admin_menu2"><a href="?page=img_upload" target="_self">upload obrázkù</a></span>
	<span class="admin_menu2"><a href="?page=img_delete" target="_self">smazání obrázkù</a></span>
	<span class="admin_menu2"><a href="?page=smazat" target="_self">smazat</a></span>
	<span class="admin_menu2">&nbsp;</span>
	<span class="admin_menu2"><a href="page/odhlasit.php" target="_self">odhlásit se</a></span>
</div>
<?php
endif;
?>
<div class="podtrzeno"></div>
<div class="text-detail">
<?php
//neúspìšné pøihlášení
if($znovu)echo "<p>Zkuste to prosím znovu!</p>";
//--------------------
require($file);
?><br>
</div>
<div class="podtrzeno"></div>

<!-- výpis - záznam_End  -->    
	
<?php include "..\_paticka.php"; ?>


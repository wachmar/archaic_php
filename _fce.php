<?php

require 'data/js/editor-nastaveni-simple.php';


function g_zaznamy_vypis_zkraceny($s1, $s2, $s3) {
 			global $start;
		if($start):
			$dotaz = " SELECT * FROM zaznamy WHERE (s1 LIKE '$s1') AND (s2 LIKE '$s2') AND (s3 LIKE '$s3') AND id >= $start";
		else:
			$dotaz = " SELECT * FROM zaznamy WHERE (s1 LIKE '$s1') AND (s2 LIKE '$s2') AND (s3 LIKE '$s3') ";
		endif;
			
          $vysledek = MySQL_Query($dotaz);
          $vypsano_zaznamu = mysql_num_rows($vysledek);
			    if ($vypsano_zaznamu > 0) { 
				$till = 5;
				if($vypsano_zaznamu < 5) $till = $vypsano_zaznamu;
       for($i = 1; $i <= $till; $i++) : 
	   	$zaznam = MySQL_Fetch_Array($vysledek);
	   	if($i==1) $start = $zaznam[id];
      	 if ($_GET[s2] == "ubytování" AND $zaznam[odkaz_mp]<>""):
		 	$link = str_replace("http://", "", $zaznam[odkaz_mp]);
		 	$tlac_rezervovat = "<p><a href=\"http://$link\" target=\"_blank\"><img src=\"obrazy/rezervovat.gif\" alt=\"rezervovat\" title=\"rezervovat - $zaznam[titulek]\" border=\"0\" align=\"right\"></a></p>";
		endif;
      	 $url = "?s1=".$_GET[s1]."&detail=".$zaznam[id];
	  
  	  echo   "<!-- výpis - záznam_Hlavièka- Start -->    
  		       <div class=\"nad-obrazkem-cervena\">
  			       <div class=\"odkaz-obr\"><a href=\"$url\" title=\"zobrazit více informací - $zaznam[titulek]\">$zaznam[titulek]</a></div>			
  			       <div class=\"ikony\">$zaznam[ikony_m]</div>		
  		       </div>
  	       <!-- výpis - záznam_Hlavièka - End -->    		
  	       <!-- výpis - záznam_Hlavièka_Obrazek - Start -->    					
  		       <div class=\"obrazek\"><a href=\"$url\"><img src=\"foto/$zaznam[id].jpg\" alt=\"$zaznam[obr_alt]\" title=\"zobrazit více informací - $zaznam[titulek]\" border=\"0\"></a>
  		       </div>
  	       <!-- výpis - záznam_Hlavièka_Obrazek - End -->   
  	       <!-- výpis - záznam_Hlavièka_Text - Start -->   	 				
  	         <div class=\"text\">
  			       <h2 class=\"ruda\"><a href=\"$url\" title=\"zobrazit více informací - $zaznam[titulek] [$zaznam[id]]\">$zaznam[titulek]</a></h2>
   			       <p>$zaznam[nahled_text]</p>".$tlac_rezervovat."  
  	         </div>	 
  	 		       <div class=\"ikony-obrazky\">";	
  			 	     
			$sql2 = "SELECT pocet FROM foto WHERE id = $zaznam[id]";
			$vysledek2 = MySQL_Query($sql2);
			if(mysql_num_rows($vysledek2)>0):
				$pocet = MySQL_Result($vysledek2,0,pocet);
				if($pocet > 6) $pocet = 6;
				for($i2=1;$i2<=$pocet;$i2++):
				 if($i2<10):
				 	$id_obr = "_0".$i2;
				 else:
				 	$id_obr = "_".$i2;
				 endif;
			?>
				<img class="img_vypis_ico" src="foto/<?php echo $zaznam[id].$id_obr;?>.jpg">

		<?php 
			endfor;
		endif;
					   
              echo "</div>
  		       <div class=\"podtrzeno\"></div>";?>
			   <?
		 $tlac_rezervovat = "";
       endfor;
	   
       }
 
}

function g_zaznamy_vypis_detail($s1) {
	$dotaz = " SELECT * FROM zaznamy WHERE (s1 LIKE '$s1') AND s2 LIKE '' AND s3 LIKE ''";
	$vysledek = MySQL_Query($dotaz); // echo $dotaz;
	$vypsano_zaznamu = mysql_num_rows($vysledek);
	if ($vypsano_zaznamu > 0) { 
		while($zaznam = MySQL_Fetch_Array($vysledek)) :         
			if ($_GET[s2] == "ubytování") { $tlac_rezervovat = "<p><a href=\"$zaznam[odkaz_mp]\"><img src=\"obrazy/rezervovat.gif\" alt=\"rezervovat\" title=\"rezervovat - $zaznam[titulek]\" border=\"0\" align=\"right\"></a></p>"; }
			$vypis = "
			<div class=\"nad-obrazkem-cervena\">
			<div class=\"odkaz-obr\">$zaznam[titulek]</div>		
			</div>
			<div class=\"text-detail\">
			<h2 class=\"ruda\">$zaznam[titulek]</h2>
			<p>$zaznam[text]</p>
			<div id=\"obr-detail\">
			<img src=\"foto/oltemare/male/01.jpg\"><img src=\"foto/oltemare/male/02.jpg\"><img src=\"foto/oltemare/male/03.jpg\"><img src=\"foto/oltemare/male/04.jpg\"><img src=\"foto/oltemare/male/05.jpg\"><img src=\"foto/oltemare/male/06.jpg\"><img src=\"foto/oltemare/male/07.jpg\"><img src=\"foto/oltemare/male/08.jpg\"><img src=\"foto/oltemare/male/09.jpg\">
			</div>   
			</div>
			<div class=\"podtrzeno\">
			</div>
			";
			echo $vypis;
		endwhile;
	}
}

function g_zaznamy_vypis_detail2($id){
	$sql = "SELECT * FROM zaznamy WHERE id = $id";
	$vysledek = MySQL_Query($sql);
	$zaznam = MySQL_Fetch_Array($vysledek);
?>
	<div class="nad-obrazkem-cervena">
		<div class="odkaz-obr"><?php echo $zaznam[titulek]?></div>		
	</div>
	<div class="text-detail">
		<h2 class="ruda"><?php echo $zaznam[titulek]?></h2>
		<p>
			<img style="float: left" src="foto/<?php echo $zaznam[id]?>.jpg">
			<?php echo $zaznam[pre_text]?>
		</p>
		<?php
		if($zaznam[odkaz_mp] AND $_GET[s2] == "ubytování"):
			$link = str_replace("http://", "", $zaznam[odkaz_mp]);
		?>
		<p><a href="http://<?php echo $link;?>" target="_blank"><img src="obrazy/rezervovat.gif" title="rezervovat" alt="rezervovat" border="0" align="right"></a></p>
		<?php endif;?>
		<br><br>
		<p><?php echo $zaznam[text]?></p>
		<div id="obr-detail">
			<?php
			$sql2 = "SELECT pocet FROM foto WHERE id = $id";
			$vysledek2 = MySQL_Query($sql2);
			if(mysql_num_rows($vysledek2)>0):
				$pocet = MySQL_Result($vysledek2,0,pocet);
				for($i=1;$i<=$pocet;$i++):
				 if($i<10):
				 	$id_obr = "_0".$i;
				 else:
				 	$id_obr = "_".$i;
				 endif;
			?>
			<a href="<?php echo "full_size.php?id=$zaznam[id]&id_obr=$i&pocet=$pocet";?>" target="_blank" title="full size!!" o>
				<img class="img_detail_maly" src="foto/<?php echo $zaznam[id].$id_obr;?>.jpg">
			</a>
		<?php 
			endfor;
		endif;
		?>
		</div>			
	</div>
	<div class="podtrzeno">
	</div>
<?php
}
?>

<?php include "system\pripojeni.php"; pripojeni(); ?>
<?php
echo "...Vytváøení tabulek potøebných pro chod Palmové riviéry...<br>";
echo "!Nejdøíve je potøeba nastavit ve skriptu <b>system/pripojeni.php</b> databázi a vytvoøit jí ruènì na serveru, další obstará tento skript!";
//-- tabulka zaznamy
$sql = "CREATE TABLE `zaznamy` (
  `id` int(11) NOT NULL auto_increment,
  `s1` varchar(50) default NULL,
  `s2` varchar(50) default NULL,
  `s3` varchar(50) default NULL,
  `titulek` varchar(200) default NULL,
  `nahled_text` text,
  `pre_text` text,
  `text` text,
  `obr_alt` varchar(200) default NULL,
  `tittle` varchar(200) default NULL,
  `keyword` varchar(200) default NULL,
  `content` varchar(200) default NULL,
  `zeme` varchar(20) default NULL,
  `odkaz_mp` varchar(200) default NULL,
  `datum_od` date default '0000-00-00' NOT NULL,
  `datum_do` date default '0000-00-00' NOT NULL,
  `by_user` int(11) default NULL,
  `sluzby` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1250";
@$vysledek = MySQL_Query($sql);
if($vysledek):
	echo "Tabulka záznamy úspìšnì vytvoøena...";
else:
	echo "Tabulku záznamy se nepodaøilo vytvoøit!";;
endif;
echo "<br>";
//-- tabulka foto
$sql = "CREATE TABLE `foto` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pocet` INT( 11 ) NOT NULL 
) ENGINE = MYISAM";
@$vysledek = MySQL_Query($sql);
if($vysledek):
	echo "Tabulka foto úspìšnì vytvoøena...";
else:
	echo "Tabulku foto se nepodaøilo vytvoøit!";;
endif;
echo "<br>";
//-- tabulka admin_users
$sql = "CREATE TABLE `admin_users` (
`id` INT NOT NULL ,
`name` VARCHAR( 100 ) NOT NULL ,
`pass` VARCHAR( 100 ) NOT NULL ,
`last_login` DATETIME NULL ,
`from_ip` VARCHAR( 100 ) NULL ,
PRIMARY KEY ( `id` ) 
) ENGINE = MYISAM";
@$vysledek = MySQL_Query($sql);
if($vysledek):
	echo "Tabulka admin_users úspìšnì vytvoøena...";
else:
	echo "Tabulku admin_users se nepodaøilo vytvoøit!";;
endif;
echo "<br>";
?>

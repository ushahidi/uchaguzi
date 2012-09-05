# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.63)
# Database: simulation
# Generation Time: 2012-09-05 11:28:14 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table county
# ------------------------------------------------------------

DROP TABLE IF EXISTS `county`;

CREATE TABLE `county` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `county_name` varchar(25) NOT NULL,
  `county_layer_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `county` WRITE;
/*!40000 ALTER TABLE `county` DISABLE KEYS */;

INSERT INTO `county` (`id`, `county_name`, `county_layer_file`)
VALUES
	(1,'Baringo','BARINGO.geojson'),
	(2,'Bomet','BOMET.geojson'),
	(3,'Bungoma','BUNGOMA.geojson'),
	(4,'Busia','BUSIA.geojson'),
	(5,'Elgeyo Marakwet','ELGEYO MARAKWET.geojson'),
	(6,'Embu','EMBU.geojson'),
	(7,'Garissa','GARISSA.geojson'),
	(8,'Homabay','HOMABAY.geojson'),
	(9,'Isiolo','ISIOLO.geojson'),
	(10,'Kajiado','KAJIADO.geojson'),
	(11,'Kakamega','KAKAMEGA.geojson'),
	(12,'Kericho','KERICHO.geojson'),
	(13,'Kiambu','KIAMBU.geojson'),
	(14,'Kilifi','KILIFI.geojson'),
	(15,'Kirinyaga','KIRINYAGA.geojson'),
	(16,'Kisii','KISII.geojson'),
	(17,'Kisumu','KISUMU.geojson'),
	(18,'Kitui','KITUI.geojson'),
	(19,'Kwale','KWALE.geojson'),
	(20,'Laikipia','LAIKIPIA.geojson'),
	(21,'Lamu','LAMU.geojson'),
	(22,'Machakos','MACHAKOS.geojson'),
	(23,'Makueni','MAKUENI.geojson'),
	(24,'Mandera','MANDERA.geojson'),
	(25,'Marsabit','MARSABIT.geojson'),
	(26,'Meru','MERU.geojson'),
	(27,'Migori','MIGORI.geojson'),
	(28,'Muranga','MURANGA.geojson'),
	(29,'Nairobi','NAIROBI.geojson'),
	(30,'Nakuru','NAKURU.geojson'),
	(31,'Nandi','NANDI.geojson'),
	(32,'Narok','NAROK.geojson'),
	(33,'Nyamira','NYAMIRA.geojson'),
	(34,'Nyandarua','NYANDARUA.geojson'),
	(35,'Nyeri','NYERI.geojson'),
	(36,'Samburu','SAMBURU.geojson'),
	(37,'Siaya','SIAYA.geojson'),
	(38,'Taita Taveta','TAITA TAVETA.geojson'),
	(39,'Tana River','TANA RIVER.geojson'),
	(40,'Tharaka Nithi','THARAKA NITHI.geojson'),
	(41,'Trans Nzoia','TRANS NZOIA.geojson'),
	(42,'Turkana','TURKANA.geojson'),
	(43,'Uasin Gishu','UASIN-NGISHU.geojson'),
	(44,'Vihiga','VIHIGA.geojson'),
	(45,'Wajir','WAJIR.geojson'),
	(46,'West Pokot','WEST POKOT.geojson'),
	(47,'','');

/*!40000 ALTER TABLE `county` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

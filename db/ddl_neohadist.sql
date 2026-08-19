-- NeoHadits DDL Schema
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `biografi_imam`;
CREATE TABLE `biografi_imam` (
  `bio_id` int(10) NOT NULL AUTO_INCREMENT,
  `bio_imam` varchar(255) DEFAULT NULL,
  `bio_imam_full` varchar(255) CHARACTER SET utf32 DEFAULT NULL,
  `bio_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`bio_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `databab_bukhari`;
CREATE TABLE `databab_bukhari` (
  `id_kitab` int(11) DEFAULT NULL,
  `id_bab` int(11) NOT NULL DEFAULT '0',
  `bab_indonesia` text,
  `bab_arab` text,
  PRIMARY KEY (`id_bab`),
  KEY `id_kitab` (`id_kitab`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `datakitab_bukhari`;
CREATE TABLE `datakitab_bukhari` (
  `id_kitab` int(11) NOT NULL DEFAULT '0',
  `kitab_indonesia` varchar(255) DEFAULT NULL,
  `kitab_arab` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kitab`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `perawi_bukhari`;
CREATE TABLE `perawi_bukhari` (
  `no_urut` int(6) NOT NULL,
  `no_hdt` int(6) NOT NULL,
  `kode_rawi` int(6) NOT NULL,
  PRIMARY KEY (`no_urut`,`no_hdt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `perawi_daftar`;
CREATE TABLE `perawi_daftar` (
  `kode_rawi` int(8) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `quality` int(6) NOT NULL,
  `kalangan` varchar(50) NOT NULL,
  `nasab` varchar(40) NOT NULL,
  `kuniyah` varchar(40) NOT NULL,
  `laqob` varchar(40) NOT NULL,
  `negeri_hidup` varchar(30) NOT NULL,
  `negeri_wafat` varchar(30) NOT NULL,
  `tahun_wafat` varchar(8) NOT NULL,
  `bukhari` int(4) NOT NULL,
  `muslim` int(4) NOT NULL,
  `abudaud` int(4) NOT NULL,
  `tirmidzi` int(4) NOT NULL,
  `nasai` int(4) NOT NULL,
  `ibnumajah` int(4) NOT NULL,
  `ahmad` int(4) NOT NULL,
  `malik` int(4) NOT NULL,
  `darimi` int(4) NOT NULL,
  PRIMARY KEY (`kode_rawi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sanad_bukhari`;
CREATE TABLE `sanad_bukhari` (
  `no_hdt` int(6) NOT NULL,
  `no_urut` int(6) NOT NULL,
  `j1` int(6) NOT NULL,
  `j2` int(6) NOT NULL,
  `j3` int(6) NOT NULL,
  `j4` int(6) NOT NULL,
  `j5` int(6) NOT NULL,
  `j6` int(6) NOT NULL,
  `j7` int(6) NOT NULL,
  `j8` int(6) NOT NULL,
  `j9` int(6) NOT NULL,
  `j10` int(6) NOT NULL,
  `skema` varchar(30) NOT NULL,
  `kedudukan` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tema_bukhari`;
CREATE TABLE `tema_bukhari` (
  `no_hdt` int(11) NOT NULL DEFAULT '0',
  `tema_indonesia` text,
  `tema_arab` text,
  `id_kitab` int(11) DEFAULT NULL,
  `id_bab` int(11) DEFAULT NULL,
  PRIMARY KEY (`no_hdt`),
  KEY `id_kitab_id_bab` (`id_kitab`,`id_bab`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

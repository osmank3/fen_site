-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Sunucu: localhost:3306
-- Çıktı Tarihi: Ağustos 10, 2011 at 02:01 AM
-- Server sürümü: 5.0.77
-- PHP Sürümü: 5.2.6
-- 
-- Veritabanı: `ekveritabani`
-- 

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `fen_ayar`
-- 

CREATE TABLE  `fen_ayar` (
  `anahtar` VARCHAR( 64 ) NOT NULL ,
  `deger` TEXT NULL ,
  PRIMARY KEY (  `anahtar` )
) ENGINE = MYISAM DEFAULT CHARSET=utf8 ;


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `fen_icerik`
-- 

CREATE TABLE `fen_icerik` (
  `id` int(11) NOT NULL auto_increment,
  `k_id` int(11) NOT NULL,
  `baslik` text NOT NULL,
  `adres` text NULL,
  `yazi` text NOT NULL,
  `kategori` text NOT NULL,
  `tarih` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `goster` enum('True','False') NOT NULL default 'True',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `fen_katagori`
-- 

CREATE TABLE  `fen_kategori` (
  `id` VARCHAR( 64 ) NOT NULL ,
  `us_id` VARCHAR( 64 ) NULL ,
  `isim` TEXT NOT NULL ,
  `ustkategori` enum('True','False') NOT NULL default 'False',
  PRIMARY KEY (  `id` )
) ENGINE = MYISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `fen_kullanici`
-- 

CREATE TABLE `fen_kullanici` (
  `id` int(11) NOT NULL auto_increment,
  `isim` text NOT NULL,
  `posta` text NOT NULL,
  `parola` text NOT NULL,
  `aktif` enum('False','True') NOT NULL default 'False',
  `yonetim` enum('False','True') NOT NULL default 'False',
  `bilg_yeni_icerik` enum('False','True') NOT NULL default 'True',
  `bilg_yeni_yorum` enum('False','True') NOT NULL default 'True',
  `bilg_sade_takip` enum('False','True') NOT NULL default 'False',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `fen_yorum`
-- 

CREATE TABLE `fen_yorum` (
  `id` int(11) NOT NULL auto_increment,
  `k_id` int(11) NOT NULL,
  `i_id` int(11) NOT NULL,
  `yazi` text NULL,
  `tarih` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `takip` enum('False','True') NOT NULL default 'True',
  `goster` enum('True','False') NOT NULL default 'True',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

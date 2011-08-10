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
-- Tablo yapısı : `fen_icerik`
-- 

CREATE TABLE `fen_icerik` (
  `id` int(11) NOT NULL auto_increment,
  `k_id` int(11) NOT NULL,
  `baslik` text NOT NULL,
  `adres` text,
  `yazi` text NOT NULL,
  `kategori` text NOT NULL,
  `tarih` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `goster` enum('True','False') NOT NULL default 'True',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `fen_kullanici`
-- 

CREATE TABLE `fen_kullanici` (
  `id` int(11) NOT NULL auto_increment,
  `kullanici` text NOT NULL,
  `isim` text NOT NULL,
  `soyisim` text NOT NULL,
  `posta` text NOT NULL,
  `parola` text NOT NULL,
  `aktif` enum('False','True') NOT NULL default 'False',
  `yonetim` enum('False','True') NOT NULL default 'False',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

-- 
-- Tablo yapısı : `fen_yorum`
-- 

CREATE TABLE `fen_yorum` (
  `id` int(11) NOT NULL auto_increment,
  `k_id` int(11) NOT NULL,
  `i_id` int(11) NOT NULL,
  `yazi` text NOT NULL,
  `tarih` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `goster` enum('True','False') NOT NULL default 'True',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

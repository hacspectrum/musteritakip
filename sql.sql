-- --------------------------------------------------------
-- Sunucu:                       temsilci.com
-- Sunucu sürümü:                10.1.41-MariaDB - MariaDB Server
-- Sunucu İşletim Sistemi:       Linux
-- HeidiSQL Sürüm:               9.5.0.5371
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- tablo yapısı dökülüyor phpscrip_musteri.bolge
CREATE TABLE IF NOT EXISTS `bolge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firma_id` int(11) NOT NULL,
  `bolgeadi` varchar(100) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `birimfiyat` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- phpscrip_musteri.bolge: ~1 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `bolge` DISABLE KEYS */;
INSERT INTO `bolge` (`id`, `firma_id`, `bolgeadi`, `urun_id`, `birimfiyat`) VALUES
	(1, 1, 'Avrupa', 1, 5);
/*!40000 ALTER TABLE `bolge` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.firma
CREATE TABLE IF NOT EXISTS `firma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firmaadi` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `yetkili` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `telefon` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `deger` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `bitis_tarihi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpscrip_musteri.firma: ~0 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `firma` DISABLE KEYS */;
INSERT INTO `firma` (`id`, `firmaadi`, `yetkili`, `email`, `telefon`, `deger`, `bitis_tarihi`) VALUES
	(1, 'DEMO FİRMA', 'ANIL ERGÜL', 'a.ergul@icateknoloji.com', '5351234567', '', '2020-02-12 00:21:58');
/*!40000 ALTER TABLE `firma` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.gunluk
CREATE TABLE IF NOT EXISTS `gunluk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firma_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `durum` int(11) NOT NULL,
  `aciklama` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpscrip_musteri.gunluk: ~0 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `gunluk` DISABLE KEYS */;
/*!40000 ALTER TABLE `gunluk` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.hesap
CREATE TABLE IF NOT EXISTS `hesap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siparis_id` int(11) NOT NULL,
  `tutar` float NOT NULL,
  `fiyat` float NOT NULL,
  `miktar` int(11) NOT NULL,
  `firma_id` int(11) NOT NULL,
  `musteri_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `durum` tinyint(4) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tip` varchar(100) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- phpscrip_musteri.hesap: ~1 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `hesap` DISABLE KEYS */;
INSERT INTO `hesap` (`id`, `siparis_id`, `tutar`, `fiyat`, `miktar`, `firma_id`, `musteri_id`, `urun_id`, `user_id`, `durum`, `tarih`, `tip`, `aciklama`) VALUES
	(1, 4, 5, 1, 5, 1, 2, 1, 0, 1, '2020-02-12 00:56:31', 'SATIS', 'Testtt ');
/*!40000 ALTER TABLE `hesap` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.ozellik
CREATE TABLE IF NOT EXISTS `ozellik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(100) NOT NULL,
  `grup` varchar(100) NOT NULL,
  `deger` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- phpscrip_musteri.ozellik: ~4 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `ozellik` DISABLE KEYS */;
INSERT INTO `ozellik` (`id`, `ad`, `grup`, `deger`) VALUES
	(1, 'A 30', 'paket', '30'),
	(2, 'B 60', 'paket', '60'),
	(3, 'Kg', 'birim', 'Kg'),
	(4, 'Adet', 'birim', 'Adet');
/*!40000 ALTER TABLE `ozellik` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.siparis
CREATE TABLE IF NOT EXISTS `siparis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musteri_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `miktar` int(11) NOT NULL,
  `fiyat` float NOT NULL,
  `tutar` float NOT NULL,
  `aciklama` varchar(200) NOT NULL,
  `durum` int(11) NOT NULL,
  `firma_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- phpscrip_musteri.siparis: ~4 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `siparis` DISABLE KEYS */;
INSERT INTO `siparis` (`id`, `musteri_id`, `user_id`, `urun_id`, `miktar`, `fiyat`, `tutar`, `aciklama`, `durum`, `firma_id`, `created_at`, `updated_at`) VALUES
	(1, 2, 2, 1, 1000, 1, 1000, 'Test Sipari?i', 1, 1, '2020-02-12 00:54:21', '2020-02-12 00:54:45'),
	(2, 2, 2, 2, 333, 3, 999, 'test', 1, 1, '2020-02-12 00:55:10', '2020-02-12 00:55:10'),
	(3, 2, 2, 1, 3, 1, 3, 'tesr 123123', 1, 1, '2020-02-12 00:55:49', '2020-02-12 00:55:49'),
	(4, 2, 2, 1, 5, 1, 5, 'Testtt ', 1, 1, '2020-02-12 00:56:34', '2020-02-12 00:56:34');
/*!40000 ALTER TABLE `siparis` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.urun
CREATE TABLE IF NOT EXISTS `urun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firma_id` int(11) NOT NULL,
  `birim` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `urunadi` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpscrip_musteri.urun: ~2 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `urun` DISABLE KEYS */;
INSERT INTO `urun` (`id`, `firma_id`, `birim`, `urunadi`, `fiyat`) VALUES
	(1, 1, 'Adet', 'Test Ürünü 1', 1),
	(2, 1, 'Adet', 'Test Ürünü 2', 3);
/*!40000 ALTER TABLE `urun` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.urun_fiyat
CREATE TABLE IF NOT EXISTS `urun_fiyat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musteri_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `tip` int(11) NOT NULL,
  `bolge_id` int(11) NOT NULL,
  `firma_id` int(11) NOT NULL,
  `fiyat` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpscrip_musteri.urun_fiyat: ~3 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `urun_fiyat` DISABLE KEYS */;
INSERT INTO `urun_fiyat` (`id`, `musteri_id`, `urun_id`, `tip`, `bolge_id`, `firma_id`, `fiyat`) VALUES
	(1, 0, 2, 0, 0, 1, 3),
	(2, 2, 1, 2, 0, 1, 1),
	(3, 0, 1, 1, 1, 1, 5);
/*!40000 ALTER TABLE `urun_fiyat` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpscrip_musteri.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tip` int(11) NOT NULL DEFAULT '0',
  `email` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `firma_id` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `adres` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `gsm` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `bolge_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `durum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpscrip_musteri.users: ~3 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `tip`, `email`, `firma_id`, `remember_token`, `password`, `adres`, `tel`, `gsm`, `name`, `bolge_id`, `created_at`, `updated_at`, `durum`) VALUES
	(2, 1, 'a.ergul@icateknoloji.com', 1, 'd96P0mKe4feO5I6YUOuqFdjd3m4pXYxLcSQGgkArU5beEXplc7dXPMjpmzBQ', '$2y$10$trz1VRE0PH92YQTidmA7ueITicjs3kJ.KOVn4nElcKEcQJBRTqHTy', '', '', '', 'ANIL', 0, '2020-02-12 00:48:54', '2020-02-11 21:41:54', 1),
	(3, 0, 'xxx@xxx.com', 1, '', '$2y$10$pR.dJYNKIw/OXTDLs7pUx.hsPIU/xZRoUJ62wCPUPVvdcC7qzLQ7u', 'test', '', '35352342342', 'test', 1, '2020-02-11 21:57:28', '0000-00-00 00:00:00', 0),
	(4, 0, '63yusufsari63@gmail.com', 1, '', '$2y$10$dCb07qihom0JEUbbnCoWDuo5rWfaFOwTa2AubS3ejtTkhA2hstFQC', 'antalya', '', '05555555555', 'yusuf sarı', 1, '2020-02-12 16:20:37', '0000-00-00 00:00:00', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

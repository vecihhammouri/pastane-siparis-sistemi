
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `adetler`
--

CREATE TABLE `adetler` (
  `id` int(11) NOT NULL,
  `adetler_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `adetler`
--

INSERT INTO `adetler` (`id`, `adetler_adi`) VALUES
(4, 'Ay Çöreği'),
(3, 'Beze Çikolata'),
(2, 'Beze Frambuaz'),
(1, 'Büyük Acı Badem'),
(5, 'Çatal'),
(8, 'Küçük Tahinli'),
(6, 'Paskalya'),
(9, 'S. Kandil Simidi'),
(7, 'Tahinli Çörek'),
(10, 'Yağlı Simit');

-- --------------------------------------------------------

--
-- Table structure for table `adetler_siparis`
--

CREATE TABLE `adetler_siparis` (
  `id` int(11) NOT NULL,
  `adetler_adet` int(11) NOT NULL,
  `adetler_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `baklava`
--

CREATE TABLE `baklava` (
  `id` int(11) NOT NULL,
  `baklava_adi` varchar(25) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `baklava`
--

INSERT INTO `baklava` (`id`, `baklava_adi`) VALUES
(29, 'Belluriye'),
(35, 'Börek Kıymalı'),
(34, 'Börek Peynirli'),
(18, 'Burma Kad.'),
(21, 'Bülbül Yuva'),
(6, 'Cev. Şöbiyet'),
(2, 'Cevizli Bak.'),
(4, 'Cevizli Burma'),
(9, 'Cevizli Kad.'),
(19, 'Çikolatalı Bak.'),
(20, 'Diabetik Bak.'),
(22, 'Dilber B. Dilim'),
(23, 'Dilber K. Dilim'),
(24, 'Dolama'),
(32, 'Ekmek Kad.'),
(5, 'Ev Baklavası'),
(38, 'Fınd. 500GR PK.'),
(37, 'Fıst. 500GR PK:'),
(33, 'Fıstık Ezm.'),
(1, 'Fıstıklı Bak.'),
(8, 'Fıstıklı Kad.'),
(39, 'Güllaç Büyük'),
(40, 'Güllaç Küçük'),
(41, 'Güllaç Porsiyon'),
(27, 'Halep Kadayıfı'),
(13, 'Havuç Dilimi'),
(11, 'Kare Bak.'),
(3, 'Kaymaklı Bak.'),
(17, 'Kuru Bak.'),
(10, 'Künefe'),
(30, 'Melisa'),
(26, 'Midye'),
(25, 'Özel Şöbiyet'),
(16, 'S.Sarma Badem'),
(15, 'S.Sarma Fıstık'),
(12, 'Sargı Burma'),
(28, 'Sultaniye'),
(7, 'Sütlü Nuriye'),
(31, 'Şekerpare'),
(14, 'Şöbiyet Fıst.'),
(36, 'Tulumba');

-- --------------------------------------------------------

--
-- Table structure for table `baklava_siparis`
--

CREATE TABLE `baklava_siparis` (
  `id` int(11) NOT NULL,
  `baklava_tepsi` int(11) NOT NULL,
  `baklava_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dondurma`
--

CREATE TABLE `dondurma` (
  `id` int(11) NOT NULL,
  `dondurma_adi` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `dondurma`
--

INSERT INTO `dondurma` (`id`, `dondurma_adi`) VALUES
(9, 'Ceviz'),
(2, 'Çikolata'),
(6, 'Çilek'),
(14, 'Fındıklı'),
(3, 'Fıstık'),
(7, 'Frambuaz'),
(4, 'Frutti'),
(13, 'İtalyan Karamel'),
(5, 'Karamel'),
(11, 'Limon'),
(12, 'Muz'),
(10, 'Oreolu'),
(1, 'Sade'),
(8, 'Vişne');

-- --------------------------------------------------------

--
-- Table structure for table `dondurma_siparis`
--

CREATE TABLE `dondurma_siparis` (
  `id` int(11) NOT NULL,
  `dondurma_kg` float NOT NULL,
  `dondurma_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `figurlutek`
--

CREATE TABLE `figurlutek` (
  `id` int(11) NOT NULL,
  `figurlutek_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `figurlutek`
--

INSERT INTO `figurlutek` (`id`, `figurlutek_adi`) VALUES
(5, 'Akıllı Fil'),
(1, 'Elsa'),
(3, 'Harika Kanat'),
(7, 'Kalp'),
(2, 'Miki Maus'),
(4, 'Şimşek McQueen'),
(6, 'Yeni Yıl Pasta');

-- --------------------------------------------------------

--
-- Table structure for table `figurlutek_siparis`
--

CREATE TABLE `figurlutek_siparis` (
  `id` int(11) NOT NULL,
  `figurlutek_kg` float NOT NULL,
  `figurlutek_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(11) COLLATE utf8mb4_turkish_ci NOT NULL,
  `parola` varchar(11) COLLATE utf8mb4_turkish_ci NOT NULL,
  `adres` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `telefon` varchar(14) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `parola`, `adres`, `telefon`) VALUES
(1, 'sube1', '123456', 'SUBE 1 ADRES / İST. 34000\r\n', '0216 000 00 01'),
(2, 'sube2', '123456', 'SUBE 2 ADRES / İST. 34000\r\n', '0212 000 00 02'),
(3, 'sube3', '123456', 'SUBE 3 ADRES / İST. 34000\r\n', '0216 000 00 03'),
(4, 'sube4', '123456', 'SUBE 4 ADRES / İST. 34000\r\n', '0212 000 00 04'),
(5, 'sube5', '123456', 'SUBE 5 ADRES / İST. 34000\r\n', '0216 000 00 05'),
(6, 'sube6', '123456', 'SUBE 6 ADRES / İST. 34000\r\n', '0212 000 00 06'),
(7, 'sube7', '123456', 'SUBE 7 ADRES / İST. 34000\r\n', '0216 000 00 07');

-- --------------------------------------------------------

--
-- Table structure for table `kullanici_imalatbaklava`
--

CREATE TABLE `kullanici_imalatbaklava` (
  `id` int(11) NOT NULL,
  `kullaniciadi_imalatbaklava` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `parola_imalatbaklava` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `kullanici_imalatbaklava`
--

INSERT INTO `kullanici_imalatbaklava` (`id`, `kullaniciadi_imalatbaklava`, `parola_imalatbaklava`) VALUES
(1, 'imalatbaklava', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `kullanici_imalatpasta`
--

CREATE TABLE `kullanici_imalatpasta` (
  `id` int(11) NOT NULL,
  `kullaniciadi_imalatpasta` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `parola_imalatpasta` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `kullanici_imalatpasta`
--

INSERT INTO `kullanici_imalatpasta` (`id`, `kullaniciadi_imalatpasta`, `parola_imalatpasta`) VALUES
(1, 'imalatpasta', '123456'),
(2, 'imo', '123');

-- --------------------------------------------------------

--
-- Table structure for table `paketurunler`
--

CREATE TABLE `paketurunler` (
  `id` int(11) NOT NULL,
  `paketurunler_adi` varchar(25) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `paketurunler`
--

INSERT INTO `paketurunler` (`id`, `paketurunler_adi`) VALUES
(11, 'Acıbadem Minik'),
(5, 'Baton Sale'),
(2, 'Çikolata Gevrek'),
(9, 'Fesleğenli Çubuk'),
(3, 'Fındıklı Gevrek'),
(7, 'Galet Sale'),
(10, 'Grisini Miks'),
(8, 'Kaşarlı Galet'),
(6, 'Kırıkkırak'),
(1, 'Minik Beze'),
(12, 'Sade Kırıkkırak'),
(4, 'Susamlı Halka');

-- --------------------------------------------------------

--
-- Table structure for table `paketurunler_siparis`
--

CREATE TABLE `paketurunler_siparis` (
  `id` int(11) NOT NULL,
  `paketurunler_kg` float NOT NULL,
  `paketurunler_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasta`
--

CREATE TABLE `pasta` (
  `id` int(11) NOT NULL,
  `pasta_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `pasta`
--

INSERT INTO `pasta` (`id`, `pasta_adi`) VALUES
(11, 'Beyaz İnci'),
(13, 'Çilek Fıstık Çik'),
(6, 'Fıstık Krokan'),
(1, 'Frambuaz Çikolata'),
(10, 'Frambuazlı'),
(5, 'Ganaj'),
(17, 'Kabaklı Cevizli'),
(19, 'Kaplama'),
(9, 'Kara Orman Çilek-Muz'),
(12, 'Karışık Meyveli'),
(14, 'Kestalı Çikolatalı'),
(8, 'Kümbet'),
(18, 'Kütük'),
(16, 'Muz Fındık Beyaz Saçaklı'),
(15, 'Muz, Çilek Fındık Saçaklı'),
(2, 'Muzlu Çikolata'),
(3, 'Profiterol'),
(4, 'Spes. Fıstık Çikolata'),
(7, 'Vişne Çikolata');

-- --------------------------------------------------------

--
-- Table structure for table `pasta_siparis`
--

CREATE TABLE `pasta_siparis` (
  `id` int(11) NOT NULL,
  `boy0` int(11) NOT NULL,
  `boy1` int(11) NOT NULL,
  `boy2` int(11) NOT NULL,
  `boy3` int(11) NOT NULL,
  `pasta_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petifurcesit`
--

CREATE TABLE `petifurcesit` (
  `id` int(11) NOT NULL,
  `petifurcesit_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `petifurcesit`
--

INSERT INTO `petifurcesit` (`id`, `petifurcesit_adi`) VALUES
(5, 'Ananaslı Tartalet'),
(9, 'Çilekli Sarma'),
(3, 'Çilekli Tartalet'),
(2, 'Ekler Beyaz Krema'),
(1, 'Ekler Çikolata'),
(7, 'Fıstık Krokan'),
(6, 'Kivili Tartalet'),
(8, 'Muzlu Sarma'),
(4, 'Vişneli Tartalet');

-- --------------------------------------------------------

--
-- Table structure for table `petifurcesit_siparis`
--

CREATE TABLE `petifurcesit_siparis` (
  `id` int(11) NOT NULL,
  `petifurcesit_kg` float NOT NULL,
  `petifurcesit_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pogaca`
--

CREATE TABLE `pogaca` (
  `id` int(11) NOT NULL,
  `pogaca_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `pogaca`
--

INSERT INTO `pogaca` (`id`, `pogaca_adi`) VALUES
(6, 'Açma Sade'),
(9, 'Dereotlu'),
(10, 'Ev Poğaçası'),
(3, 'Kaşarlı'),
(14, 'Kepekli Simit'),
(20, 'Kruvasan'),
(18, 'Minik Sandviç Ekmeği'),
(4, 'Patatesli'),
(8, 'Patatesli Açma'),
(1, 'Peynirli'),
(11, 'Pizza Adet'),
(2, 'Sade'),
(19, 'Sakallı'),
(17, 'Sandviç Karışık'),
(15, 'Sandviç Kaşarlı'),
(16, 'Sandviç Peynirli'),
(12, 'Simit'),
(13, 'Tahıllı Simit'),
(5, 'Zeytinli'),
(7, 'Zeytinli Açma');

-- --------------------------------------------------------

--
-- Table structure for table `pogaca_siparis`
--

CREATE TABLE `pogaca_siparis` (
  `id` int(11) NOT NULL,
  `pogaca_adet` int(11) NOT NULL,
  `pogaca_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siparis`
--

CREATE TABLE `siparis` (
  `id` int(11) NOT NULL,
  `siparis_adi` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL,
  `urun_id` int(11) NOT NULL,
  `birim` varchar(15) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `siparis`
--

INSERT INTO `siparis` (`id`, `siparis_adi`, `urun_id`, `birim`) VALUES
(1, 'pasta_siparis', 1, 'boy'),
(2, 'tekpasta_siparis', 2, 'tekpasta_adet'),
(3, 'petifurcesit_siparis', 3, 'petifurcesit_kg'),
(4, 'figurlutek_siparis', 4, 'figurlutek_kg'),
(5, 'sutlutatli_siparis', 5, 'sutlutatli_adet'),
(6, 'adetler_siparis', 6, 'adetler_adet'),
(7, 'pogaca_siparis', 7, 'pogaca_adet'),
(8, 'dondurma_siparis', 8, 'dondurma_kg'),
(9, 'tzkurabiye_siparis', 9, 'tzkurabiye_kg'),
(10, 'ttkurabiye_siparis', 10, 'ttkurabiye_kg'),
(11, 'paketurunler_siparis', 11, 'paketurunler_kg'),
(12, 'baklava_siparis', 12, 'baklava_tepsi');

-- --------------------------------------------------------

--
-- Table structure for table `sutlutatli`
--

CREATE TABLE `sutlutatli` (
  `id` int(11) NOT NULL,
  `sutlutatli_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `sutlutatli`
--

INSERT INTO `sutlutatli` (`id`, `sutlutatli_adi`) VALUES
(16, '600 GR Profiterol'),
(12, 'Aşure'),
(15, 'Ayva Tatlısı'),
(2, 'Fıstıklı Muh.'),
(4, 'İncirli Muh.'),
(18, 'K.Dibi 3_lü'),
(1, 'Karamelli Kadyf.'),
(14, 'Kazandibi'),
(13, 'Keşkül'),
(7, 'Mag Çilek'),
(8, 'Mag Krokantlı'),
(6, 'Mag Muz'),
(9, 'Meyveli Muhallebi'),
(3, 'Profiterol'),
(5, 'Supangle'),
(11, 'Sütlaç'),
(17, 'Tavuk 3_lü'),
(10, 'Tavuk Göğsü'),
(19, 'Trileçe Tepsi');

-- --------------------------------------------------------

--
-- Table structure for table `sutlutatli_siparis`
--

CREATE TABLE `sutlutatli_siparis` (
  `id` int(11) NOT NULL,
  `sutlutatli_adet` int(11) NOT NULL,
  `sutlutatli_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tekpasta`
--

CREATE TABLE `tekpasta` (
  `id` int(11) NOT NULL,
  `tekpasta_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `tekpasta`
--

INSERT INTO `tekpasta` (`id`, `tekpasta_adi`) VALUES
(1, 'Alman Muzlu'),
(2, 'Budapeşte Çilek'),
(5, 'Çilek Burger'),
(13, 'Çilek Ekler'),
(3, 'Davils Çilek'),
(15, 'Kabaklı Tek Pasta'),
(10, 'Kalp Sos Fıstık Çiko.'),
(11, 'Kalp Sos Frambuaz'),
(4, 'Karışık Meyveli'),
(14, 'Krokanlı'),
(6, 'Malaga Çikolata'),
(7, 'Milföy Çilek'),
(9, 'Muzlu Rulo'),
(8, 'Perlavista Fran.Çik.'),
(12, 'Tiramisu');

-- --------------------------------------------------------

--
-- Table structure for table `tekpasta_siparis`
--

CREATE TABLE `tekpasta_siparis` (
  `id` int(11) NOT NULL,
  `tekpasta_adet` int(11) NOT NULL,
  `tekpasta_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `tekpasta_siparis`
--

INSERT INTO `tekpasta_siparis` (`id`, `tekpasta_adet`, `tekpasta_id`, `kullanici_id`, `tarih`) VALUES
(1, 2, 1, 1, '2024-01-25'),
(2, 2, 2, 1, '2024-02-12'),
(3, 2, 3, 1, '2023-02-15'),
(4, 2, 4, 1, '2023-03-16'),
(5, 2, 5, 1, '2023-03-19'),
(6, 0, 6, 1, '2023-07-31'),
(7, 0, 7, 1, '2023-07-31'),
(8, 0, 8, 1, '2023-07-31'),
(9, 0, 9, 1, '2023-07-31'),
(10, 0, 10, 1, '2023-07-31'),
(11, 0, 11, 1, '2023-07-31'),
(12, 0, 12, 1, '2023-07-31'),
(13, 0, 13, 1, '2023-07-31'),
(14, 0, 14, 1, '2023-07-31'),
(15, 0, 15, 1, '2023-07-31'),
(16, 0, 1, 2, '2023-07-31'),
(17, 0, 2, 2, '2023-07-31'),
(18, 0, 3, 2, '2023-07-31'),
(19, 0, 4, 2, '2023-07-31'),
(20, 90, 5, 2, '2023-07-31'),
(21, 0, 6, 2, '2023-07-31'),
(22, 0, 7, 2, '2023-07-31'),
(23, 0, 8, 2, '2023-07-31'),
(24, 0, 9, 2, '2023-07-31'),
(25, 0, 10, 2, '2023-07-31'),
(26, 0, 11, 2, '2023-07-31'),
(27, 0, 12, 2, '2023-07-31'),
(28, 0, 13, 2, '2023-07-31'),
(29, 0, 14, 2, '2023-07-31'),
(30, 0, 15, 2, '2023-07-31'),
(31, 0, 1, 6, '2023-08-17'),
(32, 0, 2, 6, '2023-08-17'),
(33, 0, 3, 6, '2023-08-17'),
(34, 0, 4, 6, '2023-08-17'),
(35, 0, 5, 6, '2023-08-17'),
(36, 0, 6, 6, '2023-08-17'),
(37, 0, 7, 6, '2023-08-17'),
(38, 0, 8, 6, '2023-08-17'),
(39, 0, 9, 6, '2023-08-17'),
(40, 0, 10, 6, '2023-08-17'),
(41, 0, 11, 6, '2023-08-17'),
(42, 0, 12, 6, '2023-08-17'),
(43, 0, 13, 6, '2023-08-17'),
(44, 0, 14, 6, '2023-08-17'),
(45, 0, 15, 6, '2023-08-17'),
(47, 0, 1, 1, '2023-08-17'),
(48, 0, 2, 1, '2023-08-17'),
(49, 0, 3, 1, '2023-08-17'),
(50, 0, 4, 1, '2023-08-17'),
(51, 0, 5, 1, '2023-08-17'),
(52, 0, 6, 1, '2023-08-17'),
(53, 0, 7, 1, '2023-08-17'),
(54, 0, 8, 1, '2023-08-17'),
(55, 0, 9, 1, '2023-08-17'),
(56, 0, 10, 1, '2023-08-17'),
(57, 0, 11, 1, '2023-08-17'),
(58, 0, 12, 1, '2023-08-17'),
(59, 0, 13, 1, '2023-08-17'),
(60, 0, 14, 1, '2023-08-17'),
(61, 0, 15, 1, '2023-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `ttkurabiye`
--

CREATE TABLE `ttkurabiye` (
  `id` int(11) NOT NULL,
  `ttkurabiye_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `ttkurabiye`
--

INSERT INTO `ttkurabiye` (`id`, `ttkurabiye_adi`) VALUES
(1, 'Bonbon'),
(21, 'Browni Karamel'),
(5, 'Cevizli Köfte'),
(18, 'Cevizli Kuki'),
(4, 'Çekirdekli'),
(12, 'Çikolatalı Tadelle'),
(11, 'Elmalı Kurabiye'),
(8, 'Horlandeks Fındıklı'),
(17, 'İncirli Mirvan'),
(2, 'İtalyan Fındık'),
(15, 'İzmir Bomba'),
(3, 'Kahveli Çikolata'),
(7, 'Kavala'),
(19, 'Landoşe Çikolata'),
(20, 'Landoşe Susam'),
(14, 'Marshmallow Fıstık'),
(13, 'Marshmallow Fileks'),
(10, 'Mekik Bademli'),
(9, 'Mekik Vişneli'),
(6, 'Portakal Çiko'),
(23, 'Snickers. Çik.'),
(16, 'Tahinli Kurabiye'),
(22, 'Tül Badem');

-- --------------------------------------------------------

--
-- Table structure for table `ttkurabiye_siparis`
--

CREATE TABLE `ttkurabiye_siparis` (
  `id` int(11) NOT NULL,
  `ttkurabiye_kg` float NOT NULL,
  `ttkurabiye_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tzkurabiye`
--

CREATE TABLE `tzkurabiye` (
  `id` int(11) NOT NULL,
  `tzkurabiye_adi` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `tzkurabiye`
--

INSERT INTO `tzkurabiye` (`id`, `tzkurabiye_adi`) VALUES
(6, 'Boncuk'),
(2, 'Çeşnili'),
(4, 'Dereotlu'),
(1, 'El İşi'),
(8, 'Köri Tuzlu'),
(3, 'Mayalı'),
(7, 'Mısır Unlu'),
(5, 'Mini Pizza');

-- --------------------------------------------------------

--
-- Table structure for table `tzkurabiye_siparis`
--

CREATE TABLE `tzkurabiye_siparis` (
  `id` int(11) NOT NULL,
  `tzkurabiye_kg` float NOT NULL,
  `tzkurabiye_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `urunler1`
--

CREATE TABLE `urunler1` (
  `id` int(11) NOT NULL,
  `urun_adi` varchar(20) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `urunler1`
--

INSERT INTO `urunler1` (`id`, `urun_adi`) VALUES
(6, 'ADETLER'),
(12, 'BAKLAVA (TEPSİ)'),
(8, 'DONDURMA (KG)'),
(4, 'FİGÜRLÜ TEK (KG)'),
(10, 'KURABİYE TATLI (KG)'),
(9, 'KURABİYE TUZLU (KG)'),
(11, 'PAKET ÜRÜNLER (KG)'),
(1, 'PASTA [0][1][2][3]'),
(3, 'PETİFÜR ÇEŞİT (KG)'),
(7, 'POĞAÇA (ADET)'),
(5, 'SÜTLÜ TATLI (ADET)'),
(2, 'TEK PASTA (ADET)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adetler`
--
ALTER TABLE `adetler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adetler_adi` (`adetler_adi`);

--
-- Indexes for table `adetler_siparis`
--
ALTER TABLE `adetler_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `adetler_id` (`adetler_id`);

--
-- Indexes for table `baklava`
--
ALTER TABLE `baklava`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `baklava_adi` (`baklava_adi`);

--
-- Indexes for table `baklava_siparis`
--
ALTER TABLE `baklava_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `baklava_id` (`baklava_id`);

--
-- Indexes for table `dondurma`
--
ALTER TABLE `dondurma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dondurma_adi` (`dondurma_adi`);

--
-- Indexes for table `dondurma_siparis`
--
ALTER TABLE `dondurma_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dondurma_id` (`dondurma_id`,`kullanici_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `figurlutek`
--
ALTER TABLE `figurlutek`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `figurlutek_adi` (`figurlutek_adi`);

--
-- Indexes for table `figurlutek_siparis`
--
ALTER TABLE `figurlutek_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `figurlutek_id` (`figurlutek_id`);

--
-- Indexes for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`);

--
-- Indexes for table `kullanici_imalatbaklava`
--
ALTER TABLE `kullanici_imalatbaklava`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullaniciadi_imalatbaklava` (`kullaniciadi_imalatbaklava`);

--
-- Indexes for table `kullanici_imalatpasta`
--
ALTER TABLE `kullanici_imalatpasta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullaniciadi_imalat` (`kullaniciadi_imalatpasta`);

--
-- Indexes for table `paketurunler`
--
ALTER TABLE `paketurunler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paketurunler_adi` (`paketurunler_adi`);

--
-- Indexes for table `paketurunler_siparis`
--
ALTER TABLE `paketurunler_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `paketurunler_id` (`paketurunler_id`);

--
-- Indexes for table `pasta`
--
ALTER TABLE `pasta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pasta_adi` (`pasta_adi`);

--
-- Indexes for table `pasta_siparis`
--
ALTER TABLE `pasta_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasta_id` (`pasta_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `petifurcesit`
--
ALTER TABLE `petifurcesit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `petifurcesit_adi` (`petifurcesit_adi`);

--
-- Indexes for table `petifurcesit_siparis`
--
ALTER TABLE `petifurcesit_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `petifurcesit_id` (`petifurcesit_id`,`kullanici_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `pogaca`
--
ALTER TABLE `pogaca`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pogaca_adi` (`pogaca_adi`);

--
-- Indexes for table `pogaca_siparis`
--
ALTER TABLE `pogaca_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pogaca_id` (`pogaca_id`,`kullanici_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `urun_id` (`urun_id`);

--
-- Indexes for table `sutlutatli`
--
ALTER TABLE `sutlutatli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sutlutatli_adi` (`sutlutatli_adi`);

--
-- Indexes for table `sutlutatli_siparis`
--
ALTER TABLE `sutlutatli_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `sutlutatli_id` (`sutlutatli_id`);

--
-- Indexes for table `tekpasta`
--
ALTER TABLE `tekpasta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tekpasta_adi` (`tekpasta_adi`);

--
-- Indexes for table `tekpasta_siparis`
--
ALTER TABLE `tekpasta_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tekpasta_id` (`tekpasta_id`,`kullanici_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `ttkurabiye`
--
ALTER TABLE `ttkurabiye`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ttkurabiye_adi` (`ttkurabiye_adi`);

--
-- Indexes for table `ttkurabiye_siparis`
--
ALTER TABLE `ttkurabiye_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ttkurabiye_id` (`ttkurabiye_id`,`kullanici_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `tzkurabiye`
--
ALTER TABLE `tzkurabiye`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tzkurabiye_adi` (`tzkurabiye_adi`);

--
-- Indexes for table `tzkurabiye_siparis`
--
ALTER TABLE `tzkurabiye_siparis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tzkurabiye_id` (`tzkurabiye_id`,`kullanici_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `urunler1`
--
ALTER TABLE `urunler1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `urun_adi` (`urun_adi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adetler`
--
ALTER TABLE `adetler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `adetler_siparis`
--
ALTER TABLE `adetler_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `baklava`
--
ALTER TABLE `baklava`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `baklava_siparis`
--
ALTER TABLE `baklava_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dondurma`
--
ALTER TABLE `dondurma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `dondurma_siparis`
--
ALTER TABLE `dondurma_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `figurlutek`
--
ALTER TABLE `figurlutek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `figurlutek_siparis`
--
ALTER TABLE `figurlutek_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kullanici_imalatbaklava`
--
ALTER TABLE `kullanici_imalatbaklava`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kullanici_imalatpasta`
--
ALTER TABLE `kullanici_imalatpasta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `paketurunler`
--
ALTER TABLE `paketurunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `paketurunler_siparis`
--
ALTER TABLE `paketurunler_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasta`
--
ALTER TABLE `pasta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pasta_siparis`
--
ALTER TABLE `pasta_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petifurcesit`
--
ALTER TABLE `petifurcesit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `petifurcesit_siparis`
--
ALTER TABLE `petifurcesit_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pogaca`
--
ALTER TABLE `pogaca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pogaca_siparis`
--
ALTER TABLE `pogaca_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siparis`
--
ALTER TABLE `siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sutlutatli`
--
ALTER TABLE `sutlutatli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sutlutatli_siparis`
--
ALTER TABLE `sutlutatli_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tekpasta`
--
ALTER TABLE `tekpasta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tekpasta_siparis`
--
ALTER TABLE `tekpasta_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `ttkurabiye`
--
ALTER TABLE `ttkurabiye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ttkurabiye_siparis`
--
ALTER TABLE `ttkurabiye_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tzkurabiye`
--
ALTER TABLE `tzkurabiye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tzkurabiye_siparis`
--
ALTER TABLE `tzkurabiye_siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `urunler1`
--
ALTER TABLE `urunler1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adetler_siparis`
--
ALTER TABLE `adetler_siparis`
  ADD CONSTRAINT `adetler_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `adetler_siparis_ibfk_2` FOREIGN KEY (`adetler_id`) REFERENCES `adetler` (`id`);

--
-- Constraints for table `baklava_siparis`
--
ALTER TABLE `baklava_siparis`
  ADD CONSTRAINT `baklava_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `baklava_siparis_ibfk_2` FOREIGN KEY (`baklava_id`) REFERENCES `baklava` (`id`);

--
-- Constraints for table `dondurma_siparis`
--
ALTER TABLE `dondurma_siparis`
  ADD CONSTRAINT `dondurma_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `dondurma_siparis_ibfk_2` FOREIGN KEY (`dondurma_id`) REFERENCES `dondurma` (`id`);

--
-- Constraints for table `figurlutek_siparis`
--
ALTER TABLE `figurlutek_siparis`
  ADD CONSTRAINT `figurlutek_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `figurlutek_siparis_ibfk_2` FOREIGN KEY (`figurlutek_id`) REFERENCES `figurlutek` (`id`);

--
-- Constraints for table `paketurunler_siparis`
--
ALTER TABLE `paketurunler_siparis`
  ADD CONSTRAINT `paketurunler_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `paketurunler_siparis_ibfk_2` FOREIGN KEY (`paketurunler_id`) REFERENCES `paketurunler` (`id`);

--
-- Constraints for table `pasta_siparis`
--
ALTER TABLE `pasta_siparis`
  ADD CONSTRAINT `pasta_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `pasta_siparis_ibfk_2` FOREIGN KEY (`pasta_id`) REFERENCES `pasta` (`id`);

--
-- Constraints for table `petifurcesit_siparis`
--
ALTER TABLE `petifurcesit_siparis`
  ADD CONSTRAINT `petifurcesit_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `petifurcesit_siparis_ibfk_2` FOREIGN KEY (`petifurcesit_id`) REFERENCES `petifurcesit` (`id`);

--
-- Constraints for table `pogaca_siparis`
--
ALTER TABLE `pogaca_siparis`
  ADD CONSTRAINT `pogaca_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `pogaca_siparis_ibfk_2` FOREIGN KEY (`pogaca_id`) REFERENCES `pogaca` (`id`);

--
-- Constraints for table `siparis`
--
ALTER TABLE `siparis`
  ADD CONSTRAINT `siparis_ibfk_1` FOREIGN KEY (`urun_id`) REFERENCES `urunler1` (`id`);

--
-- Constraints for table `sutlutatli_siparis`
--
ALTER TABLE `sutlutatli_siparis`
  ADD CONSTRAINT `sutlutatli_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `sutlutatli_siparis_ibfk_2` FOREIGN KEY (`sutlutatli_id`) REFERENCES `sutlutatli` (`id`);

--
-- Constraints for table `tekpasta_siparis`
--
ALTER TABLE `tekpasta_siparis`
  ADD CONSTRAINT `tekpasta_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `tekpasta_siparis_ibfk_2` FOREIGN KEY (`tekpasta_id`) REFERENCES `tekpasta` (`id`);

--
-- Constraints for table `ttkurabiye_siparis`
--
ALTER TABLE `ttkurabiye_siparis`
  ADD CONSTRAINT `ttkurabiye_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `ttkurabiye_siparis_ibfk_2` FOREIGN KEY (`ttkurabiye_id`) REFERENCES `ttkurabiye` (`id`);

--
-- Constraints for table `tzkurabiye_siparis`
--
ALTER TABLE `tzkurabiye_siparis`
  ADD CONSTRAINT `tzkurabiye_siparis_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `tzkurabiye_siparis_ibfk_2` FOREIGN KEY (`tzkurabiye_id`) REFERENCES `tzkurabiye` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

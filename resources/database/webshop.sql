-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 05 jun 2018 om 21:04
-- Serverversie: 5.7.22-0ubuntu0.16.04.1
-- PHP-versie: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `categorienaam` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`categorienaam`) VALUES
('categorie AA'),
('categorie BB'),
('categorie CC'),
('categorie DD');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE `gebruiker` (
  `gebruikersnaam` varchar(15) NOT NULL,
  `voornaam` varchar(125) NOT NULL,
  `tussenvoegsel` varchar(30) DEFAULT NULL,
  `achternaam` varchar(125) NOT NULL,
  `straatnaam` varchar(125) NOT NULL,
  `huisnummer` int(11) NOT NULL,
  `postcode` char(6) NOT NULL,
  `woonplaats` varchar(125) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sexe` enum('M','V') NOT NULL,
  `wachtwoord` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`gebruikersnaam`, `voornaam`, `tussenvoegsel`, `achternaam`, `straatnaam`, `huisnummer`, `postcode`, `woonplaats`, `email`, `sexe`, `wachtwoord`) VALUES
('barabas', 'Professor', NULL, 'Barabas', 'Bolleboze', 12, '9574EC', 'Amoras', 'barabase@vandersteen.be', 'M', 'teletijdmachine'),
('franka', 'Frank', NULL, 'Francesca Victoria', 'Museumstraat', 1, '4920DD', 'Groterdam', 'franka@striphelden.eu', 'V', 'Bars'),
('pietjepuk', 'Pietje', NULL, 'Puk', 'Postlaa', 6, '3453AA', 'Keteldorp ', 'pietjepuk@pttpost.nl', 'M', 'spitsoor'),
('wdviking', 'Wicky', 'de', 'Viking', 'Whalhalla', 87, '4326BB', 'Flake', 'wicky@halmar.com', 'M', 'ylvi');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `productnummer` int(11) NOT NULL,
  `productnaam` varchar(100) NOT NULL,
  `omschrijving` text NOT NULL,
  `categorie` varchar(15) NOT NULL,
  `prijs` decimal(8,2) NOT NULL,
  `voorraad` int(11) DEFAULT NULL,
  `afbeelding_groot` varchar(255) NOT NULL,
  `afbeelding_klein` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`productnummer`, `productnaam`, `omschrijving`, `categorie`, `prijs`, `voorraad`, `afbeelding_groot`, `afbeelding_klein`) VALUES
(10, 'product a', 'phasellus volutpat tincidunt mi, nec laoreet metus sollicitudin at. aenean vulputate consequat mauris vitae imperdiet. phasellus vitae feugiat purus, vel viverra justo. phasellus in ipsum quis augue tempor dapibus. fusce porttitor lectus id tortor accumsan molestie. donec ante orci, fermentum a dui et, tempus ', 'categorie cc', '40.00', NULL, 'plaatjes/afbeeldinga.jpg', 'plaatjes/afbeeldinga-klein.jpg'),
(11, 'product b', 'dit zijn blauwe naaldhakken. sed vitae purus sit amet tortor porta gravida sed ut massa. quisque non arcu ut lectus adipiscing adipiscing a vel elit. quisque pharetra eget velit sed fringilla. sed nisl elit, interdum in elit id, sollicitudin eleifend metus. sed et venenatis purus, at fringilla leo. maecenas vestibulum euismod enim, sollicitudin bibendum mi consectetur id. donec a turpis ac lorem aliquam cursus eget ac sem. mauris eu tellus augue. phasellus non risus massa. aliquam erat volutpat. interdum et malesuada fames ac ante ipsum primis in faucibus. morbi a fermentum libero ', 'categorie cc', '33.00', 33, 'plaatjes/afbeeldingb.jpg', 'plaatjes/afbeeldingb-klein.jpg'),
(13, 'product c', 'vestibulum dui. maecenas condimentum purus eget ligula mollis volutpat. lorem ipsum dolor sit amet, consectetur adipiscing elit. sed elementum magna a metus venenatis, nec imperdiet mauris venenatis. morbi ut placerat arcu, eget tempus leo. nam aliquet sed ligula a gravida. sed vitae purus sit amet tortor porta gravida sed ut massa. quisque non arcu ut lectus adipiscing adipiscing a vel elit. quisque pharetra eget velit sed fringilla. sed nisl elit, interdum in elit id, sollicitudin eleifend metus. sed et venenatis purus, at fringilla leo. maecenas vestibulum euismod enim, sollicitudin bibendum mi consectetur id. donec a turpis ac lorem aliquam cursus eget ac sem. mauris eu tellus augue. phasellus non risus massa. aliquam erat volutpat. interdum et malesuada fames ac ante ipsum primis in faucibus. morbi a fermentum libero. ', 'categorie cc', '333.00', 3, 'plaatjes/afbeeldingc.jpg', 'plaatjes/afbeeldingc-klein.jpg'),
(14, 'product d', 'phasellus volutpat tincidunt mi, nec laoreet metus sollicitudin at. aenean vulputate consequat mauris vitae imperdiet. phasellus vitae feugiat purus, vel viverra justo. phasellus in ipsum quis augue tempor dapibus. fusce porttitor lectus id tortor accumsan molestie. donec ante orci, fermentum a dui et, tempus faucibus risus. aenean porta dapibus quam sodales eleifend. donec congue mauris sit amet neque sodales varius. integer vehicula vel lacus in consequat. pellentesque et magna pharetra, mollis dolor eu, consectetur turpis. nam porttitor, leo ac mattis blandit', 'categorie cc', '526.00', 993, 'plaatjes/afbeeldingd.jpg', 'plaatjes/afbeeldingd-klein.jpg'),
(15, 'product e', 'tempor suscipit enim ac rhoncus. phasellus sit amet dapibus erat. curabitur tempor auctor urna, quis luctus felis vestibulum sed. vestibulum suscipit bibendum tincidunt. sed ac condimentum eros. fusce luctus convallis turpis eu tristique. nunc metus tortor, imperdiet iaculis turpis sed, scelerisque hendrerit odio. nunc sit amet ipsum ut turpis fringilla venenatis. phasellus viverra molestie sagittis. sed est odio, lacinia vel nisl et, vestibulum lacinia ', 'categorie dd', '44.00', 45, 'plaatjes/afbeeldinge.jpg', 'plaatjes/afbeeldinge-klein.jpg'),
(16, 'product f', 'cras tincidunt gravida dignissim. mauris at commodo augue, ac tristique erat. proin a adipiscing leo, et volutpat eros. aenean eros arcu, cursus nec dolor non, aliquam pharetra lectus. sed feugiat tristique risus eget tristique. donec pharetra augue justo, sit amet vestibulum erat commodo id. curabitur a molestie est. sed a bibendum erat, quis vestibulum lorem. duis interdum pulvinar enim, quis iaculis erat ullamcorper scelerisque. nunc vel erat aliquam, vulputate nibh non, sagittis magna. aliquam egestas posuere purus, vitae tristique risus porta a. nunc nec elit iaculis, mattis purus nec, sagittis tellus. maecenas auctor id urna id malesuada. vivamus pellentesque turpis velit, quis bibendum tortor placerat vitae. phasellus condimentum ligula vel dignissim tempus. ', 'categorie bb', '66.00', 47, 'plaatjes/afbeeldingf.jpg', 'plaatjes/afbeeldingf-klein.jpg'),
(17, 'product g', 'cras sodales placerat imperdiet. nunc adipiscing, lectus a gravida pulvinar, sapien metus commodo ipsum, at cursus orci est vitae massa. morbi at enim purus. etiam luctus massa eu nisi bibendum blandit. donec tincidunt lorem at justo lacinia viverra. suspendisse semper nulla vel sollicitudin elementum. vivamus ac augue urna. ut et lorem malesuada, vestibulum tellus et, porttitor orci. phasellus vitae pretium elit. curabitur diam neque, aliquam quis nunc vel, placerat aliquet tortor. morbi tempus est at lectus tincidunt, in malesuada nunc aliquam. interdum et malesuada fames ac ante ipsum primis in faucibus. curabitur malesuada gravida tortor eget iaculis. class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. donec facilisis congue sem at fringilla. quisque adipiscing ante ipsum, in condimentum felis varius eu. sed ultricies, orci non scelerisque congue, lacus justo blandit felis, sit amet faucibus tellus massa vel libero. in vestibulum mi ut adipiscing vehicula. aenean pulvinar, sem quis elementum porttitor, massa mauris ultricies risus, eget lobortis lacus turpis non erat. quisque ornare bibendum aliquam. sed laoreet ornare laoreet. nullam et dui accumsan, vulputate mi non, tristique lectus. ', 'categorie bb', '5432.00', 996, 'plaatjes/afbeeldingg.jpg', 'plaatjes/afbeeldingg-klein.jpg'),
(34, 'product h', 'sed id ipsum in nisi tempus luctus quis ac mi. in hac habitasse platea dictumst. donec dapibus sollicitudin quam, vel ultrices orci porttitor ut. suspendisse potenti. aliquam et lorem vitae ante porttitor pellentesque. cras sit amet accumsan nisl. phasellus quam magna, tincidunt non risus vitae, adipiscing pharetra sapien. in hac habitasse platea dictumst. morbi lorem urna, luctus eget pellentesque euismod, rutrum a nulla. curabitur imperdiet facilisis felis, sit amet tincidunt diam venenatis at. etiam libero nulla, sagittis vitae tellus at, ornare varius ante. nunc leo nisi, placerat non convallis id, fermentum in metus. nunc sollicitudin eleifend hendrerit. nam neque velit, vehicula vel egestas ac, blandit feugiat leo. morbi ', 'categorie aa', '324.00', 5, 'plaatjes/afbeeldingh.jpg', 'plaatjes/afbeeldingh-klein.jpg'),
(35, 'product i', 'ut non sapien vel mauris varius gravida non et leo. vestibulum vitae nibh porta, blandit nisi a, tincidunt neque. sed a pretium leo, sit amet consequat felis. quisque vehicula, mi at semper placerat, massa turpis elementum odio, in gravida lectus nisl eu metus. duis scelerisque rutrum scelerisque. sed in ornare mauris. donec imperdiet, turpis a pellentesque tristique, magna sem tempus tortor, at pharetra libero velit at ante. integer euismod dolor nec tellus bibendum, porttitor fermentum lectus placerat', 'categorie aa', '789.00', 33, 'plaatjes/afbeeldingi.jpg', 'plaatjes/afbeeldingi-klein.jpg'),
(36, 'product j', 'nunc imperdiet est a ligula malesuada, sit amet mollis nisl gravida. etiam eget fringilla leo. maecenas dolor eros, pretium eget commodo eget, sagittis aliquet lacus. in tempus suscipit velit sed gravida. nulla id magna tincidunt, iaculis enim non, egestas mi. praesent vel est iaculis, semper lacus id, suscipit odio. phasellus nec lacus tempus, pharetra nunc vitae, congue risus. nam ut ligula neque. curabitur vel fermentum massa. etiam iaculis egestas aliquet', 'categorie aa', '4.00', 25, 'plaatjes/afbeeldingj.jpg', 'plaatjes/afbeeldingj-klein.jpg'),
(37, 'product k', 'fusce eu lorem nunc. ut sit amet massa ac est venenatis iaculis sed ut elit. in hac habitasse platea dictumst. etiam mollis sit amet dolor id iaculis. vivamus mattis odio eu ultrices elementum. praesent ac quam turpis. nulla at est quis dolor dignissim suscipit vitae at dui. etiam scelerisque venenatis lorem a aliquam. duis laoreet posuere eros non ultricies. quisque tempus eu mi in feugiat. mauris euismod ac sem ut volutpat.', 'categorie aa', '44.00', NULL, 'plaatjes/afbeeldingk.jpg', 'plaatjes/afbeeldingk-klein.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productnummer_gerelateerd_product`
--

CREATE TABLE `productnummer_gerelateerd_product` (
  `productnummer` int(11) NOT NULL,
  `productnummer_gerelateerd_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `productnummer_gerelateerd_product`
--

INSERT INTO `productnummer_gerelateerd_product` (`productnummer`, `productnummer_gerelateerd_product`) VALUES
(11, 10),
(17, 10),
(10, 11),
(17, 11),
(10, 13),
(11, 13),
(11, 16),
(36, 34),
(36, 35),
(17, 36),
(36, 37);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorienaam`);

--
-- Indexen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`gebruikersnaam`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productnummer`),
  ADD UNIQUE KEY `productnaam` (`productnaam`),
  ADD KEY `fk_product_categorie` (`categorie`);

--
-- Indexen voor tabel `productnummer_gerelateerd_product`
--
ALTER TABLE `productnummer_gerelateerd_product`
  ADD PRIMARY KEY (`productnummer`,`productnummer_gerelateerd_product`),
  ADD KEY `fk2_product_gerelateerd_product` (`productnummer_gerelateerd_product`);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_categorie` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`categorienaam`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `productnummer_gerelateerd_product`
--
ALTER TABLE `productnummer_gerelateerd_product`
  ADD CONSTRAINT `fk1_product_gerelateerd_product` FOREIGN KEY (`productnummer`) REFERENCES `product` (`productnummer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk2_product_gerelateerd_product` FOREIGN KEY (`productnummer_gerelateerd_product`) REFERENCES `product` (`productnummer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

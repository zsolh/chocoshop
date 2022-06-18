-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2022. Jún 19. 00:18
-- Kiszolgáló verziója: 10.4.16-MariaDB
-- PHP verzió: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `chocoshop`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `category`
--

CREATE TABLE `category` (
  `id` int(2) NOT NULL,
  `name` varchar(30) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Étcsokoládé'),
(2, 'Tejcsokoládé'),
(3, 'Fehér Csokoládé'),
(4, 'Alkoholos Csokoládé'),
(5, 'Szőke Csokoládé');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `client`
--

CREATE TABLE `client` (
  `id` int(4) NOT NULL,
  `username` varchar(10) COLLATE utf8_hungarian_ci NOT NULL,
  `hash_password` varchar(128) COLLATE utf8_hungarian_ci NOT NULL,
  `hash_salt` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `bill_name` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `bill_address` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `delivery_address` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `client`
--

INSERT INTO `client` (`id`, `username`, `hash_password`, `hash_salt`, `email`, `bill_name`, `bill_address`, `delivery_address`) VALUES
(1, 'xbnbcfdsd', '23a3fbe96628ffbbf1bac51801bc097e4c65971855364eee95d0644b07c292e55301a33f7e1a508ea3724c9ebfa08d102ab4fbe711e6a8811f7012347be08128', '0ee4brzoamey36hqzbm9', 'holman.zsolt@gmail.com', NULL, 'Budapest', 'Budapest'),
(2, 'xbnbc', '417284835aab02496db319b9ec5df03d5ece821aaf2a8b98b21c71d9bea06078942bf7cce56f482c1bc56dcadd49f64cc10c706e2e20726a68d307be6a6c53e2', 'ynz7mfj5he20tfx3ot9j', 'zsolt@gmail.com', 'hzsolt', 'Budapest', 'Budapest'),
(3, 'dhdh', '3f409dfbf3045ff1d4d3821226b7beee623ace7042018eb2c9107084da073c4ab25c4e21e9affd4bb9b07e42c4bc04fbbca5c57f87751c658fad8cf0a8a726b4', 'zczcy7dlye2exwbdax2l', 'holman@gmail.com', NULL, NULL, NULL),
(4, 'zsolt', '7f3b035f25797ec262a6f9e61b5087fd055808a26d8c04fe8274c1b1b0911f6b87eb3b70dcb7d82274ae089a7325891ed39163105779a54f4df96a8e16d45f17', '7lh1nrnqsaxkjhyu1utg', 'zsolt@email.com', NULL, NULL, NULL),
(5, 'user', 'f63bca23d1da9db6d549f084ac23124aa08dc158cd3ef9595a100b485837225ad015688a083c43a0002a83e13a2173d999f9ba0cb088639b06ba8f02471c174e', 'cqxv7uxz8s1t6ozy1y32', 'user@email.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `order`
--

CREATE TABLE `order` (
  `id` int(6) NOT NULL,
  `order_number` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `client` int(4) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `bill_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `bill_address` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `payment_mode` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `delivery_address` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `delivery_mode` varchar(20) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `order`
--

INSERT INTO `order` (`id`, `order_number`, `client`, `order_date`, `bill_name`, `bill_address`, `payment_mode`, `delivery_address`, `delivery_mode`) VALUES
(1, '4-y8tx5y', 4, '2021-01-30 15:24:03', 'hzsolt', '24 Robert K krt', 'Banki átutalás', 'dgsf', 'Postai csomag'),
(2, '4-o331mq', 4, '2021-01-30 15:26:10', 'gserfedafggf', '24 Robert K krt', 'Utánvét', 'fgsfdf', 'Futárszolgálat'),
(3, '4-3wz9zc', 4, '2021-01-30 15:43:31', 'fdsad', 'fdsasg', 'Banki átutalás', 'fdsaaf', 'Postai csomag'),
(4, '4-aws5sw', 4, '2021-01-30 15:44:25', 'qwe', 'qwe', 'Banki átutalás', 'qw', 'Postai csomag'),
(5, '4-sc2eu9', 4, '2021-01-30 15:50:09', 'hzsolt', '24 Robert K krt', 'Utánvét', 'sdfg', 'Futárszolgálat');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `order_item`
--

CREATE TABLE `order_item` (
  `id` int(7) NOT NULL,
  `order` int(6) NOT NULL,
  `product` int(4) NOT NULL,
  `order_price` int(6) NOT NULL,
  `qty` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `order_item`
--

INSERT INTO `order_item` (`id`, `order`, `product`, `order_price`, `qty`) VALUES
(1, 1, 14, 1100, 1),
(2, 1, 18, 345, 1),
(3, 2, 1, 820, 10),
(4, 2, 20, 1525, 10),
(5, 3, 9, 1780, 1),
(6, 3, 6, 1270, 1),
(7, 3, 19, 1525, 1),
(8, 4, 9, 1780, 2),
(9, 4, 6, 1270, 2),
(10, 4, 19, 1525, 1),
(11, 4, 18, 345, 1),
(12, 5, 15, 1100, 1),
(13, 5, 6, 1270, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product`
--

CREATE TABLE `product` (
  `id` int(4) NOT NULL,
  `category` int(2) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `price` int(6) NOT NULL,
  `brand` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `country` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `weight` int(5) NOT NULL,
  `description` text COLLATE utf8_hungarian_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `product`
--

INSERT INTO `product` (`id`, `category`, `name`, `price`, `brand`, `country`, `weight`, `description`, `img`) VALUES
(1, 1, 'Citromos borsos étcsokoládé', 810, 'Cachet', 'Belgium', 100, '<p>Az 57% csodás étcsokoládé, a frissítő és intenzív citrom valamint a merész feketebors párosítása igazán lenyűgözőre sikerült!</p><p>Lendület és energia, szikra és aroma. A savanykás citrom és a fekete bors ellenállhatatlan párosítása a legjobbat hozza ki a Cachet étcsokijából.</p>', '01.png'),
(2, 1, 'Szedres-gyömbéres étcsokoládé', 820, 'Cachet', 'Belgium', 100, '<p>Minőségi belga táblás étcsokoládé szedres gyömbéres ízesítéssel. A 60%-os kakaótartalmú étcsokoládé együtt a csípős gyömbérrel és a fanyar feketeszederrel nagyszerű párost alkot.</p><p>A szeder és gyömbér dinamikus duója villámcsapásként hat. A lédús, édes szeder és a jellegzetes, csípős gyömbér íze egy varázslatos Cachet élményt hoz létre.</p><p>Nyomokban tartalmazhat mogyorófélékett, tojást és glutént.</p>', '02.png'),
(3, 1, 'Vörösáfonyás étcsokoládé tábla', 590, 'Heidi', 'Románia', 80, '<p>A legenda szerint a telepesek termesztették a vörösáfonyát, hogy a hálaadási pulykával párosítsák.</p><p>Azóta az egész világot meghódította ez a bogyós gyümölcs mindenki legnagyobb örömére.</p><p>Néhányan az intenzív ízeket, míg mások a frissítőeket szeretik. De mi van akkor, ha a minőségi étcsokoládé és az édeskés vörösáfonya kombinációja egy csipetnyi vaníliával mindkettőt nyújtja? Lehetetlen kihagyni!</p>', '03.png'),
(4, 1, 'Madagascar 100% Criollo', 1780, 'Akesson\'s', 'Franciaország', 60, '<p>A Sambirano völgyben Ambanja városhoz közel Madagascar észak-nyugati részén található Bertil Akesson mintegy 2000 hektáros birtoka, melyen több kisebb ültetvény található, többek között az Ambolikapiky.</p><p>Ezen a farmon 1920 óta termesztik a világhírű aromás kakaóbabot, melyet jónéhány mesterszakács és csokoládékészítő használ szerte a világon. A mintegy 300 tonna trinitario bab mellett évente 2 tonna Criollo babot is szüretelnek. Nagyon intenzív ízek jellemzik a babot, édes, savanykás, kellemes gyümölcsösséggel, citrusos és vörösáfonyás ízjegyekkel.</p><h4>Díjai:</h4><ul><li>2014 Great Taste Award -  Arany</li><li>2014 Internationa Chocolate Awards, Best Bar over 85% - Arany</li></ul>', '04.png'),
(5, 1, 'Toscano Black 70', 1905, 'Amedei', 'Olaszország', 50, '<p>Az Amedei klasszikus étcsokoládéja. A páratlan ízt gondosan kiválasztott trinitario és criollo kakaóbabok összhangja adja.</p><p>Az egyik legmagasabb kakaótartalommal megáldott Amedei étcsokoládé páratlan ízét egy gondosan kiválasztott eredetű Trinitario és Cirollo kakkaó adja.</p><p>Toscano Black 70%: A minőségi csokoládé ideálja, az Amedei első csokoládéja. Erőteljes, mély, füstös, dohányos illat. Gazdag, karamelles, mézes és dohányra, fára emlékeztető, harmonikus íz, utóíze percekig élvezhető. Az igazi csokoládé kedvelőinek, haladóknak ajánlható.</p>', '05.png'),
(6, 2, 'Cappuccinos Csészécskék', 1270, 'Cupido', 'Belgium', 125, '<p>Részben hidrogénezett növényi olajok (kókusz, pálmamag változó arányban), tejcukor, cukor, sovány kakaópor, sovány tejpor, emulgeálószer: szójalecitin, aroma: vanília és cappuccino, kávé 0,06%. Nyomokban tojást és dióféléket tartalmazhat.</p>', '06.png'),
(7, 2, 'Latte Macchiato Csészécskék', 1270, 'Cupido', 'Belgium', 125, '<p>Tejeskávé ízesítésű tejcsokoládé csészécskék.</p>', '07.png'),
(8, 2, 'Toscano Brown', 1905, 'Amedei', 'Olaszország', 50, '<p>32%-os kakaótartalommal kivételesen sima és krémes ízű tejcsokoládé, ami a maláta jegyeivel tölti ki a tej és karamella ízeit. Egy nagyszerű tejcsokoládé az Amedeitől!</p>', '08.png'),
(9, 2, 'Bali 45% tengeri sós tejcsokoládé', 1780, 'Akesson\'s', 'Franciaország', 60, '<p>Mintegy 8000 kakaófa van a cca 7 hektáros területen Melaya körzetben, a sziget nyugati részén. \r\nElsőként Európában Bertil Akesson készített csokoládét Balin termő kakaóbabból. Erre a táblára férfias kesernyésség és fűszeres jegyek a jellemzőek, mely a kókuszvirágból kinyert természetes cukorral karamellessé változik. A kókuszvirág cukor háromszor alacsonyabb glikémiás indexű a finomítatlan nyárscukorral összevetve, így ez a csokoládé a Bali tengeri sóvirággal ízesítve nemcsak innovatív, de fenséges és egészséges is.</p><h4>Díjak</h4><ul><li>2013, London Academy of Chocolate, Best Flavored Milk Bar: GOLD</li><li>2012, International Chocolate Awards Finalist</li><li>2011, London Academy of Chocolate, Best Flavored Milk Bar: SILVER</li></ul>', '09.png'),
(10, 2, 'Tejcsokoládé rizspelyhekkel', 2290, 'Anthon Berg', 'Dánia', 200, '<p>Egyszerű, mégis ízletes! Ínycsiklandó tejcsokoládé kukorica~ és rizspehellyel a lágy ízek kedvelőinek.</p>', '10.png'),
(11, 3, 'Málnás Fehér csokoládé tábla', 790, 'Merci', 'Magyarország', 100, '<p>Unod már a szokásos Merci desszertet? Kipróbálnál valami újat? Vagy csak imádod a fehér csokoládé és a málna kettősét? Akkor a Merci málnás fehér csokiját nem hagyhatod ki! A Merci egyik legfinomabb párosítása.</p>', '11.png'),
(12, 3, 'Toscano White', 1905, 'Amedei', 'Olaszország', 50, '<p>Tiszta, finom és buja harmonikus. Amedei csokoládé most fehérbe öltözött.</p>', '12.png'),
(13, 3, 'Fehércsokoládé szárított mangóval és málnával', 635, 'Cavalier', 'Belgium', 40, '<p>Összetevők: Kakaóvaj, teljes tejpor, rostok (dextrin, inulin, oligofruktóz), tejsavópor, édesítőszerek (eritrit, szteviol glikozidok), sovány tejpor, fagyasztva szárított mangó por (4,6 %), fagyasztva szárított málna por (2,7 %), emulgeálószer (szójalecitin), természetes aromák. A fehércsokoládéban a kakaó szárazanyag legalább 44%, tej szárazanyag legalább 40%</p>', '13.png'),
(14, 4, 'Alkoholos kávéval töltött csokoládé', 1100, 'Anthon Berg', 'Dánia', 62, '<p>A dán királyi család hivatalos beszállítója ezennel a nagy kedvenncel tért vissza, végre!\r\nA kimondottan elegáns óarany-csokibarna, ablakos dobozkában négy darab édes üveget találunk, egyesével csomagolva, folyékony híres alkoholos kávékoktélokkal töltve, természetesen csokoládéból készült üvegekbe töltve!</p>', '14.png'),
(15, 4, 'Likőrrel töltött csokoládé', 1100, 'Anthon Berg', 'Dánia', 62, '<p>Bármilyen ünnepi alkalomra ajánljuk ezeket a mini, robosztus ízű, prémium étcsokoládé üvegeket (min. 55% kakaó), melyek a világ legrangosabb szeszes italaival vannak töltve, mint Rémy Martin®, Cointreau®, Grand Marnier® és más kedvencek. Mindegyikük külön, a márka feltüntetésével van csomagolva, így elegáns és tökéletes lezárása lehet egy finom vacsorának.</p>', '15.png'),
(16, 4, 'Koktéllal töltött csokoládé', 3175, 'Anthon Berg', 'Dánia', 250, '<p>Üveg alakú prémium étcsokoládé, a világ legkedveltebb koktéljaival töltve.</p>', '16.png'),
(17, 5, 'Valrhona 32% szőkecsokoládé', 1905, 'ChocoMe', 'Franciaország', 50, '<p>Etióp Yirga tört kávészemek, Piemonte-i mogyoró, Liofilizált karamell</p>', '17.png'),
(18, 5, 'Baileys bonbon', 345, 'Sweetic', 'Magyarország', 7, '<p>Az elegáns vonalvezetésű karamellizált fehércsokoládé (dulcey vagy szőke csokoládé) burokban Baileys likőrös fehércsokoládé ganache található.</p>', '18.png'),
(19, 5, 'Karamellizált fehér csokoládé kakaóbab törettel', 1525, 'Sweetic', 'Magyarország', 30, '<p>Karamellizált fehér csokoládé a csúcsminőségű alapanyagairól ismert francia Valrhona Dulcey csokoládé felhasználásával. Ezt a változatot méltán nevezik az ét- tej- és fehér hármasa mellett az új negyedik fajtának. Próbálja ki, lehet, hogy ez lesz az új kedvence! Ezt a változatot kakaóbab törettel is megszórtuk, hogy a csokoládé lágy textúráját a kakaóbab roppanósságával tegyük izgalmasabbá.</p>', '19.png'),
(20, 5, 'Dulcey 32 %', 1525, 'Valrhona', 'Franciaország', 70, '<p>Dulcey egy sima, krémes csokoládé. Bársonyos és meleg, arany színű. Enyhén vajas, pirítótt és nem túl édes, fokozatosan átadja helyét az ízeknek, egy csipet sóval. A Dulcey vagy szőke csoki színben és ízben a karamelles tejre emlékeztet, összetételében viszont szinte teljesen azonos a fehér csokival és ugyanúgy viselkedik, mint a csokoládék, felhasználása széleskörű. A Dulcey, ahogy a neve is sugallja, ízben a különleges karamellizált tejkrém, a dulce de leche-hez áll legközelebb, azonban állaga nem ragacsos, krémes, hanem ropogós, olvadós, mint ahogy egy csokoládétól megszoktuk.</p>', '20.png');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_client` (`client`);

--
-- A tábla indexei `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_order` (`order`),
  ADD KEY `FK_product` (`product`);

--
-- A tábla indexei `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_category` (`category`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `category`
--
ALTER TABLE `category`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `client`
--
ALTER TABLE `client`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `order`
--
ALTER TABLE `order`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `product`
--
ALTER TABLE `product`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_client` FOREIGN KEY (`client`) REFERENCES `client` (`id`);

--
-- Megkötések a táblához `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `FK_order` FOREIGN KEY (`order`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_product` FOREIGN KEY (`product`) REFERENCES `product` (`id`);

--
-- Megkötések a táblához `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_category` FOREIGN KEY (`category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

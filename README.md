# chocoshop
Csokoládé webshop - ChocoShop

Tervezett funkciók
	Főoldal - index.php
	Termékek megjelenítése - products.php
	Termékadatlap - datasheet.php
	Kosár - cart.php
		Tételek listázása
		Termék db növelése
		Termék db csökkentés
		Termék törlése
		Kosár ürítése
	Rendelés leadás - order.php
	
Törekszünk arra, hogy elkerüljük a kódismétlést.
Különálló PHP szkripteket írunk, melyeket szükség esetén betöltünk.
	Csak folyamatot tartalmazó szkriptek - php/
		Adatbázis csatlakozás - database.php
		Bejelentkezés ellenőrzés - logincheck.php
	Tartalmi elemet tartalmazó szkriptek - components/
		HTML szerkezet eleje - htmltop.php
		HTML szerkezet vége - htmlbottom.php
		Navigációs sáv - navbar.php
		
Egyes esetekben külön függvényeket is definiálunk.
(A megvalósítás procedurális szemlélet szerint történik, NEM OOP)


Más scriptek betöltése egy adott PHP szkriptben
Amikor betöltünk egy szkriptet, akkor az olyan, mintha annak tartalma ott lenne betöltve.
Ehhez rendelkezésre álló függvények:

Erős függés, ha nem található a fájl, Fatal Error szintű hiba, így leaáll a futtatás
require()
require_once()

Gyenge függés, ha nem található a kód, warning szintű hiba, tovább fut a kód.
include()
include_once()

_once jelentése:
Ha ezzel töltünk be egy másik szkriptet, akkor nem engedi többször betölteni, garantáltan egyszer fog futni csak.

A 4 betöltő függvény az echo és a print függvényekhez hasonlóan zárójelek nélkül is működik.

Ha olyan szkripten hivatkozunk, ami máshol töltődik be, ott a betöltés helyéhez kell viszonyítani.

Ha egy 3. fájlon egymás alatt 2 szkript van betöltve, akkor az 1. által definiált változókat a 2. eléri.


Termékek aloldal - products.php
	Lekérdezi a termékek alapadait abc rendbe rendezve
	Ezeket megjeleníti külön dobozokban
	Alapadatok:
		Név, ár, márka, kép, (id)
	Az adatokon kívül elhelyezönk 2 linket:
	Adatlap - datasheet.php, GET kérésben adja át a termék azonosítóját
	Kosárba - Későbbiekben

Termék adatlap - datesheet.php
	GET kérésben várja az azonosítót, hogy melyik terméket kell megjelenítenie.
	Ennek a meglétét és a helyességét ellenőrizni kell.
	Ha hiányzik, az szinte biztos, hogy nem rendeltetésszerű használatból ered. Így ilyen esetben egyszerűen visszairányítunk az előző oldalra. Ha az nincs, akkor a termékekre.
	

Kosár
	Kosár több scriptből fog állni
		Kosárműveletek - php/cartengine.php
		Kosár felület - cart.php
	
	cartengine.php
		GET kérésekkel lesz vezérvelve, hogy a kosár felületen hivatkozásokkal tudjuk majd irányítani.
			Kapott adatok:
				Feladat - task
				Termék azonosító - id
		Feladatai:
			Termék hozzáadni/db növelés - increase
			Termék db csökkentés - decrease
			Termék törlés - delete
			Kosár ürítése - empty - (Ehhez csak task kell)
		Adattárolás:
			Munkamenet alatt cart kulcs - ami szintén egy tömb
				Kulcs: id
				Érték: db - qty
				Példa: 12-es termékből 4 db van a kosárban
					$_SESSION['cart'][12] = 4;
		Egyéb követelmények:
			1 termékből maximum 10 db rendelhető.
			A termék db nem érheti el a 0-t.
			A kosár csak akkor létezik, ha nem üres. A nemlétezése üres kosarat jelent.
			Mivel GET-ben vezéreljük az azonosítót ellenőrizni kell hozzáadáskor.
			
		Működés:
			increase
				Ellenőrizzük, hogy van-e már kosár?
					Ha van kosár, ellenőrizzük, hogy már benne van-e már a termék
						Ha igen, akkor ellenőrizzük, hogy kisebb-e, mint 10?
							Ha igen, akkor növeljük 1-el.
						Ha nem, akkor ellenőrizzük, hogy a termékID helyes-e?
							Ha igen, akkor felvesszük a terméket a kosárban 1 db-bal.	
					Ha nincs, akkor ellenőrizzük, hogy a termékID helyes-e?
						Ha igen, akkor felvesszük a kosarat, benne az adott termékkel, 1 db értékkel.
				
			decrease
				Létezik-e a kosár és benne a termék?
					Ha igen, akkor ellenőrizzük, hogy a db > 1
						Ha igen, akkor csökkentjük 1-el
						Ha nem, akkor töröljük a terméket
			
			delete
				Létezik-e a kosár és benne a termék?
					Ha igen, töröljük a terméket.
					
			empty
				Létezik-e a kosár?
					Ha igen, töröljük a kosarat.
					
	A kosárművelet szkript végén, mindig leellenőrizzük, hogy kiürült-e a kosár, ha igen, akkor megszüntetjük a cart kulcsot
		Létezik-e a kosár és üres-?
			Ha igen, töröljük a kosarat
			
	Műveletek után visszairányítás
		Oda kerüljünk vissza, ahol a kosárműveletet elindítottuk.
	
	$_SERVER['HTTP_REFERER'] - az oldalra irányító cím abszolút hivatkozása
	
		Ellenőrizzük, hogy létezik-e a HTTP_REFERER?
			Ha igen, oda visszairányítunk
			Ha nem, a kosár felületére - cart.php
			
			
Kosár felület - cart.php
	Csak akkor jelenítjük meg, ha van kosár, különben kiírunk egy üzenetet.
	Kosár megjelenítése
		Fejléc
		Termékek
			Név
			Egységár
			Db
			Részösszeg
			increase gomb
			decrease gomb
			delete gomb
		Összesítő sor
			Teljes összeg
			empty gomb
	Működés
		Ciklikusan bejárjuk a kosár tartalmát a $_SESSION-ben
			id és db
			SQL: név és egységár
			Műveletek: Részösszeg számítás, összesítés
			
			
Regisztáció és bejelentkezés - login.php

Regisztráció
Az összes beviteli értéknél meg kell vizsgálni, hogy megfelel-e az adat a mezőtulajdonságoknak
A felhasználót tájékoztatni kell az eredményről és a hibákról
	Felhasználónév
		min 4 karakter
		Nem lehet foglalt
	Jelszó
		min 6 (Éles helyzetben 8-10)
		Megyezik a megerősítéssel
	e-mail
		e-mail formátum
		Nem lehet foglalt
	Számlázási név, cím, szállítási cím
		Ha üres az érték NULL
		Ha nem üres az érték '' karakterek között
		
Jelszó titkosítása
	2 függvényt külön a php mappába
	generateRandomString(charNum):string
	hashPwd(pwd, salt):hashcode
	


Bejelentkezés
	Felhasználónévre/e-mail címre szűrve lekérdezzük az id-t, a hash_password-ot és a hash_salt-ot
	Nincs találat: helytelen Felhasználónév/e-mail
	Van találat: jelszó ellenőrzés
	Ha jó a jelszó is
	Bejelentkezés szerver oldali állapotárolása - munkamenetben
	
***

A jelszavak tárolása az egyik legérzékenyebb része a fejlesztésnek.

Általában a felhasználók egy jelszót használnak több helyen. Ezért veszélyes ha kiszivárog.

Felhasználók és fejlesztők közös felelőssége.

Felhasználó mit tehet?
	Nehéz jelszót talál ki.
		Ideális jelszó:
			Nem értelmes szó, hanem kód.
			Tartalmazzon, kisbetűt, nagybetűt, számot és speciális karaktert.
			Legyen hosszú, akár 20 karakter.
			Minden oldalon egyedi jelszó legyen.
		Az ideális jelszó nem megjegyezhető
			Megoldás: password manager program használata
			A legtöbb böngésző tartalmazza ezt.
				Ilyenkor azt az egy jelszót kell megjegyezni, mely a password managerhez tartozik.

Fejlesztőként
	Ideális jelszó megkövetelése részben/egészben
	Maga a fejlesztő és az üzemeltető sem ismerheti meg véletlenül sem a felhasználók jelszavát.
	A jelszavakat nem tároljuk el eredeti formájukban, hanem azokat titkosítjuk
		Mi magunk se láthatjuk meg az eredeti jelszót.
		Ha feltörik az adatbázist, akkor sem látják a jelszót.

Feltörhetetlenség nem létezik.
Egyéb módszerek:
	Több faktoros hitelesítések.


Titkosítás működése
	Egyirányú titkosítási algoritmusok
		Alapvetően így nem visszafejthető.
	
	Regisztrációkor és bejelentkezéskor is ugyanazt az eljárást alkalmazzuk.
	Csak a titkosított kódot tároljuk el.
	Belépéskor ha a két kód egyezik, meg tudjuk állapítani, hogy a két jelszó egyezik-e.
	Titkosításkor létrejövő kód: hashkód
	Ez számokból és kisbetűkből áll.
	Algoritmustól függően mindig ugyanannyi karakterből fog állni.
	Pl.: sha256 sha512 md5 stb.
	
Az adatbázis kis- és nagybetűre nem érzékeny
Az algoritmusok ugyanazon betű kis és nagy változatából más hash kódot hoznak létre.


A titkosítás önmagában nem elég
Ha több felhasználónak ugyanaz a jelszava, ha csak egyet is feltörnek, az összes érintett fiókhoz hozzáférnek.

Cél: Az egyező jelszavaknál is más legyen a hashkód.
Megoldás
Generálunk egy teljesen random karakterláncot, melyet szintén eltárolunk.
A titkosításba a jelszóhoz hozzáfűzzük. (Akár beágyazott egyéb titkosítási algoritmusok.)
Ezt hívjuk sózásnak, angolul hash salt



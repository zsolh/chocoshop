<?php

    // Admin bejelentkezés ellenőrzés
    require_once 'php/admincheck.php';

    // Webshop adatbázis csatlakozás
    require_once 'php/dbwebshop.php';

    // Üzenetek számára tömb
    $msgArray = array();

    // Űrlap küldés vizsgálat
    if(isset($_POST['upload'])) {

        // 1. Borítókép feltöltése egyedi névvel
        // Tallózás vizsgálat
        if(isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
            // Formátum ellenőrzés
            if($_FILES['img']['type'] == 'image/jpeg') {

                // Egyedi név generálása
                $img = $adminId.time().'.jpg';

                // A generált név foglaltságát ellenőrizzük
                if(!file_exists('../img/'.$img)) {

                    // A képet eltároljuk az új nevével
                    if(!move_uploaded_file($_FILES['img']['tmp_name'], '../img/'.$img)) {
                        $msgArray[] = 'Hiba! Termékkép feltölése sikertelen!';
                    }

                } else {
                    $msgArray[] = 'Hiba! Termékkép ütközés. Próbáld újra!';
                }

            } else {
                $msgArray[] = 'A termékkép nem jpeg formátumú!';
            }
        } else {
            $msgArray[] = 'Termékkép tallózása sikertelen!';
        }

        // 2. adatok feltöltése
        // Ha nem volt hiba csak akkor megyünk tovább
        if(empty($msgArray)) {

            $name = $_POST['name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $brand = $_POST['brand'];
            $country = $_POST['country'];
            $weight = $_POST['weight'];
            $description = $_POST['description'];

            if(strlen($name) < 4 || strlen($name) > 100) {
                $msgArray[] = 'A név hossza nem megfelelő!';
            }

            if($price < 1) {
                $msgArray[] = 'Az ár nem lehet kisebb, mint 1!';
            }

            if(strlen($brand) < 3 || strlen($brand) > 50) {
                $msgArray[] = 'A márka hossza nem megfelelő!';
            }

            if(strlen($country) < 5 || strlen($country) > 50) {
                $msgArray[] = 'A származási hely hossza nem megfelelő!';
            }

            if($weight < 0 || $weight > 99999) {
                $msgArray[] = 'A megadott súly nem megfelelő!';
            }

            if(empty($description)) {
                $msgArray[] = 'A leírás megadása kötelező!';
            }

        }

        // Ha a szöveges értékekkel sem volt hiba, akkor rögzíthetjük az új terméket
        if(empty($msgArray)) {

            // Beszúró utasítás
            $sql_newProduct = 
            "INSERT INTO product(name, category, price, brand, country, weight, description, img) 
            VALUES 
            ('$name', '$category', '$price', '$brand', '$country', '$weight', '$description', '$img')";

            if(mysqli_query($dbWebshop, $sql_newProduct)) {
                $msgArray[] = 'Új termék sikeresen feltöltve!';
            } else {
                $msgArray[] = 'Sikertelen feltöltés! (SQL)';
            }

        }

    }

    // Cím definiálása
    $title = 'Új termék feltöltése';

    // HTML szerkezet eleje
    require_once 'components/htmlstart.php';

?>

<div class="container bg-light">
    <div class="row">
        <div class="col-3">
            <a href="index.php" class="btn btn-sm btn-dark mt-3">Vissza</a>
        </div>
        <h1 class="col-6 text-center my-3"><?=$title?></h1>
    </div>

    <div class="row">
        <?php
            // Ha van üzenet kiírjuk
            if(count($msgArray) > 0) {
                ?>
                <div class="col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 mx-auto text-center bg-white shadow p-3 mb-4">
                    <ul>
                    <?php
                        foreach($msgArray as $msg) {
                            echo '<li>'.$msg.'</li>';
                        }
                    ?>
                    </ul>
                </div>
                <div class="col-12"></div>
                <?php
            }
        ?>

        <form action="" method="post" class="form-group text-center bg-white shadow p-3 mb-4 col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 mx-auto" enctype="multipart/form-data">

            <label>Termék neve:</label>
            <input type="text" name="name" minlength="4" maxlength="100" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Kategória:</label>
            <select name="category" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8">
                <?php
                
                    // Kategóriák betöltése opciókként
                    $result_catOptions = mysqli_query($dbWebshop, "SELECT * FROM category");
                    while($catOption = mysqli_fetch_assoc($result_catOptions)) {
                        echo ' <option value="'.$catOption['id'].'">'.$catOption['name'].'</option> ';
                    }

                ?>
            </select>

            <label>Ár:</label>
            <input type="number" name="price" min="1" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Márka:</label>
            <input type="text" name="brand" minlength="4" maxlength="50" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Származási hely:</label>
            <input type="text" name="country" minlenght="5" maxlength="50" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Súly:</label>
            <input type="number" name="weight" min="0" max="99999" step="1" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Leírás:</label>
            <textarea name="description" rows="5" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required></textarea>

            <label>Borítókép:</label>
            <input type="file" name="img" accept="image/jpeg" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <button type="submit" name="upload" class="btn btn-dark">Feltöltés</button>

        </form>
    </div>

</div>

<?php

    // HTML szerkezet vége
    require_once 'components/htmlend.php';

?>
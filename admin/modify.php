<?php

    // Admin bejelentkezés ellenőrzés
    require_once 'php/admincheck.php';

    // Webshop adatbázis csatlakozás
    require_once 'php/dbwebshop.php';

    // GET id
    $idOk = false;
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        $sql_productData = 
        "SELECT category.name AS category, product.name, product.price, product.brand, product.country, product.weight, product.description
        FROM product INNER JOIN category ON category.id=product.category
        WHERE product.id=$id";
        $result_productData = mysqli_query($dbWebshop, $sql_productData);
        if(mysqli_num_rows($result_productData) == 1) {
            $productData = mysqli_fetch_assoc($result_productData);
            $idOk = true;
        }
    }

    if(!$idOk) {
        header('Location: products.php');
    }

    // Üzenetek számára tömb
    $msgArray = array();

    // Űrlap küldés vizsgálat
    if(isset($_POST['modify'])) {

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
            $msgArray[] = 'A származási ország hossza nem megfelelő!';
        }

        if($weight < 0 || $weight > 99999) {
            $msgArray[] = 'A megadott súly nem megfelelő!';
        }

        if(empty($description)) {
            $msgArray[] = 'A leírás megadása kötelező!';
        }

        // Ha a szöveges értékekkel sem volt hiba, akkor rögzíthetjük az új terméket
        if(empty($msgArray)) {

            // Beszúró utasítás
            $sql_modifyproduct = 
            "UPDATE product SET 
            name='$name', 
            category=$category, 
            price=$price, 
            brand='$brand', 
            country='$country', 
            weight='$weight', 
            description='$description'
            WHERE id=$id";

            if(mysqli_query($dbWebshop, $sql_modifyproduct)) {
                $msgArray[] = 'Termék sikeresen módosítva!';
            } else {
                $msgArray[] = 'Sikertelen módosítás! (SQL)';
            }

        }

    }

    // Cím definiálása
    $title = 'Termék módosítása';

    // HTML szerkezet eleje
    require_once 'components/htmlstart.php';

?>

<div class="container bg-light">
    <div class="row">
        <div class="col-3">
            <a href="products.php" class="btn btn-sm btn-dark mt-3">Vissza</a>
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

            <label>Játék neve:</label>
            <input type="text" name="name" value="<?=$productData['name']?>" minlength="4" maxlength="100" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Kategória:</label>
            <select name="category" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8">
                <?php
                
                    // Kategóriák betöltése opciókként
                    $result_catOptions = mysqli_query($dbWebshop, "SELECT * FROM category");
                    while($catOption = mysqli_fetch_assoc($result_catOptions)) {
                        echo ($productData['category'] == $catOption['name']) 
                        ?
                        ' <option value="'.$catOption['id'].'" selected>'.$catOption['name'].'</option> '
                        :
                        ' <option value="'.$catOption['id'].'">'.$catOption['name'].'</option> ';
                    }

                ?>
            </select>

            <label>Ár:</label>
            <input type="number" name="price" value="<?=$productData['price']?>" min="1" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Márka:</label>
            <input type="text" name="brand" value="<?=$productData['brand']?>" minlength="3" maxlength="50" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Származási ország:</label>
            <input type="text" name="country" value="<?=$productData['country']?>" minlenght="5" maxlength="50" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Súly:</label>
            <input type="number" name="weight" value="<?=$productData['weight']?>" min="0" max="99999" step="1" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Leírás:</label>
            <textarea name="description" rows="5" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required><?=$productData['description']?></textarea>

            <button type="submit" name="modify" class="btn btn-dark">Módosítás</button>

        </form>
    </div>

</div>

<?php

    // HTML szerkezet vége
    require_once 'components/htmlend.php';

?>
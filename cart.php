

<?php
    require_once 'php/database.php'; // Adatbázis csatlakozás - dbCon
    require_once 'php/logincheck.php'; // Bejelentkezés vizsgálata

    $pageTitle = 'Kosár'; // Dinamikus oldalcím
    require_once 'components/htmltop.php'; // HTML szerkezet eleje
    require_once 'components/navbar.php'; // Navigációs sáv
?>

<!-- Az oldal egyedi tartalma. -->
<div class="container">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$pageTitle?></h1>

        <?php
        
            // Ellenőrizzük a kosarat
            if(isset($_SESSION['cart'])) {
                // Van kosár
                ?>

                <div class="col-12 col-md-9 mx-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Név</th>
                                <th class="text-end">Egységár</th>
                                <th class="text-center" colspan="3">Db</th>
                                <th class="text-end">Részösszeg</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                            // Dinamikus kosár tartalom
                            $totalPrice = 0; // Összesítéshez változó

                            // Bejárjuk a kosarat
                            foreach($_SESSION['cart'] as $productId => $qty) {
                                // SQL: szükséges adatok lekérdezése
                                $result_cartItemData = 
                                mysqli_query($dbCon, "SELECT name, price FROM product WHERE id=$productId");
                                $cartItemData = mysqli_fetch_assoc($result_cartItemData);
                                // Műveletek
                                $subTotal = $qty * $cartItemData['price']; // Részösszeg
                                $totalPrice += $subTotal; // Összesítés
                                ?>
                                <tr>
                                    <td><?=$cartItemData['name']?></td>
                                    <td class="text-end"><?=number_format($cartItemData['price'],0,'',' ')?> Ft</td>
                                    <td class="text-end">
                                        <a href="php/cartengine.php?task=decrease&id=<?=$productId?>">
                                            <i class="fas fa-minus-square"></i>
                                        </a>
                                    </td>
                                    <td class="text-center"><?=$qty?></td>
                                    <td>
                                        <a href="php/cartengine.php?task=increase&id=<?=$productId?>">
                                            <i class="fas fa-plus-square"></i>
                                        </a>
                                    </td>
                                    <td class="text-end"><?=number_format($subTotal,0,'',' ')?> Ft</td>
                                    <td class="text-center">
                                        <a href="php/cartengine.php?task=delete&id=<?=$productId?>">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }

                        ?>
                            <tr class="fw-bold">
                                <td colspan="5">Összesen:</td>
                                <td class="text-end"><?=number_format($totalPrice,0,'',' ')?> Ft</td>
                                <td class="text-center">
                                    <a href="php/cartengine.php?task=empty">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                            <div class="col-12 text-center mb-4">

                            <?php
                            
                                echo($login) 
                                ? '<a href="order.php" class="btn btn-lg btn-gradient">Rendelés leadása</a> '
                                : '<a href="login.php" class="btn btn-lg btn-gradient">Jelentkezzen be</a> '
                            ?>

                            </div>

                <?php
            } else {
                // Nincs kosár
                ?>
                <h3 class="col-12 text-center mb-3">A kosár üres!</h3>
                <div class="col-12 text-center">
                    <a href="products.php" class="btn btn-lg btn-gradient">Tovább a termékekhez!</a>
                </div>
                <?php
            }

        ?>

    </div>
</div>

<?php
    require_once 'components/htmlbottom.php'; // HTML szerkezet vége
?>
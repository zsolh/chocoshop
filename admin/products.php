<?php

    // Admin bejelentkezés ellenőrzés
    require_once 'php/admincheck.php';

    // productshop adatbázis
    require_once 'php/dbwebshop.php';

    // Cím definiálása
    $title = 'Játékok adminisztrációja';

    // HTML szerkezet eleje
    require_once 'components/htmlstart.php';

?>

<div class="container bg-light">
    <div class="row">
        <div class="col-3">
            <a href="index.php" class="btn btn-sm btn-dark mt-3">Vissza</a>
        </div>
        <h1 class="col-6 text-center my-3"><?=$title?></h1>
        <table class="table col-12 mx-auto table-light table-borderless table-striped mb-4 shadow">
            <thead class="table-dark">
                <tr>
                    <th>id</th>
                    <th>Kategória</th>
                    <th>Név</th>
                    <th>Ár</th>
                    <th>Márka</th>
                    <th>Ország</th>
                    <th>Súly</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                    $sql_productList = 
                    "SELECT product.id, category.name AS category, product.name, product.price, product.brand, product.country, product.weight
                    FROM product INNER JOIN category ON category.id=product.category ORDER BY id ASC";
                    $result_productList = mysqli_query($dbWebshop, $sql_productList);
                    while($productData = mysqli_fetch_assoc($result_productList)) {
                        ?>
                        <tr>
                            <td><?=$productData['id']?></td>
                            <td><?=$productData['category']?></td>
                            <td><?=$productData['name']?></td>
                            <td class="text-right"><?=number_format($productData['price'],0,'',' ')?> Ft</td>
                            <td><?=$productData['brand']?></td>
                            <td><?=$productData['country']?></td>
                            <td><?=$productData['weight']?> g</td>
                            <td>
                                <a href="modify.php?id=<?=$productData['id']?>" class="btn btn-sm btn-outline-warning">Módosítás</a>
                            </td>
                            <td>
                                <a href="php/delete.php?id=<?=$productData['id']?>" class="btn btn-sm btn-outline-danger">Törlés</a>
                            </td>
                        </tr>
                        <?php
                    }

                ?>
            </tbody>
        </table>
    </div>
</div>

<?php

    // HTML szerkezet vége
    require_once 'components/htmlend.php';

?>
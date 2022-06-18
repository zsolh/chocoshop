<?php
    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    if(!$login || !isset($_SESSION['cart'])){
        header('Location: cart.php');
    }

    $pageTitle = 'Rendelés leadása';

    require_once 'components/htmltop.php';
    require_once 'components/navbar.php';
?>


<div class="container">
    <div class="row">
    <h1 class="col-12 text-center my-4"><?=$pageTitle?></h1>

    <div class="col-12 col-md-9 mx-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th class="text-end">Egységár</th>
                        <th class="text-center">Db</th>
                        <th class="text-end">Részösszeg</th>
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
                            
                            <td class="text-center"><?=$qty?></td>

                            <td class="text-end"><?=number_format($subTotal,0,'',' ')?> Ft</td>

                        </tr>
                        <?php
                    }

                ?>
                    <tr class="fw-bold">
                        <td colspan="3">Összesen:</td>
                        <td class="text-end"><?=number_format($totalPrice,0,'',' ')?> Ft</td>

                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="row">
            <h2 class="col-12 text-center my-4">Rendelés adatai</h2>

            <div class="col-12 col-md-6 mx-auto"> 
                <div class="rounded text-center p-3 mt-4 form-box"> 
                    <form action="php/orderprocess.php" method="post" class="col-12 col-sm-6 col-md-12 col-lg-9 col-xl-6 mx-auto m-0"> 
                    
                    <label>Számlázási név:</label>
                    <input type="text" name="bill_name" class="form-control mb-3" required>

                    <label>Számlázási cím:</label>
                    <input type="text" name="bill_address" class="form-control mb-3" required>

                    <label>Fizetési mód</label>
                    <select name="payment_mode" class="form-select mb-3">
                        <option value="Banki átutalás">Banki átutalás</option>
                        <option value="Utánvét">Utánvét</option>
                    </select>

                    <label>Szállítási cím:</label>
                    <input type="text" name="delivery_address" class="form-control mb-3" required>

                    <label>Szállítási mód</label>
                    <select name="delivery_mode" class="form-select mb-3">
                        <option value="Postai csomag">Postai csomag</option>
                        <option value="Futárszolgálat">Futárszolgálat</option>
                    </select>

                    <button type="submit" class="btn btn-gradient" name="newOrder">Megrendelés</button>
                    </form> 
            </div> 
            
        </div>
    </div>
</div>
<?php
    require_once('components/htmlbottom.php');
    
?>

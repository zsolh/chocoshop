<?php
    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    $pageTitle = 'Termékek';

    require_once 'components/htmltop.php';
    require_once 'components/navbar.php';
?>

<div class="container">
    <div class="row">
        <h1 class="col-12 text-center my-4">
        <?=$pageTitle?>
        </h1>
        <?php
            $sql_products = "SELECT id, name, price, brand, img FROM product ORDER BY name ASC";
            $result_products = mysqli_query($dbCon, $sql_products);
            while($productDetails = mysqli_fetch_assoc($result_products)){
                ?>
                    <div class="col-12 col-md-6 col-lg-4 col-xxl-3">
                        <div class="p-3 mb-3 text-center rounded product-box">
                            <h5 class="mt-0"><?=$productDetails['name']?></h5>
                            <div class="mx-auto">
                                <img src="img/<?=$productDetails['img']?>" alt="<?=$productDetails['name']?>" title="<?=$productDetails['name']?>">
                            </div>
                            <p class="mt-2"><?=$productDetails['brand']?></p>
                            <h3><?=number_format($productDetails['price'],0, '', ' ')?> Ft</h3>
                            <a href="datasheet.php?id=<?=$productDetails['id']?>" class="btn btn-sm btn-transparent">
                            <i class="fas fa-file-alt"></i>
                            Adatlap</a>
                            <a href="php/cartengine.php?task=increase&id=<?=$productDetails['id']?>" class="btn btn-sm btn-gradient">
                            <i class="fas fa-cart-arrow-down"></i>  
                            Kosárba</a>

                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>

<?php
    require_once('components/htmlbottom.php');
    
?>
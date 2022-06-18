<?php
    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    $isIdOk = false;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        if(is_numeric($id)){
            $sql_productDetails = 
            "SELECT category.name AS category, product.name, product.price, 
            product.brand, product.country, product.weight, product.description, product.img
            FROM product INNER JOIN category ON category.id = product.category
            WHERE product.id=$id";
            $result_productDetails = mysqli_query($dbCon, $sql_productDetails);
            if(mysqli_num_rows($result_productDetails) == 1){
                $isIdOk = true;
                $productDetails = mysqli_fetch_assoc($result_productDetails);
            }
        }
    }

    if(!$isIdOk){
        header('Location: products.php');
    }

    $pageTitle = $productDetails['name'];
    require_once 'components/htmltop.php';
    require_once 'components/navbar.php';
?>

    <div class="container">
        <div class="row">
            <h1 class="col-12 text-center my-4"><?=$pageTitle?></h1>

            <div class="col-12 col-md-6 text-center">
                <img src="img/<?=$productDetails['img']?>" 
                alt="<?=$productDetails['name']?> termékfotó" 
                title="<?=$productDetails['name']?>">
            </div>
            <div class="col-12 col-md-6">
                <table class="table">
                    <tr>
                        <td>Kategória:</td>
                        <td><?=$productDetails['category']?></td>
                    </tr>
                    <tr>
                        <td>Márka:</td>
                        <td><?=$productDetails['brand']?></td>
                    </tr>
                    <tr>
                        <td>Származási hely:</td>
                        <td><?=$productDetails['country']?></td>
                    </tr>
                    <tr>
                        <td>Súly:</td>
                        <td><?=number_format($productDetails['weight'], 0, '', ' ')?> g</td>
                    </tr>
                </table>
                <h3 class="text-center my-5"><?=number_format($productDetails['price'], 0, '', ' ')?> Ft</h3>

                <div class="text-center">
                    <a href="php/cartengine.php?task=increase&id=<?=$id?>" class="btn btn-lg btn-gradient">
                    <i class="fas fa-cart-arrow-down"></i>    
                    Kosárba</a>
                </div>

            </div>
            <div class="col-12 mt-5">
                <?=$productDetails['description']?>
            </div>
        </div>
    </div>

<?php
    require_once('components/htmlbottom.php');
    
?>
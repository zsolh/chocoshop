<?php
    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    $pageTitle = 'Rendelés visszaigazolás';

    require_once 'components/htmltop.php';
    require_once 'components/navbar.php';
?>

<div class="container">
    <div class="row">
    <h1 class="col-12 text-center my-4"><?=$pageTitle?></h1>

        <?php

            if(isset($_GET['success']) && $_GET['success'] == true){
                ?>
                
                <h3 class="col-12 text-center mb-3">
                Sikeres</h3>

                <div class="col-12 text-center">
                <a href="products.php" class="btn btn-lg btn-gradient mb-4">Vissza a termékekhet</a>
                </div>
                
                <?php
            }else{
                ?>
                
                <h4 class="col-12 text-center mb-4">
                Sikertelen</h3>

                    <p class="col-12 text-center mb-4">Üzemeltetői kapcsolt</p>
                
                <?php
            }
        ?>
    
    </div>
</div>


<?php
    require_once('components/htmlbottom.php');
    
?>

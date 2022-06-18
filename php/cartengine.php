<?php
function checkProductId($productId){
    require_once 'database.php';
    $result_checkId = mysqli_query($dbCon, "SELECT id FROM product WHERE id='$productId'");
    return (mysqli_num_rows($result_checkId) == 1);
}

session_start();


if(isset($_GET['task'])){
    $task = $_GET['task'];

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        //increase
        if($task == 'increase'){
            if(isset($_SESSION['cart'])){
                //van kosár
                if(isset($_SESSION['cart'][$id])){
                    //benne van
                    if($_SESSION['cart'][$id] < 10){
                        //növelhetjük
                        $_SESSION['cart'][$id]++;
                    }

                }else{
                    //nincs benne
                    if(checkProductId($id)){
                        $_SESSION['cart'][$id] = 1;
                    }
                }
            }else{
                //nincs kosár
                if(checkProductId($id)){
                    $_SESSION['cart'] = array();
                    $_SESSION['cart'][$id] = 1;
                }
            }
        }

        //decrease
        if($task == 'decrease'){
            if(isset($_SESSION['cart'][$id])){
                if($_SESSION['cart'][$id] > 1){
                    $_SESSION['cart'][$id]--;
                }else{
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
        //delete
        if($task == 'delete'){
            if(isset($_SESSION['cart'][$id])){
                unset($_SESSION['cart'][$id]);
            }
        }

    }

    //empty
    if($task == 'empty'){
        if(isset($_SESSION['cart'])){
            unset($_SESSION['cart']);
        }
    }

}

if(isset($_SESSION['cart']) && empty($_SESSION['cart'])){
    unset($_SESSION['cart']);
}

/*
if(isset($_SERVER['HTTP_REFERER'])){
    $backPath = $_SERVER['HTTP_REFERER'];
}else{
    $backPath = '../cart.php';
}
*/

$backPath = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../cart.php';

header('Location: '.$backPath);

?>


<pre><?php
    print_r($_SESSION['cart']);
?></pre>
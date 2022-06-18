<?php

    require_once 'database.php';
    require_once 'logincheck.php';
    if(!$login || !isset($_SESSION['cart'])){
        header('Location: ../cart.php');
    }


    $error = false;

    if(isset($_POST['newOrder'])){
        
        if(!isset($_POST['bill_name'])
        || !isset($_POST['bill_address'])
        ||!isset($_POST['payment_mode'])
        ||!isset($_POST['delivery_address'])
        || !isset($_POST['delivery_mode'])
        ){
            $error = true;
        }else if(
            !isset($_POST['bill_name'])
        || !isset($_POST['bill_address'])
        ||!isset($_POST['payment_mode'])
        ||!isset($_POST['delivery_address'])
        || !isset($_POST['delivery_mode'])
        ){
            $error = true;
        }else if(!
            ($_POST['payment_mode'] == 'Banki átutalás'
            || $_POST['payment_mode'] == 'Utánvét')
            ||
            !($_POST['delivery_mode'] == 'Postai csomag'
            || $_POST['delivery_mode'] == 'Futárszolgálat')
        ){
            $error = true;
        }else if(
            strlen($_POST['bill_name'] > 100)
            ||strlen($_POST['bill_address'] > 100)
            ||strlen($_POST['delivery_address'] > 100)
        ){
            $error = true;
        }
            if(!$error){
                require_once  'randomstring.php';
                $i = 0;
                do{
                    $order_number = $userId.'-'.generateRandomString(6);
                    $result_checkOrderNum = mysqli_query($dbCon, "SELECT `id`
                        FROM `order`
                        WHERE `order_number` LIKE '$order_number'");
                        $i++;
                }while(mysqli_num_rows($result_checkOrderNum) > 0 && i < 5 );

                if($i >= 5){
                    $error = true;
                }
            }

            if(!$error){
                $bill_name = $_POST['bill_name'];
                $bill_address = $_POST['bill_address'];
                $payment_mode = $_POST['payment_mode'];
                $delivery_address = $_POST['delivery_address'];
                $delivery_mode = $_POST['delivery_mode'];

                $sql_insertOrder = 
                "INSERT `order`
                (`order_number`, `client`, `bill_name`, `bill_address`, `payment_mode`, `delivery_address`, `delivery_mode`)
                VALUES 
                ('$order_number', '$userId', '$bill_name', '$bill_address', '$payment_mode', '$delivery_address', '$delivery_mode')";

                if(!mysqli_query($dbCon, $sql_insertOrder)){
                    $error = true;
                }

            }

            if(!$error){
                $result_orderId = mysqli_query($dbCon, "SELECT `id` FROM `order` WHERE `order_number` LIKE '$order_number'");
                if(mysqli_num_rows($result_orderId) == 1){
                    $orderId = mysqli_fetch_assoc($result_orderId);
                    $orderId = $orderId['id'];
                }else{
                    $error = true;
                }
            }
            if(!$error){
                foreach($_SESSION['cart'] as $productId => $qty){
                    $result_productPrice =
                    mysqli_query($dbCon, "SELECT price FROM product WHERE id=$productId");
                    $productPrice = mysqli_fetch_assoc($result_productPrice);
                    $productPrice = $productPrice['price'];

                    $sql_insertOrderItem =
                    "INSERT INTO `order_item`(`order`, `product`, `order_price`, `qty`)
                    VALUES 
                    ($orderId, $productId, $productPrice, $qty)";

                    if(!mysqli_query($dbCon, $sql_insertOrderItem)){
                        $error = true;
                    }
                }
            }
    }
    
    if(!$error){
        unset($_session['CART']);
        $nextPath = '../orderconfirm.php?success=true';


    }else{
        $nextPath = '../orderconfirm.php';
    }

    header('Location: '.$nextPath);

?>
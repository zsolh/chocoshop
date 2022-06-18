
<?php
    require_once 'php/database.php'; // Adatbázis csatlakozás - dbCon
    require_once 'php/logincheck.php'; // Bejelentkezés vizsgálata

    if($login){
        header('Location: ./');
    }

    $loginMsg = '';
    if(isset($_POST['login'])){
        if(!isset($_POST['userOrEmail']) || empty($_POST['userOrEmail'])){
            $loginMsg .= '<li>Hiányzó adat felhasználónév</li>'; 
        }

        if(!isset($_POST['password']) || empty($_POST['password'])){
            $loginMsg .= '<li>Hiányzó adat jelszó</li>'; 
        }

        if(empty($loginMsg)){
            $userOrEmail = $_POST['userOrEmail'];
            $sql_loginData = "SELECT id, hash_password, hash_salt FROM client
            WHERE username like '$userOrEmail' OR email like '$userOrEmail'";

            $result_loginData = mysqli_query($dbCon, $sql_loginData);

            if(mysqli_num_rows($result_loginData) == 1){
                $loginData = mysqli_fetch_assoc($result_loginData);
                require_once 'php/hashpwd.php';
                if(generateHashCode($_POST['password'], $loginData['hash_salt']) == $loginData['hash_password']){
                    
                    $_SESSION['userId'] = $loginData['id'];
                    header('Location: ./');

                }else{
                    $loginMsg .= '<li>Helyzelen jelszó</li>'; 
                }

            }else{
                $loginMsg .= '<li>Helytel felhasználónév vag yemail</li>'; 
            }
        }
    }

    $regMsg = '';
    if(isset($_POST['reg'])){
        if(!isset($_POST['username']) || empty($_POST['username'])){
            $regMsg .= '<li>Hiányzó adat: felhasználónév</li>';
        }else if (strlen($_POST['username']) < 4){
            $regMsg .= '<li>A felhasználónév rövidebb, mint 4 kar</li>';
        }else if(strlen($_POST['username']) > 10){
            $regMsg .= '<li>A felhasználónév hosszabb, mint 10 kar</li>';
        }else{
            $username = $_POST['username'];
            $result_checkUsername = mysqli_query($dbCon, "SELECT id FROM client WHERE username like '$username'");
            if(mysqli_num_rows($result_checkUsername) > 0){
                $regMsg .= '<li>A felh név foglalt</li>';
            }
        }


        if(!isset($_POST['email']) || empty($_POST['email'])){
            $regMsg .= '<li>Hiányzó adat: emailcím</li>';
        }else if(strlen($_POST['email']) > 50 ){
            $regMsg .= '<li>A email hosszabb, mint 50 kar</li>';
        }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $regMsg .= '<li>nem megfelelő email formátum</li>';
        }else{
            $email = $_POST['email'];
            $result_checkEmail = mysqli_query($dbCon, "SELECT id FROM client WHERE email like '$email'");
            if(mysqli_num_rows($result_checkEmail) > 0){
                $regMsg .= '<li>már regiszráltak erre a címre</li>';
            }
        }

        if(!isset($_POST['password']) || empty($_POST['password'])){
            $regMsg .= '<li>Hiányzó adat: jelszó</li>';
        }else if(strlen($_POST['password']) < 6){
            $regMsg .= '<li>A jelszó rövidenn, mint 6 kar</li>';
        }else if(!isset($_POST['again']) || empty($_POST['again'])){
            $regMsg .= '<li>Hiányzó adat: again</li>';
        }else if($_POST['password'] != $_POST['again']){
            $regMsg .= '<li>nem egyezik</li>';
        } 


        $bill_name = "NULL";
        if(isset($_POST['bill_name'])  && !empty($_POST['bill_name'])){
            if(strlen($_POST['bill_name']) > 100){
                $regMsg .= '<li>a szal név osszabb mint 100 kart</li>';
            }else{
                $bill_name = "'".$_POST['bill_name']."'";
            }
        }

        $bill_address = "NULL";
        if(isset($_POST['bill_address'])  && !empty($_POST['bill_address'])){
            if(strlen($_POST['bill_address']) > 100){
                $regMsg .= '<li>a számla  címhosszabb mint 100 kart</li>';
            }else{
                $bill_address = "'".$_POST['bill_address']."'";
            }
        }

        $delivery_address = "NULL";
        if(isset($_POST['delivery_address'])  && !empty($_POST['delivery_address'])){
            if(strlen($_POST['delivery_address']) > 100){
                $regMsg .= '<li>aszállítási cím osszabb mint 100 kart</li>';
            }else{
                $delivery_address = "'".$_POST['delivery_address']."'";
            }
        }

        if($regMsg == ''){
            require_once 'php/randomstring.php';
            $hash_salt = generateRandomString(20);
            require_once 'php/hashpwd.php';
            $hash_password = generateHashCode($_POST['password'], $hash_salt);

            $sql_insertClient = 
            "INSERT INTO client 
            (username, hash_password, hash_salt, email, bill_name, bill_address, delivery_address)
            VALUES 
            ('$username', '$hash_password', '$hash_salt', '$email', $bill_name, $bill_address, $delivery_address)";

            if(mysqli_query($dbCon, $sql_insertClient)){
                $regMsg .= '<li>sikeres reg</li><li>jelentkezz be az első űrlap segítségével</li>';
            }else{
                $regMsg .= '<li>sikertelen reg</li>';
            }
        }
            
    }

    $pageTitle = 'Bejelentkezés'; // Dinamikus oldalcím
    require_once 'components/htmltop.php'; // HTML szerkezet eleje
    require_once 'components/navbar.php'; // Navigációs sáv
?>

<!-- Az oldal egyedi tartalma. -->
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="rounded text-center p-3 mt-4 form-box">
                <h2 class="mt-0 mb-3">Bejelentkezés</h2>

                <?php
                if(!empty($loginMsg)){
                        echo '<ul>'.$loginMsg.'</ul>';
                }
                ?>
                
                <form action="" method="post" class="col-12 col-sm-6 col-md-12 col-lg-9 col-xl-6 mx-auto m-0">

                    <label>Felhasználónév vagy e-mail cím:</label>
                    <input type="text" name="userOrEmail" class="form-control mb-3" required>

                    <label>Jelszó:</label>
                    <input type="password" name="password" class="form-control mb-3" required>

                    <button type="submit" class="btn btn-gradient" name="login">Bejelentkezés</button>
                    
                </form>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="rounded text-center p-3 mt-4 form-box">
                <h2 class="mt-0 mb-3">Regisztráció</h2>

                <?php
                if(!empty($regMsg)){
                        echo '<ul>'.$regMsg.'</ul>';
                }
                ?>

                <form action="" method="post" class="col-12 col-sm-6 col-md-12 col-lg-9 col-xl-6 mx-auto m-0">

                    <h3>Kötelező adatok:</h3>

                    <label>Felhasználónév:</label>
                    <input type="text" name="username" class="form-control mb-3" required>

                    <label>e-mail cím:</label>
                    <input type="email" name="email" class="form-control mb-3" required>

                    <label>Jelszó:</label>
                    <input type="password" name="password" class="form-control mb-3" required>

                    <label>Jelszó megerősítése</label>
                    <input type="password" name="again" class="form-control mb-3" required>

                    <h3>Opcionális adatok:</h3>

                    <label>Számlázási név:</label>
                    <input type="text" name="bill_name" class="form-control mb-3">

                    <label>Számlázási cím:</label>
                    <input type="text" name="bill_address" class="form-control mb-3">

                    <label>Szállítási cím:</label>
                    <input type="text" name="delivery_address" class="form-control mb-3">

                    <button type="submit" class="btn btn-gradient" name="reg">Regisztráció</button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once 'components/htmlbottom.php'; // HTML szerkezet vége
?>
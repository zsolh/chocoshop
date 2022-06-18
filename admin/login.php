<?php

    // Admin adatbázis csatlakozás
    require_once 'php/dbadmin.php';

    // Hibakezelő karakterlánc
    $errorMsg = '';

    // Bejelentkezés folyamata
    if(isset($_POST['adminname']) && isset($_POST['adminpwd'])) {

        // Felvesszük változóba a felhasználónevet
        $adminname = $_POST['adminname'];
        // A jelszót pedig egyből titkosítva tároljuk változóba
        $adminpwd = hash('sha512', $_POST['adminpwd']);

        // Írunk egy lekérdezést az admin azonosítójára ezekkel az adatokkal
        $result_adminId = mysqli_query($dbAdmin, "SELECT id FROM admin WHERE adminname LIKE '$adminname' AND adminpwd LIKE '$adminpwd'");

        // Megnézzük volt-e találat, azaz, hogy a felhasználó helyes adatokat adott-e meg
        if(mysqli_num_rows($result_adminId) == 1) {
            // Helyes adatok
            // Munkamenet
            session_start();
            // Adat tömbbé alakítása
            $adminId = mysqli_fetch_assoc($result_adminId);
            $_SESSION['adminId'] = $adminId['id'];

            // Továbbirányítás a főoldalra
            header('Location: index.php');

        } else {
            // Helytelen adatok
            $errorMsg = ' <h5 class="text-danger">Hibás belépési adatok!</h5> ';
        }

    }

    // Cím definiálása
    $title = 'Bejelentkezés';

    // HTML szerkezet eleje
    require_once 'components/htmlstart.php';

?>

<div class="container">
    <div class="row">

        <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-5 mx-auto mt-4 p-3 shadow bg-light rounded text-center">

            <h4>Bejelentkezés</h4>
            <?=$errorMsg?>
            <form action="" method="post" class="form-group">

                <label>Felhasználónév:</label>
                <input type="text" name="adminname" class="col-10 col-sm-8 col-md-7 mx-auto form-control mb-3" required>

                <label>Jelszó:</label>
                <input type="password" name="adminpwd" class="col-10 col-sm-8 col-md-7 mx-auto form-control mb-3" required>

                <button type="submit" class="btn btn-dark">Bejelentkezés</button>

            </form>

        </div>

    </div>
</div>

<?php

    // HTML szerkezet vége
    require_once 'components/htmlend.php';

?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="./">ChocoShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="products.php"><i class="fas fa-list"></i>Termékek</a>
                    
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i>Kosár</a>
                </li>

                <?php 
                
                    $navUsername = 'Fiók';
                    if($login){
                        $result_userName = 
                        mysqli_query($dbCon, "SELECT username FROM client WHERE id=$userId");
                        $userName = mysqli_fetch_assoc($result_userName);
                        $userName = $userName['username'];
                        $navUsername = $userName;
                    }
                
                ?>
                
                <li class="nav-item dropdown"> 
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                        <i class="fas fa-user"></i><?=$navUsername?> 
                    </a> 
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                        <?php
                            if($login){
                                echo '<li><a class="dropdown-item" href="php/logout.php">Kijelentkezés</a></li>';

                            }else{
                                echo '<li><a class="dropdown-item" href="login.php">Bejelentkezés</a></li>';
                            }
                        ?>
                    </ul> 
                </li>

            </ul>
        </div>
    </div>
</nav>
<div class="navbar-spacing"></div>

<header>
        <div class="navbar">
            <div class="logo">
                <a href="/Demetech/index.php">
                    <img src="/Demetech/public/assets/Logo_long.png" alt="Demetech Logo" class="logo-image">
                </a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Rechercher...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
            <nav>
                <ul>
                    <li><a href="/Demetech/index.php" class="active">Accueil</a></li>
                    <li><a href="#">Produits</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="#"><i class="far fa-heart"></i></a>
                <a href="#"><i class="fas fa-shopping-cart"></i></a>
                <a href="#" id="modalCRbtn"><i class="fas fa-user"></i></a>
            </div>
        </div>
        <?php require_once __DIR__ . '/../views/header_navbar.php'; ?>
        <?php require_once __DIR__ . '/../views/modalCR.php'; ?>
</header>
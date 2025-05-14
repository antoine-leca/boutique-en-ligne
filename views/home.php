<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demetech - Boutique Tech</title>
    <link rel="stylesheet" href="/boutique-en-ligne/public/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="#">
                    <img src="/boutique-en-ligne/public/assets/Logo_long.png" alt="Demetech Logo" class="logo-image">
                </a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Rechercher...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active">Accueil</a></li>
                    <li><a href="#">Acheter</a></li>
                    <li><a href="#">Offres</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="#"><i class="far fa-heart"></i></a>
                <a href="#"><i class="fas fa-shopping-cart"></i></a>
                <a href="#"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <!-- Hero Section 1 - NZXT H6 Flow -->
    <section class="hero nzxt-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h3>NZXT</h3>
                <h1>H6 <span>Flow</span></h1>
                <p>Boîtier compact moyen-tour airflow avec double chambre</p>
                <a href="#" class="btn-primary">Acheter</a>
            </div>
            <div class="hero-image">
                <img src="/boutique-en-ligne/public/assets/tour.png" alt="NZXT H6 Flow">
            </div>
        </div>
    </section>

    <!-- Featured Products Grid -->
    <!-- Featured Products Grid -->
<section class="featured-grid">
    <!-- PlayStation 5 - Haut gauche -->
    <div class="featured-item ps5">
        <div class="featured-text">
            <h2>Playstation 5</h2>
            <p>Des processeurs, des GPU et un SSD incroyablement puissants avec E/S intégrées redéfiniront votre expérience PlayStation.</p>
        </div>
        <div class="featured-image">
            <img src="/boutique-en-ligne/public/assets/PlayStation.png" alt="PlayStation 5">
        </div>
    </div>

    <!-- Macbook Air - Colonne droite -->
    <div class="featured-item macbook">
        <div class="featured-text">
            <h2>Macbook Air</h2>
            <p>Le MacBook Air, l'ordi portable le plus populaire, combine puissance, autonomie (jusqu'à 18 h) et Apple Intelligence pour vous simplifier la vie.</p>
            <button class="btn-secondary">Acheter</button>
        </div>
        <div class="featured-image">
            <img src="/boutique-en-ligne/public/assets/MacBook.png" alt="MacBook Air">
        </div>
    </div>

    <!-- Container pour iPhone et Clavier - Bas gauche -->
    <div class="bottom-left-container">
        <!-- iPhone - Bas gauche (gauche) -->
        <div class="featured-item iphone">
            <div class="featured-text">
                <h2>iPhone 14 Pro</h2>
                <p>Créé pour tout changer pour le mieux. Pour tous.</p>
            </div>
            <div class="featured-image">
                <img src="/boutique-en-ligne/public/assets/Iphone.png" alt="iPhone 14 Pro">
            </div>
        </div>

        <!-- Clavier Corsair - Bas gauche (droite) -->
        <div class="featured-item corsair">
            <div class="featured-text">
                <h2>Clavier Gaming Corsair</h2>
                <p>Switches M2X Hyperdrive réglables, un déclenchement ultra-rapide et un toucher sonore unique.</p>
            </div>
            <div class="featured-image">
                <img src="/boutique-en-ligne/public/assets/clavier.png" alt="Clavier Corsair">
            </div>
        </div>
    </div>
</section>

    <!-- Categories Section -->
    <section class="categories">
        <h2>Parcourir par catégorie</h2>
        <div class="category-grid">
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <p>Téléphone</p>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <p>Ordinateur</p>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <p>Gaming</p>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fas fa-headphones"></i>
                </div>
                <p>Accessoires</p>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon">
                    <i class="fas fa-microchip"></i>
                </div>
                <p>Composants</p>
            </a>
            <a href="#" class="category-item">
                <div class="category-icon d-icon">
                    <img src="/boutique-en-ligne/public/assets/Petit_logo.png" alt="D Icon">
                </div>
                <p>Goodies</p>
            </a>
        </div>
    </section>

    <!-- Product Tabs Section -->
    <section class="product-tabs">
        <div class="tabs">
            <button class="tab-btn active">Nouvelle Arrivée</button>
            <button class="tab-btn">Bestseller</button>
            <button class="tab-btn">Produits en vedette</button>
        </div>

        <div class="product-grid">
            <!-- iPhone 14 Pro Max -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/iphone14promax.png" alt="iPhone 14 Pro Max">
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>Apple iPhone 14 Pro Max 128 Go Violet foncé</h3>
                    <div class="price">900€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>

            <!-- BlackMagic Camera -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/blackmagic.png" alt="Caméra Blackmagic">
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>Caméra Blackmagic Pocket Cinema 6k</h3>
                    <div class="price">2535€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>

            <!-- Apple Watch -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/applewatch.png" alt="Apple Watch">
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>Apple Watch Series 9 GPS 41 mm Aluminium Starlight</h3>
                    <div class="price">399€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>

            <!-- AirPods Max -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/airpodsmax.png" alt="AirPods Max">
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>AirPods Max Argent Aluminium Starlight</h3>
                    <div class="price">549€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>

            <!-- Samsung Galaxy Watch -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/galaxywatch.png" alt="Samsung Galaxy Watch">
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>Samsung Galaxy Watch 6 Classic 47 mm Noir</h3>
                    <div class="price">369€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>

            <!-- Galaxy Z Fold -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/galaxyzfold.png" alt="Galaxy Z Fold">
                    <button class="wishlist-btn active"><i class="fas fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>Galaxy Z Fold5 débloqué | 256 Go | Noir fantôme</h3>
                    <div class="price">1799€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>

            <!-- Galaxy Buds -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/galaxybuds.png" alt="Galaxy Buds">
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>Galaxy Buds FE Graphite</h3>
                    <div class="price">99.99€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>

            <!-- iPad -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/ipad.png" alt="iPad">
                    <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <h3>Apple iPad 9 10.2" 64 Go Wi-Fi Argent (MK2L3) 2021</h3>
                    <div class="price">398€</div>
                    <button class="buy-btn">Acheter</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Shop With Us -->
    <section class="why-shop">
        <div class="why-shop-content">
            <h2>Raison d'acheter sur Demetech</h2>
            <p>Nous voulons rendre votre expérience d'achat facile. Achetez conciemment et profitez d'avantages tels que la livraison gratuite, des retours faciles et l'accès à des offres exclusives disponibles uniquement ici.</p>
            
            <div class="features-grid">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Achetez maintenant, payez plus tard</h3>
                    <p>Payez à votre rythme avec les plans de paiement flexibles. Obtenez ce que vous aimez, choisissez comment vous payez.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Livraison gratuite</h3>
                    <p>Livraison standard gratuite à partir de 35 €.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Garantie</h3>
                    <p>Ayez l'esprit tranquille en sachant que vos produits sont garantis et qu'ils représentent vraiment la qualité attendue du fabricant.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h3>Satisfait ou remboursé</h3>
                    <p>Achetez sans risque avec nos retours faciles et notre garantie de remboursement sous 30 jours.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Service client 24 h/24 et 7 j/7</h3>
                    <p>Nous sommes là pour vous quand vous en avez besoin. Contactez-nous par chat, téléphone ou e-mail pour plus de commodité.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h3>Offres exclusives</h3>
                    <p>Dénichez des cadeaux exclusifs en achetant une sélection de produits. Inscrivez-vous au e-mail pour découvrir les toutes dernières offres.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <!-- Footer content can be added here -->
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
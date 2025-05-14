<?php
    namespace Demetech;
    use Demetech\ConnectionToDB;
    use Demetech\Product;

    require_once __DIR__ . '/../controllers/Autoloader.php';
    \Demetech\Autoloader::register();

    $product = new Product();
    // var_dump($product->read(1))

    $productAssets = $product->read($_GET['p']);
    // $productAssets = $product->read(61);

    // Taille de l'écran
    if (preg_match('/(\d+(?:,\d+)?)\s*pouces/', $productAssets['description'], $matches)) {
        $characteristics['Taille (pouces)'] = $matches[1] . '"';
    }

    // Résolution de l'écran
    if (preg_match('/(\d+K|FHD|QHD\+|QHD|4K|WQXGA)\s*(OLED|touch|IPS|Mini-LED)?/i', $productAssets['description'], $matches)) {
        $characteristics['Résolution'] = $matches[1] . (isset($matches[2]) ? ' ' . $matches[2] : '');
    }

    // Fréquence de l'écran (Hz)
    if (preg_match('/(\d+)\s*Hz/', $productAssets['description'], $matches)) {
        $characteristics['Fréquence'] = $matches[1] . 'Hz';
    }
    
    // Type de dalle
    if (preg_match('/\b(OLED|Super AMOLED|AMOLED|VA|IPS|TN|Mini-LED|Super Retina XDR|LCD|Ultra Retina XDR|Liquid Retina|TFT)\b/i', $productAssets['description'], $matches)) {
        $characteristics['Type de dalle'] = strtoupper($matches[1]);
    }

    // Processeur
    if (preg_match('/(Intel Core \w+\s*\d+|Kirin \d+|Snapdragon \d+|Puce M\d+(?: Max)?|AMD Ryzen \w+\s*\d*|puce A\d+(\s*Pro)?)/i', $productAssets['description'], $matches)) {
        $characteristics['CPU'] = $matches[1];
    }

    // RAM
    if (preg_match('/(\d+)\s*Go\s*(RAM|LPDDR\d*|DDR\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['RAM'] = $matches[1] . ' Go ' . strtoupper($matches[2]);
    }

    // Stockage
    if (preg_match('/SSD\s*(\d+)\s*(Go|To)(?:\s*\+\s*HDD\s*(\d+)\s*(Go|To))?(?:\s*NVMe)?/i', $productAssets['description'], $matches)) {
        $ssdStorage = $matches[1] . $matches[2];
        $nvme = preg_match('/NVMe/i', $productAssets['description']) ? ' NVMe' : '';
        $characteristics['Stockage SSD'] = $ssdStorage . $nvme;
    }

    if (preg_match('/HDD\s*(\d+)\s*(Go|To)/i', $productAssets['description'], $matches)) {
        $characteristics['Stockage HDD'] = $matches[1] . $matches[2];
    }

    // Carte graphique modèle
    if (preg_match('/NVIDIA\s*(GeForce)?\s*RTX\s*(\d+)(\s*Ti)?/i', $productAssets['description'], $matches)) {
        $tiSuffix = !empty($matches[3]) ? ' Ti' : '';
        $characteristics['GPU'] = 'NVIDIA RTX ' . $matches[2] . $tiSuffix;
    } elseif (preg_match('/AMD\s*Radeon\s*RX\s*(\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['GPU'] = 'AMD Radeon RX ' . $matches[1];
    }

    // Autonomie (si mentionnée)
    if (preg_match('/(?:autonomie\s*:\s*|autonomie\s*de\s*|autonomie\s*)\s*(\d+(?:,\d+)?)\s*(h|heures?)/i', $productAssets['description'], $matches)) {
        $characteristics['Autonomie'] = $matches[1] . ' ' . $matches[2];
    }

    // Appareil photo (mégapixels)
    if (preg_match('/(\d+)\s*MP/i', $productAssets['description'], $matches)) {
        $characteristics['Photo'] = $matches[1] . 'Mp';
    }

    // Connectivité mobile (4G/5G)
    if (preg_match('/\b(5G|4G)\b/i', $productAssets['description'], $matches)) {
        $characteristics['Connectivité'] = strtoupper($matches[1]);
    }

    // Stockage téléphone/tablette
    // Vérification de la catégorie
    if ((strtolower($productAssets['category_name']) == 'téléphones' || 
        strtolower($productAssets['category_name']) == 'tablettes' ||
        strtolower($productAssets['category_name']) == 'telephones') && 
        preg_match('/(\d+)\s*To|Go\s*stockage/i', $productAssets['description'], $matches)) {
        $characteristics['Stockage'] = $matches[1] . ' ' . (strpos($matches[0], 'To') !== false ? 'To' : 'Go');
    }

    // Mémoire vidéo
    if (preg_match('/(\d+)\s*Go\s*(GDDR\d+X?)/i', $productAssets['description'], $matches)) {
        $characteristics['Mémoire vidéo'] = $matches[1] . ' Go ' . strtoupper($matches[2]);
    }

    // Upscaling
    if (preg_match('/(DLSS|FSR)\s*(\d+(?:\.\d+)?)/i', $productAssets['description'], $matches)) {
        $characteristics['Upscaling'] = strtoupper($matches[1]) . ' ' . $matches[2];
    }

    // PCIe
    if (preg_match('/Gen(\d+)\s*PCIe|PCIe\s*(\d+\.\d+|\d+)/i', $productAssets['description'], $matches)) {
        $pcieVersion = !empty($matches[1]) ? $matches[1] : $matches[2];
        $characteristics['Interface'] = 'PCIe ' . $pcieVersion;
    }

    // DisplayPort
    if (preg_match('/(\d+)x?\s*DisplayPort\s*(\d+\.\d+[a-z]?)/i', $productAssets['description'], $matches)) {
        $characteristics['DisplayPort'] = $matches[1] . 'x DP ' . $matches[2];
    }

    if (preg_match('/(\d+)x?\s*HDMI\s*(\d+\.\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['HDMI'] = $matches[1] . 'x HDMI ' . $matches[2];
    }

    // var_dump($characteristics)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="\Demetech\public\css\root.css">
    <link rel="stylesheet" href="\Demetech\public\css\productPage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo:ital,wght@0,100..900;1,100..900&family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div id="arborescence" class="flex my-4 ml-4">
        <a class="text-gray-500" href="home.php">Accueil</a>
        <span class="material-symbols-outlined text-gray-500">chevron_right</span>
        <!-- href vers page liste de produits avec filtre actif selon la catégorie" -->
        <a class="capitalize text-gray-500" href="#"><?php echo htmlspecialchars($productAssets['category_name']); ?></a>
        <span class="material-symbols-outlined text-gray-500">chevron_right</span>
        <span><?php echo htmlspecialchars($productAssets['name']); ?></span>
    </div>
    <section id="productSection" class="flex">
        <div class="w-1/2 flex justify-center items-center">
            <img class="w-[50%]" src="<?php echo htmlspecialchars($productAssets['img']); ?>" alt="<?php echo htmlspecialchars($productAssets['name']); ?>" class="w-full h-auto">
        </div>
        <div class="w-1/2 flex flex-col justify-center items-start p-4">
            <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($productAssets['name']); ?></h1>
            <p class="text-xl font-bold"><?php echo htmlspecialchars($productAssets['price']); ?> €</p>
            <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($productAssets['description']); ?></p>
            <h2 class="my-2">Caractéristiques du produit</h2>
            <ul class="flex flex-wrap gap-4">
                <?php if (!empty($characteristics)): ?>
                <?php foreach ($characteristics as $key => $value): ?>
                    <li class="flex bg-gray-100 p-2 rounded mb-2">
                        <span class="material-symbols-outlined text-4xl flex items-center justify-center mr-2">
                            <?php
                            // Associer des icônes aux caractéristiques
                            switch ($key) {
                                case 'Taille (pouces)':
                                    echo 'aspect_ratio'; // Icône pour l'écran
                                    break;
                                case 'CPU':
                                    echo 'memory'; // Icône pour le processeur
                                    break;
                                case 'RAM':
                                    echo 'storage'; // Icône pour la RAM
                                    break;
                                case 'Stockage HDD':
                                    echo 'hard_disk'; // Icône pour le stockage
                                    break;
                                case 'Stockage SSD':
                                    echo 'hard_drive'; // Icône pour le stockage
                                    break;
                                case 'GPU':
                                    echo 'hangout_video'; // Icône pour la carte graphique
                                    break;
                                case 'Résolution':
                                    echo 'image_aspect_ratio'; // Icône pour la résolution
                                    break;
                                case 'Autonomie':
                                    echo 'battery_4_bar'; // Icône pour l'autonomie
                                    break;
                                case 'Type de dalle':
                                    echo 'desktop_windows'; // Icône pour l'autonomie
                                    break;
                                case 'Fréquence':
                                    echo 'bolt'; // Icône pour l'autonomie
                                    break;
                                case 'Photo':
                                    echo 'camera'; // Icône pour l'autonomie
                                    break;
                                case 'Connectivité':
                                    echo 'signal_cellular_alt'; // Icône pour la connectivité
                                    break;
                                case 'Stockage':
                                    echo 'hard_drive'; // Icône pour le stockage
                                    break;
                                default:
                                    echo 'info'; // Icône par défaut
                                    break;
                            }
                            ?>
                        </span>
                        <div class="flex flex-col">
                            <span class="text-gray-500"><?php echo htmlspecialchars($key); ?></span>
                            <span class="capitalize"><?php echo htmlspecialchars($value); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <div class="flex gap-4 mt-4">
                <button class="hover:bg-gray-200 border border-black px-4 py-2 rounded">Ajouter aux favoris</button>
                <button class="bg-blue-custom bg-grey-custom text-white px-4 py-2 rounded">Ajouter au panier</button>
            </div>
        </div>
    </section>
</body>
</html>
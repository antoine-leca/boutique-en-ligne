<?php
    namespace Demetech;
    use Demetech\ConnectionToDB;
    use Demetech\Product;

    require_once __DIR__ . '/../controllers/Autoloader.php';
    \Demetech\Autoloader::register();


    $product = new Product();
    // var_dump($product->read(1))
    // $productAssets = $product->read(61);

    $productAssets = $product->readAll($_GET['p']);

    // Récupérer les recommandations de produits de la même catégorie
    $recommendedProducts = $product->getRecommendations($productAssets['category_fk'], $_GET['p'], 4);

    // Taille de l'écran
    if (preg_match('/(\d+(?:,\d+)?)\s*pouces/', $productAssets['description'], $matches)) {
        $characteristics['Taille (pouces)'] = $matches[1] . '"';
    }

    // Résolution de l'écran
    if (preg_match('/(\d+K|FHD|double QHD|QHD\+|QHD|4K-UHD|4K|WQXGA)\s*(OLED|touch|IPS|Mini-LED)?/i', $productAssets['description'], $matches)) {
        $characteristics['Résolution'] = $matches[1] . (isset($matches[2]) ? ' ' . $matches[2] : '');
    }

    // Fréquence de l'écran (Hz)
    if (preg_match('/(\d+)\s*Hz/', $productAssets['description'], $matches)) {
        $characteristics['Fréquence'] = $matches[1] . 'Hz';
    }
    
    // Type de dalle
    if (preg_match('/\b(QD-OLED|OLED|Super AMOLED|AMOLED|VA|IPS|TN|Mini-LED|Super Retina XDR|LCD|Ultra Retina XDR|Liquid Retina|TFT)\b/i', $productAssets['description'], $matches)) {
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
        preg_match('/(\d+)\s*Go\s*stockage/i', $productAssets['description'], $matches)) {
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

    // Nombre de cœurs
    if (preg_match('/(\d+)\s*cœurs?(?:\s*\([^)]+\))?/i', $productAssets['description'], $matches)) {
        $characteristics['Cœurs'] = $matches[1];
    }

    // Threads
    if (preg_match('/(\d+)\s*threads?/i', $productAssets['description'], $matches)) {
        $characteristics['Threads'] = $matches[1];
    }

    // Fréquence boost (GHz)
    if (preg_match('/fréquence\s*(?:boost|turbo)?\s*jusqu\'à\s*(\d+(?:\.\d+)?)\s*GHz/i', $productAssets['description'], $matches)) {
        $characteristics['Fréquence Boost'] = $matches[1] . 'GHz';
    }

    // Cache
    if (preg_match('/(\d+)\s*Mo\s*cache/i', $productAssets['description'], $matches)) {
        $characteristics['Cache'] = $matches[1] . 'Mo';
    }

    // Socket
    if (preg_match('/socket\s*(LGA\s*\d+|AM\d+|TR\d+|FM\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['Socket'] = strtoupper($matches[1]);
    }

    // Type de RAM supportée
    if (preg_match('/DDR(\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['RAM supportée'] = 'DDR' . $matches[1];
    }

    // TDP
    if (preg_match('/(\d+)\s*W\s*TDP/i', $productAssets['description'], $matches)) {
        $characteristics['TDP'] = $matches[1] . 'W';
    }

    // Capacité mémoire kit (total)
    if (preg_match('/Kit mémoire\s*(\d+)\s*Go/i', $productAssets['description'], $matches)) {
        $characteristics['Kit Mémoire'] = $matches[1] . ' Go';
    }

    // Configuration du kit (nombre de barrettes x taille)
    if (preg_match('/\((\d+)x(\d+)Go\)/i', $productAssets['description'], $matches)) {
        $characteristics['Configuration'] = $matches[1] . ' x ' . $matches[2] . ' Go';
    }

    // Fréquence mémoire (MHz)
    if (preg_match('/DDR\d+-(\d+)MHz/i', $productAssets['description'], $matches)) {
        $characteristics['Fréquence'] = $matches[1] . ' MHz';
    }

    // Latence CL
    if (preg_match('/CL(\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['Latence'] = 'CL' . $matches[1];
    }

    // RGB (présence)
    if (preg_match('/RGB/i', $productAssets['description'])) {
        $characteristics['RGB'] = 'Oui';
    }

    // Compatibilité plateforme
    if (preg_match('/compatible\s*(Intel|AMD)(?:\s*et\s*(Intel|AMD))?/i', $productAssets['description'], $matches)) {
        $platforms = strtoupper($matches[1]);
        if (isset($matches[2])) {
            $platforms .= ' & ' . strtoupper($matches[2]);
        }
        $characteristics['Compatible'] = $platforms;
    }

    // Stockage pour composants (SSD/HDD)
    if (strtolower($productAssets['category_name']) == 'composants' && 
        preg_match('/(\d+)\s*(To|Go)/i', $productAssets['description'], $matches)) {
        $characteristics['Capacité'] = $matches[1] . ' ' . $matches[2];
    }

    // Type de disque - Détecte d'abord SSD ou HDD puis le format
    $diskType = null;
    
    // Détection SSD ou HDD
    if (preg_match('/\b(SSD|HDD)\b/i', $productAssets['description'], $typeMatches)) {
        $diskType = strtoupper($typeMatches[1]);
        
        // Détection du format pour SSD
        if ($diskType === 'SSD') {
            if (preg_match('/\b(NVMe|M\.2|2\.5"|SATA)\b/i', $productAssets['description'], $formatMatches)) {
                $diskType .= ' ' . strtoupper($formatMatches[1]);
            }
        } 
        // Détection du format pour HDD
        else if ($diskType === 'HDD') {
            if (preg_match('/\b(3\.5"|2\.5")\b/i', $productAssets['description'], $formatMatches)) {
                $diskType .= ' ' . $formatMatches[1];
            }
        }
        
        $characteristics['Type de disque'] = $diskType;
    }

    // Vitesse de lecture - pattern amélioré pour capturer différentes formulations
    if (preg_match('/(?:vitesse\s*de\s*lecture|lecture\s*jusqu\'à|lecture\s*:)\s*(?:jusqu\'à\s*)?(\d+(?:\.\d+)?)\s*(?:Go|Mo|GB|MB)\/s/i', $productAssets['description'], $matches)) {
        $characteristics['Lecture'] = $matches[1] . ' Mo/s';
    }

    // Vitesse d'écriture - pattern amélioré pour capturer différentes formulations
    if (preg_match('/(?:vitesse\s*d\'écriture|d\'écriture\s*jusqu\'à|écriture\s*:)\s*(?:jusqu\'à\s*)?(\d+(?:\.\d+)?)\s*(?:Go|Mo|GB|MB)\/s/i', $productAssets['description'], $matches)) {
        $characteristics['Écriture'] = $matches[1] . ' Mo/s';
    }

    // Vitesse de rotation du disque (RPM)
    if (preg_match('/(\d+)\s*RPM/i', $productAssets['description'], $matches)) {
        $characteristics['Vitesse de rotation'] = $matches[1] . ' RPM';
    }

    // Socket carte mère (détection précise)
    if (preg_match('/socket\s*(Intel\s*LGA\s*\d+|AMD\s*AM\d+|AMD\s*TR\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['Socket'] = strtoupper($matches[1]);
    }
    
    // Chipset
    if (preg_match('/chipset\s*([A-Z]\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['Chipset'] = strtoupper($matches[1]);
    }
    
    // Slots mémoire (nombre et type)
    if (preg_match('/(\d+)\s*slots?\s*(DDR\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['Slots mémoire'] = $matches[1] . ' × ' . strtoupper($matches[2]);
    }
    
    // Fréquence mémoire supportée
    if (preg_match('/DDR\d+\s*jusqu\'à\s*(\d+)(?:MHz|\+)/i', $productAssets['description'], $matches)) {
        $characteristics['Fréquence RAM'] = "max " . $matches[1] . ' MHz';
    }
    
    // Slots PCIe
    if (preg_match('/(\d+)\s*slots?\s*PCIe/i', $productAssets['description'], $matches)) {
        $characteristics['Slots PCIe'] = $matches[1];
    }
    
    // Configuration PCIe (optionnel)
    if (preg_match('/PCIe\s*\(([^\)]+)\)/i', $productAssets['description'], $matches)) {
        $characteristics['Config PCIe'] = $matches[1];
    }
    
    // Ports M.2
    if (preg_match('/(\d+)\s*(?:ports?|slots?)\s*M\.2/i', $productAssets['description'], $matches)) {
        $characteristics['Ports M.2'] = $matches[1];
    }
    
    // PCIe version pour M.2
    if (preg_match('/M\.2\s*PCIe\s*(\d+\.\d+\/\d+\.\d+|\d+\.\d+)/i', $productAssets['description'], $matches)) {
        $characteristics['PCIe M.2'] = 'PCIe ' . $matches[1];
    }
    
    // Wi-Fi version
    if (preg_match('/Wi-Fi\s*(\d+(?:\.\d+)?)/i', $productAssets['description'], $matches)) {
        $characteristics['Norme Wi-Fi'] = 'Wi-Fi ' . $matches[1];
    }
    
    // RGB (avec nom de technologie)
    if (preg_match('/RGB\s*(Aura|Mystic Light|Fusion)/i', $productAssets['description'], $matches)) {
        $characteristics['RGB'] = 'RGB ' . $matches[1];
    } elseif (preg_match('/RGB/i', $productAssets['description'])) {
        $characteristics['RGB'] = 'Oui';
    }

    // HDR (détection avec valeur ou juste présence)
    if (preg_match('/HDR(\d+)/i', $productAssets['description'], $matches)) {
        if (isset($matches[1])) {
            $characteristics['HDR'] = 'oui';
        } else {
            $characteristics['HDR'] = 'Non';
        }
    }
    
    // Temps de réponse
    if (preg_match('/(\d+(?:\.\d+)?)ms/i', $productAssets['description'], $matches)) {
        $characteristics['Temps de réponse'] = $matches[1] . ' ms';
    }
    
    // FreeSync ou G-Sync
    if (preg_match('/(FreeSync\s*(?:Premium\s*Pro|Premium|Ultimate)?|G-Sync\s*(?:Compatible|Ultimate)?)/i', $productAssets['description'], $matches)) {
        $characteristics['Adaptive Sync'] = $matches[1];
    }

    // Type de switches (pour claviers)
    if (preg_match('/switches?\s*(tactiles?|clicky|linéaires?|mécaniques?|optiques?|silencieux|brown|red|blue)\b/i', $productAssets['description'], $matches)) {
        $characteristics['Switches'] = ucfirst($matches[1]);
    }

    // Connectivité (sans-fil, bluetooth, etc.)
    if (preg_match('/\b(sans[-\s]fil|bluetooth|wireless|2\.4[Gg]hz|dongle)\b/i', $productAssets['description'])) {
        $characteristics['Sans fil'] = 'Oui';
    }

    // Type de connectivité spécifique
    if (preg_match('/(Bluetooth|USB|USB-C|2\.4GHz)(?:\s*\+\s*(Bluetooth|USB|USB-C|2\.4GHz))?/i', $productAssets['description'], $matches)) {
        $connectivity = $matches[1];
        if (isset($matches[2])) {
            $connectivity .= ' + ' . $matches[2];
        }
        $characteristics['Connectivité clavier'] = $connectivity;
    }

    // Autonomie (pour périphériques)
    if (preg_match('/autonomie(?:\s*de|\s*jusqu\'à)?\s*(\d+)\s*(jours?|heures?|semaines?)/i', $productAssets['description'], $matches)) {
        $characteristics['Autonomie'] = $matches[1] . ' ' . $matches[2];
    }

    // Layout clavier
    if (preg_match('/\b(AZERTY|QWERTY|QWERTZ)\b/i', $productAssets['description'], $matches)) {
        $characteristics['Layout'] = strtoupper($matches[1]);
    }

    // Rétroéclairage
    if (preg_match('/\b(rétro[-\s]éclairage|RGB|backlight)\b/i', $productAssets['description'])) {
        $characteristics['Rétroéclairage'] = 'Oui';
    }

    // var_dump($characteristics)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demetech - <?php echo htmlspecialchars($productAssets['name']); ?></title>
    <link rel="stylesheet" href="\Demetech\public\css\root.css">
    <link rel="stylesheet" href="\Demetech\public\css\productPage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo:ital,wght@0,100..900;1,100..900&family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php require_once __DIR__ . '/../views/header.php'; ?>

    <div id="arborescence" class="flex my-4 ml-4">
        <a class="text-gray-500 sm:text-sm" href="/Demetech/index.php">Accueil</a>
        <span class="material-symbols-outlined text-gray-500 ">chevron_right</span>
        <!-- href vers page liste de produits avec filtre actif selon la catégorie" -->
        <a class="capitalize text-gray-500 sm:text-sm" href="#"><?php echo htmlspecialchars($productAssets['category_name']); ?></a>
        <span class="material-symbols-outlined text-gray-500">chevron_right</span>
        <span class="sm:text-sm"><?php echo htmlspecialchars($productAssets['name']); ?></span>
    </div>
    <section id="productSection" class="md:flex">
        <div class="md:w-1/2 flex justify-center items-center">
            <img class="w-[50%]" src="<?php echo htmlspecialchars($productAssets['img']); ?>" alt="<?php echo htmlspecialchars($productAssets['name']); ?>" class="w-full h-auto">
        </div>
        <div class="md:w-1/2 flex flex-col justify-center items-start p-4">
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
                                    echo 'desktop_windows'; // Icône pour le type de dalle
                                    break;
                                case 'Fréquence':
                                    echo 'bolt'; // Icône pour la fréquence
                                    break;
                                case 'Photo':
                                    echo 'camera'; // Icône pour la qualité photo
                                    break;
                                case 'Connectivité':
                                    echo 'signal_cellular_alt'; // Icône pour la connectivité 4G/5G
                                    break;
                                case 'Stockage':
                                    echo 'hard_drive'; // Icône pour le stockage
                                    break;
                                case 'Mémoire vidéo':
                                    echo 'video_settings'; // Icône pour la mémoire vidéo
                                    break;
                                case 'Upscaling':
                                    echo 'resize'; // Icône pour l'upscaling
                                    break;
                                case 'Interface':
                                    echo 'input'; // Icône pour l'interface
                                    break;
                                case 'DisplayPort':
                                    echo 'settings_input_hdmi'; // Icône pour le DisplayPort
                                    break;
                                case 'HDMI':
                                    echo 'settings_input_hdmi'; // Icône pour le DisplayPort
                                    break;
                                case 'Cœurs':
                                    echo 'grid_view'; // Icône pour le nombre de cœurs
                                    break;
                                case 'Threads':
                                    echo 'developer_board'; // Icône pour les threads
                                    break;
                                case 'Fréquence Boost':
                                    echo 'speed'; // Icône pour la fréquence boost
                                    break;
                                case 'Cache':
                                    echo 'memory'; // Icône pour le cache
                                    break;
                                case 'Socket':
                                    echo 'settings_input_component'; // Icône pour le socket
                                    break;
                                case 'RAM supportée':
                                    echo 'memory_alt'; // Icône pour le type de RAM supportée
                                    break;
                                case 'TDP':
                                    echo 'bolt'; // Icône pour le TDP
                                    break;
                                case 'Kit Mémoire':
                                    echo 'memory'; // Icône pour la capacité totale du kit mémoire
                                    break;
                                case 'Configuration':
                                    echo 'dashboard_customize'; // Icône pour la configuration des barrettes
                                    break;
                                case 'Latence':
                                    echo 'timer'; // Icône pour la latence CL
                                    break;
                                case 'RGB':
                                    echo 'palette'; // Icône pour RGB
                                    break;
                                case 'Compatible':
                                    echo 'devices'; // Icône pour compatibilité plateforme
                                    break;
                                case 'Type de disque':
                                    echo 'storage'; // Icône pour le type de disque
                                    break;
                                case 'Capacité':
                                    echo 'sd_storage'; // Icône pour la capacité de stockage
                                    break;
                                case 'Lecture':
                                    echo 'query_stats'; // Icône pour vitesse de lecture
                                    break;
                                case 'Écriture':
                                    echo 'edit'; // Icône pour vitesse d'écriture
                                    break;
                                case 'Vitesse de rotation':
                                    echo 'speed'; // Icône pour la vitesse de rotation
                                    break;
                                case 'Socket':
                                    echo 'settings_input_component'; // Icône pour le socket
                                    break;
                                case 'Chipset':
                                    echo 'memory_alt'; // Icône pour le chipset
                                    break;
                                case 'Slots mémoire':
                                    echo 'view_module'; // Icône pour les slots mémoire
                                    break;
                                case 'Fréquence RAM':
                                    echo 'speed'; // Icône pour la fréquence max
                                    break;
                                case 'Slots PCIe':
                                    echo 'developer_board'; // Icône pour les slots PCIe
                                    break;
                                case 'Config PCIe':
                                    echo 'settings_ethernet'; // Icône pour la config PCIe
                                    break;
                                case 'Ports M.2':
                                    echo 'sd_card'; // Icône pour les ports M.2
                                    break;
                                case 'PCIe M.2':
                                    echo 'settings_input_hdmi'; // Icône pour PCIe version
                                    break;
                                case 'Norme Wi-Fi':
                                    echo 'wifi'; // Icône pour Wi-Fi
                                    break;
                                case 'HDR':
                                    echo 'brightness_high'; // Icône pour HDR
                                    break;
                                case 'Temps de réponse':
                                    echo 'timer'; // Icône pour temps de réponse
                                    break;
                                case 'Sync adaptative':
                                    echo 'sync'; // Icône pour FreeSync/G-Sync
                                    break;
                                case 'Switches':
                                    echo 'keyboard_alt'; // Icône pour les switches
                                    break;
                                case 'Sans fil':
                                    echo 'wifi'; // Icône pour sans fil
                                    break;
                                case 'Connectivité clavier':
                                    echo 'input'; // Icône pour type de connectivité
                                    break;
                                case 'Layout':
                                    echo 'keyboard'; // Icône pour layout clavier
                                    break;
                                case 'Rétroéclairage':
                                    echo 'light_mode'; // Icône pour rétroéclairage
                                    break;
                                case 'Adaptive Sync':
                                    echo 'sync'; // Icône pour FreeSync/G-Sync
                                    break;
                                case 'HDR':
                                    echo 'brightness_high'; // Icône pour HDR
                                    break;
                                case 'Temps de réponse':
                                    echo 'timer'; // Icône pour temps de réponse
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
    <!-- Section de recommandations -->
    <section id="recommendationsSection" class="mt-12 px-8 pb-8">
        <h2 class="text-2xl font-bold mb-6">Produits similaires dans la catégorie "<?php echo htmlspecialchars($productAssets['category_name']); ?>"</h2>
        
        <?php if (!empty($recommendedProducts)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($recommendedProducts as $product): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <a href="productPage.php?p=<?php echo $product['id']; ?>">
                            <div class="h-48 flex items-center justify-center">
                                <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="max-h-full max-w-full object-contain">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold line-clamp-2 h-14"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="text-blue-custom font-bold mt-2"><?php echo htmlspecialchars($product['price']); ?> €</p>
                                <button class="mt-3 w-full bg-blue-custom text-white py-2 rounded hover:bg-blue-700 transition-colors">
                                    Voir le produit
                                </button>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500">Aucun produit similaire disponible pour le moment.</p>
        <?php endif; ?>
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
</body>
</html>
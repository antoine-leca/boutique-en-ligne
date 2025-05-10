<?php
    namespace Demetech;

    require_once __DIR__ . '/../controllers/Autoloader.php';
    \Demetech\Autoloader::register();
    use Demetech\ConnectionToDB;

    $db = new ConnectionToDB();
    $conn = $db->connectDB();
    $categories = readCat($conn);

    function readCat($conn) {
        $query = "SELECT * FROM categories";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Utilisation explicite de \PDO
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <header class="h-32">
        <!-- partie haute du header -->

        <!-- partie basse du header avec la navbar -->
         <nav class="h-1/2 mx-40">
            <ul class="h-full flex justify-between">
                <?php foreach ($categories as $category): ?>
                    <li class="h-full w-1/7"><a class="w-full h-full flex items-center justify-center uppercase hover:bg-[#F5F5F5]" href="list.php?t=<?=$category['id']?>"><?= htmlspecialchars($category['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
         </nav>
    </header>
</body>
</html>
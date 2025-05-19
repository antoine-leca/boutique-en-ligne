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

<nav class="h-1/2 mx-40">
    <ul class="h-full flex justify-between">
        <?php foreach ($categories as $category): ?>
            <li class="h-full w-1/7"><a class="w-full h-full flex items-center justify-center uppercase hover:bg-[#F5F5F5]" href="list.php?t=<?=htmlspecialchars($category['id'])?>"><?= htmlspecialchars($category['name']) ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>
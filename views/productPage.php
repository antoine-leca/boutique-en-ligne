<?php
    namespace Demetech;
    use Demetech\ConnectionToDB;
    use Demetech\Product;

    require_once __DIR__ . '/../controllers/Autoloader.php';
    \Demetech\Autoloader::register();

    $product = new Product();
    var_dump($product->read(1))
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
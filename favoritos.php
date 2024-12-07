<?php
session_start();

// Inicializa a sessão de favoritos
if (!isset($_SESSION['favorites'])) {
    $_SESSION['favorites'] = [];
}

// Nome do site e slogan
$siteName = "TechSpecs";
$slogan = "Tudo para o seu computador, ao seu alcance!";

// Produtos (você pode importar os produtos de um arquivo ou banco de dados)
$products = [
    // (Mesmos produtos que você já definiu anteriormente)
];

// Adicionar um produto aos favoritos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produto'])) {
    $produto = $_POST['produto'];
    if (!in_array($produto, $_SESSION['favorites'])) {
        $_SESSION['favorites'][] = $produto;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteName; ?> - Favoritos</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
}

header {
    background-color: #0073e6;
    color: white;
    padding: 20px;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2em;
}

header p {
    font-size: 1.2em;
}

header a {
    color: white;
    text-decoration: none;
    background-color: #005bb5;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

header a:hover {
    background-color: #004a90;
}

.container {
    padding: 20px;
    max-width: 1200px;
    margin: auto;
}

h2 {
    text-align: center;
    color: #333;
}

.product-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.product {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.product:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.product img {
    max-width: 100%;
    border-radius: 4px;
    height: auto;
}

.product h3 {
    margin: 10px 0;
    color: #0073e6;
}

.product p {
    color: #555;
    margin: 10px 0;
}

.product span {
    font-weight: bold;
    color: #0073e6;
}

.product button {
    padding: 10px;
    border: none;
    background-color: #0073e6;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.product button:hover {
    background-color: #005bb5;
}

    </style>
</head>
<body>

<header>
    <h1><?php echo $siteName; ?></h1>
    <p><?php echo $slogan; ?></p>
    <a href="index .php">Voltar para a loja</a>
</header>

<div class="container">
    <h2>Produtos Favoritos</h2>
    <div class="product-container">
        <?php if (count($_SESSION['favorites']) > 0): ?>
            <?php foreach ($products as $product): ?>
                <?php if (in_array($product['name'], $_SESSION['favorites'])): ?>
                    <div class="product">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo $product['description']; ?></p>
                        <span><?php echo $product['price']; ?></span>
                        <form action="adicionar.php" method="post">
                            <input type="hidden" name="produto" value="<?php echo $product['name']; ?>">
                            <input type="hidden" name="preco" value="<?php echo $product['price']; ?>">
                            <button type="submit">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum produto favorito adicionado ainda.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

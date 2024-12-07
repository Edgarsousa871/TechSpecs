<?php
session_start();

// Nome do site e slogan
$siteName = "TechSpecs";
$slogan = "Tudo para o seu computador, ao seu alcance!";

// Produtos de Memórias RAM
$products = [
    [
        "name" => "Corsair Vengeance LPX 16GB (2x8GB) DDR4",
        "category" => "Memórias RAM",
        "price" => "47.76€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/10/100309/corsair-vengeance-lpx-ddr4-3000mhz-pc-24000-8gb-2x4-black.jpg",
        "description" => "Memória RAM DDR4 16GB (2x8GB), ideal para alta performance e overclock."
    ],
    [
        "name" => "G.SKILL Ripjaws V 16GB (2x8GB) DDR4",
        "category" => "Memórias RAM",
        "price" => "35.90€",
        "image" => "https://pcdiga-prod.eu.saleor.cloud/media/thumbnails/products/product-p001988-25864_3_eedd5cff_thumbnail_4096.png",
        "description" => "Memória RAM DDR4 16GB (2x8GB), performance superior para gamers."
    ],
    [
        "name" => "Kingston HyperX Fury 16GB (2x8GB) DDR4",
        "category" => "Memórias RAM",
        "price" => "46.90€",
        "image" => "https://pcdiga-prod.eu.saleor.cloud/media/thumbnails/products/kingston_fury_beast_ddr4_memory_dual_1__1_404b221e_thumbnail_4096.jpg",
        "description" => "Memória RAM DDR4 16GB (2x8GB) com excelente custo-benefício."
    ],
    [
        "name" => "Kingston FURY Beast DDR4",
        "category" => "Memórias RAM",
        "price" => "36.58€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/43/432664/1392-kingston-fury-beast-ddr4-3200-mhz-16gb-2x8gb-cl16.jpg",
        "description" => "Memória RAM de alto desempenho projetada para atender as necessidades de gamers."
    ],
    [
        "name" => "Team T-Force Delta RGB 16GB (2x8GB) DDR4",
        "category" => "Memórias RAM",
        "price" => "54.90€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/21/217577/1-1.jpg",
        "description" => "Memória RAM DDR4 16GB (2x8GB) com RGB e alta performance."
    ],
    [
        "name" => "Adata XPG Spectrix D60G 16GB (2x8GB) DDR4",
        "category" => "Memórias RAM",
        "price" => "65.90€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/1080/10805478/1980-adata-xpg-d35g-spectrix-rgb-ddr4-3600mhz-16gb-2x8gb-cl18.jpg",
        "description" => "Memória RAM DDR4 16GB (2x8GB) com design futurista e excelente desempenho."
    ],
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteName; ?> - Memórias RAM</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }
        .product img {
            max-width: 100%;
            height: 200px; /* Define uma altura fixa */
            object-fit: cover; /* Mantém a proporção sem distorção */
            border-radius: 4px;
        }
        .product h3 {
            margin: 10px 0;
        }
        .product p {
            color: #555;
        }
        .product span {
            font-weight: bold;
            color: #0073e6;
        }
        .product form {
            margin-top: 10px;
            display: flex; 
            justify-content: center; 
            gap: 10px; 
        }
        .product button {
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .product button:hover {
            background-color: #005bb5;
        }
        .header-actions a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }
    </style>
</head>
<body>
<header>
    <div>
        <h1><?php echo $siteName; ?></h1>
        <p><?php echo $slogan; ?></p>
    </div>
    <div class="header-actions">
        <a href="index .php">Voltar à loja</a>
        <a href="carrinho.php">🛒 Carrinho</a>
        <a href="favoritos.php">❤️ Favoritos</a>
    </div>
</header>
<!-- Seção de Produtos em Destaque -->
<div class="container">
    <h2>Memórias RAM</h2>
    <div class="product-container">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <span><?php echo $product['price']; ?></span>
                <div>
                    <form action="adicionar.php" method="post">
                        <input type="hidden" name="produto" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="preco" value="<?php echo $product['price']; ?>">
                        <button type="submit">Adicionar ao Carrinho</button>
                    </form>
                    <form action="favorites.php" method="post">
                        <input type="hidden" name="produto" value="<?php echo $product['name']; ?>">
                        <button type="submit">❤️ Favorito</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>

<?php
session_start();

// Nome do site e slogan
$siteName = "TechSpecs";
$slogan = "Tudo para o seu computador, ao seu alcance!";

// Produtos de Discos SSD
$productsSSD = [
    [
        "name" => "Samsung 970 EVO Plus 500GB",
        "category" => "Discos SSD",
        "price" => "80.06€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/18/185881/au-970-evoplus-nvme-m2-ssd-mz-v7s500bw-black-140337449.jpg",
        "description" => "SSD NVMe rápido com 500GB de capacidade, ideal para alta performance e jogos."
    ],
    [
        "name" => "Crucial P5 Plus 1TB",
        "category" => "Discos SSD",
        "price" => "119.99€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/57/579705/1117-crucial-p5-plus-1tb-ssd-m2-2280-pcie-40.jpg",
        "description" => "SSD NVMe Gen 4 com 1TB de capacidade e desempenho excelente."
    ],
    [
        "name" => "Western Digital WD_BLACK SN850 500GB",
        "category" => "Discos SSD",
        "price" => "132.50€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/32/328716/1868-wd-black-sn850-500gb-ssd-m2-2280-3d-nand-con-disipador-termico.jpg",
        "description" => "SSD NVMe de alta performance, ideal para gamers e criadores de conteúdo."
    ],
    [
        "name" => "Kingston A2000 250GB",
        "category" => "Discos SSD",
        "price" => "61.99€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/1057/10578300/1498-kingston-nv2-1tb-ssd-pcie-40-nvme-gen-4x4.jpg",
        "description" => "SSD NVMe de 250GB com ótimo custo-benefício para quem busca velocidade."
    ],
    [
        "name" => "ADATA XPG GAMMIX S50 1TB",
        "category" => "Discos SSD",
        "price" => "88.99€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/1065/10657135/1668-xpg-gammix-s70-blade-ssd-1tb-m2-2280-pcie-gen4x4-nvme-4f61d771-c871-4505-bc73-55ea95f6beab.jpg",
        "description" => "SSD NVMe com 1TB de capacidade, velocidade incrível e excelente desempenho."
    ],
    [
        "name" => "Seagate FireCuda 530 500GB",
        "category" => "Discos SSD",
        "price" => "84.99€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/57/574010/1164-seagate-firecuda-530-m2-500-gb-pci-express-40-3d-tlc-nvme.jpg",
        "description" => "SSD NVMe Gen 4 de alta performance com 500GB, ideal para jogos e vídeos em 4K."
    ],
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteName; ?> - Discos SSD</title>
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
    <h2>Discos SSD</h2>
    <div class="product-container">
        <?php foreach ($productsSSD as $product): ?>
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

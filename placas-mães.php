<?php
session_start();

// Nome do site e slogan
$siteName = "TechSpecs";
$slogan = "Tudo para o seu computador, ao seu alcance!";

// Produtos de Placas Mães
$products = [
    [
        "name" => "Asus ROG STRIX B550-F  ",
        "category" => "Placas Mãe",
        "price" => "180.70€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/29/299957/1454-asus-rog-strix-b550-f-gaming.jpg",
        "description" => "Placa-mãe ATX para Intel com design gamer e recursos de overclock."
    ],
    [
        "name" => "Gigabyte B450 AORUS M",
        "category" => "Placas Mãe",
        "price" => "80.90€",
        "image" => "https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcSc_ZXoJRShiaK4bohJXl53Jf6HlUCqGN5tYkIIxLBHo48aYSnHqa-wpWg1k8yz773E4Vgwux4mF1mqbZmt1IEHrSbmU-lsEg",
        "description" => "Placa-mãe micro ATX para AMD com excelente custo-benefício."
    ],
    [
        "name" => "MSI MPG B550 GAMING EDGE WIFI",
        "category" => "Placas Mãe",
        "price" => "204.90€",
        "image" => "https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcQun5JVPTE5ZEKYt9pdqom-4uYtfs3FsGeqV3JY3NQep0auouw75H33PtAq1cM3u8WFJ1uFUMTSQMYFyDusOBHii9rROv810A",
        "description" => "Placa-mãe com suporte a PCIe 4.0 e Wi-Fi integrado."
    ],
    [
        "name" => "ASRock X570 Phantom Gaming 4",
        "category" => "Placas Mãe",
        "price" => "199.80€",
        "image" => "https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcRzxm44KYnWGm7fvHi3ax81KFWhkHF0IpjAo9dWX200VjaDtBxIPcENw1OWu_er4iLtPU7ZTplyfARHv07a7TAiNg6mC5Fz",
        "description" => "Placa-mãe para gamers com excelente design e desempenho."
    ],
    [
        "name" => "ASUS TUF Gaming B550-PLUS",
        "category" => "Placas Mãe",
        "price" => "128.08€",
        "image" => "https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcRfYX3quzrNHWDg64OeRUOZKn3w-w7rbbNCYFLPE-vXnRV2-HsE",
        "description" => "Placa-mãe robusta e durável, ideal para jogos e uso intenso."
    ],
    [
        "name" => "Gigabyte Z490 AORUS ELITE",
        "category" => "Placas Mãe",
        "price" => "239.99€",
        "image" => "https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcRA_np4hycMeQv2n7rtrdVtf7LiusJvGr39oi4xJ-YteVbh7nR97cW5aCiEUVwMbio1rxSxZIIq-ltPCQhRvZGWqTBupgv9",
        "description" => "Placa-mãe premium com recursos avançados de resfriamento."
    ],
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteName; ?> - Placas Mãe</title>
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
    <h2>Placas Mãe</h2>
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
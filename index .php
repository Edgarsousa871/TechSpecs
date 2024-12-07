<?php
require './bd/basedados.php'; // Inclui a conexão com o banco de dados
session_start(); // Inicia a sessão

// Nome do site e slogan
$siteName = "TechSpecs";    

// Produtos
$products = [
    [
        "name" => "Intel Core i9-11900 2.5 GHz",
        "category" => "Processadores",
        "price" => "767,74€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/36/362359/1806-intel-core-i9-11900-25-ghz.jpg",
        "description" => "Processador de alto desempenho para gamers e criadores de conteúdo."
    ],
    [
        "name" => "ASUS ROG STRIX Z790-F GAMING WIFI",
        "category" => "Placas Mãe",
        "price" => "454,37€",
        "image" => "https://thumb.pccomponentes.com/w-530-530/articles/1063/10632848/4353-asus-rog-strix-z790-f-gaming-wifi-especificacoes.jpg",
        "description" => "Placa mãe para overclocking e gaming, com RGB personalizável."
    ],
    [
        "name" => "Memória RAM Corsair Vengeance RGB Pro 32GB (2x16GB) DDR4-3200MHz CL16 Preta",
        "category" => "Memórias RAM",
        "price" => "84,90€",
        "image" => "https://pcdiga-prod.eu.saleor.cloud/media/thumbnails/products/1_p020331_2_95f84594_thumbnail_4096.jpg",
        "description" => "Memória RAM DDR4 de alta performance para jogos."
    ],
    [
        "name" => "Placa Gráfica MSI NVIDIA GeForce RTX 3060",
        "category" => "Placas Gráficas",
        "price" => "289,90€",
        "image" => "https://pcdiga-prod.eu.saleor.cloud/media/thumbnails/products/1_2_12_acfbd2ba_thumbnail_4096.jpg",
        "description" => "Placa gráfica poderosa para jogos em 4K e aplicações de criação de conteúdo."
    ],
    [
        "name" => "Fonte de Alimentação ATX Corsair RM750x Shift Series 750W 80 Plus Gold Full Modular",
        "category" => "Fontes de Alimentação",
        "price" => "157,90€",
        "image" => "https://pcdiga-prod.eu.saleor.cloud/media/thumbnails/products/p051578_a1_4947727f_thumbnail_4096.jpg",
        "description" => "Fonte de alimentação modular e eficiente com 750W."
    ],
];

try {
    // Consulta para obter todos os componentes únicos
   // Alterar consulta para obter os id_componentes e seus nomes
$query = "SELECT id_componentes, componente FROM componentes";
$stmt = $pdo->prepare($query);
$stmt->execute();
$components = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Agora buscamos o ID e o nome

} catch (PDOException $e) {
    die("Erro ao buscar componentes: " . $e->getMessage());
}


// Verificando se o usuário está logado
$loggedInUser = isset($_SESSION['nome']) ? $_SESSION['nome'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteName; ?> - <?php echo $slogan; ?></title>
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
            padding-top: 40px;
            text-align: left;
            position: relative;
        }
        .menu-button {
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
            background-color: #0073e6;
            color: white;
            border: none;
            border-radius: 50%;
            position: fixed;
            top: 20px;
            left: 20px;
        }
        .site-info {
            margin-left: 80px;
            margin-top: -30px;
        }
        .search-bar {
            margin-top: 5px;
            display: flex;
            justify-content: center;
        }
        .search-bar input[type="text"] {
            padding: 10px;
            width: 40%;
            border: none;
            border-radius: 4px;
        }
        .search-bar button {
            padding: 10px;
            border: none;
            background-color: #333;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .menu-vertical {
            display: none;
            position: fixed;
            top: 60px;
            left: 10px;
            background-color: #333;
            width: 200px;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 100;
        }
        .menu-vertical ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .menu-vertical li {
            margin: 10px 0;
        }
        .menu-vertical a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            transition: background-color 0.3s;
        }
        .menu-vertical a:hover {
            background-color: #575757;
        }
        .header-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: -30px;
            margin-right: 20px;
        }
        .header-actions a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-left: 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .header-actions a:hover {
            background-color: #575757;
        }
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .product img {
            max-width: 100%;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .product h3 {
            margin: 10px 0;
            color: #333;
        }
        .product p {
            color: #555;
        }
        .product span {
            font-weight: bold;
            color: #0073e6;
            display: block;
            margin-top: 10px;
        }
        .product button {
            padding: 8px 16px;
            border: none;
            background-color: #0073e6;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .product button:hover {
            background-color: #005bb5;
        }
    </style>
    <script>
        function toggleMenu() {
            const menu = document.getElementById("menuVertical");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
    </script>
</head>
<body>

<header>
    <button class="menu-button" onclick="toggleMenu()">⋮</button>

    <div class="site-info">
        <h1><?php echo $siteName; ?></h1>   
    </div>

    <div class="search-bar">
        <input type="text" placeholder="Pesquisar componentes...">
        <button>Buscar</button>
    </div>

    <div class="header-actions">
        <?php if ($loggedInUser): ?>
            <span>Olá, <?php echo htmlspecialchars($loggedInUser); ?>!</span>
            <a href="login.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
        <a href="carrinho.php">🛒 Carrinho</a>
        <a href="favoritos.php">❤️ Favoritos</a>
    </div>
</header>

<nav id="menuVertical" class="menu-vertical">
    <ul>
        <?php
        if (!empty($components)) {
            foreach ($components as $component): ?>
                <li>
                    <!-- Passando o ID do componente na URL -->
                    <a href="resultados.php?componente=<?php echo urlencode($component['id_componentes']); ?>">
                        <?php echo htmlspecialchars($component['componente']); ?> <!-- Nome do componente -->
                    </a>
                </li>
            <?php endforeach;
        } else { ?>
            <li>Nenhum componente encontrado.</li>
        <?php } ?>
    </ul>
</nav>


<h2>Produtos em Destaque</h2>
<div class="product-container">
    <?php foreach ($products as $product): ?>
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
    <?php endforeach; ?>
</div>

</body>
</html>

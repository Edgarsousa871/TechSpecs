<?php
require './bd/basedados.php'; // Inclui a conexão com o banco de dados

$componente = $_GET['componente'] ?? null;

if (!$componente) {
    die("Componente não especificado.");
}

try {
    // Consulta para obter o componente e os produtos relacionados
    $query = "
        SELECT 
            p.id_produto, 
            p.nome AS produto_nome, 
            p.preco, 
            p.imagem,
            c.componente AS componente_nome
        FROM 
            produtos p
        INNER JOIN 
            componentes c ON p.componente = c.id_componentes
        WHERE 
            c.id_componentes = :componente
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':componente', $componente, PDO::PARAM_INT);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar detalhes do componente: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Componente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            color: #333;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }
        .produto-card {
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
        }
        .produto-card img {
            width: 100%;
            max-width: 200px;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .produto-card h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #333;
        }
        .produto-card p {
            margin: 5px 0;
            color: #555;
        }
        .produto-card span {
            font-weight: bold;
            color: #0073e6;
        }
        @media (max-width: 768px) {
            .produto-card {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <h1>Detalhes do Componente: "<?php echo htmlspecialchars($componente); ?>"</h1>

    <div class="container">
        <?php if (count($resultados) > 0): ?>
            <?php foreach ($resultados as $resultado): ?>
                <div class="produto-card">
                    <img src="<?php echo htmlspecialchars($resultado['imagem']); ?>" alt="<?php echo htmlspecialchars($resultado['produto_nome']); ?>">
                    <h2><?php echo htmlspecialchars($resultado['produto_nome']); ?></h2>
                    <p><strong>Preço:</strong> <span>€<?php echo number_format($resultado['preco'], 2); ?></span></p>
                    <p><strong>Componente:</strong> <?php echo htmlspecialchars($resultado['componente_nome']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Não há produtos disponíveis para este componente.</p>
        <?php endif; ?>
    </div>
</body>
</html>

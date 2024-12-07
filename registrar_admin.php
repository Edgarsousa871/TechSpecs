<?php
session_start();

require_once('./bd/basedados.php');
require_once('./bd/autenticacao.php');
?>

<div class="option-box">
    <h3>Criar Novo Administrador</h3>
    <form action="create_admin.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit" name="create_admin" class="button">Criar Admin</button>
    </form>
</div>

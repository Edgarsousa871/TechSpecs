<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('basedados.php');


function login($email, $password) {
    $bd = conexaoBD();
    try {
        // Prepara a instrução SQL para selecionar o usuário com o email fornecido
        $login = $bd->prepare("SELECT * FROM clientes WHERE email = :email");
        $login->bindValue(":email", $email);
        $login->execute();

        // Verifica se encontrou um usuário com o email fornecido
        if ($login->rowCount() == 1) {
            $dados = $login->fetch(PDO::FETCH_OBJ);
            // Verifica se a senha fornecida pelo usuário corresponde à senha armazenada no banco de dados
            if (password_verify($password, $dados->password)) {
                // Se as senhas coincidirem, configura as variáveis de sessão e retorna verdadeiro
                $_SESSION['login_utili'] = true;
                $_SESSION['ID'] = $dados->idCliente;
                $_SESSION['NOME'] = $dados->nome;
                return true;
            }
        }
        // Se não encontrou o usuário ou a senha não coincidiu, retorna falso
        return false;
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem de erro
        echo "Erro: " . $e->getMessage();
        return false;
    }
}



function Autenticacao() {
    
    if (!isset($_SESSION['login_utili'])):
      
        header('Location: login.php');
    
    endif;
    
}
function logout() {
    //VERIFICA A SESSÃO DO UTILIZADOR
    if (isset($_SESSION['login_utili'])) {
        //LIMPA A SESSÃO
        unset($_SESSION['login_utili']);
        unset($_SESSION['ID']);
        //DESTROI A SESSÃO
        session_destroy();
        header('Location: login.php');
    }
}

?>
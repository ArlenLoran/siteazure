<?php
$servername = "arlendbteste.mysql.database.azure.com";
$username = "arlendbteste";
$password = "3KT8zx203@Brasil";
$dbname = "tabela1";
$ssl_ca = "DigiCertGlobalRootG2.crt.pem";

$conn = new mysqli($servername, $username, $password, $dbname, 3306, null, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $senha = $conn->real_escape_string($_POST['senha']);

    $sql = "INSERT INTO usuarios (nome, senha) VALUES ('$nome', '$senha')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuário criado com sucesso.";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
</head>
<body>
    <h1>Criar Novo Usuário</h1>
    <form method="post" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br><br>
        <input type="submit" value="Criar Usuário">
    </form>
</body>
</html>


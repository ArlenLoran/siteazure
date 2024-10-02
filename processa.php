<!-- processa.php -->
<?php
$servername = "arlendbteste.mysql.database.azure.com"; // ou o seu servidor
$username = "arlendbteste"; // seu usuário do MySQL
$password = "3KT8zx203@Brasil"; // sua senha do MySQL
$dbname = "tabela1"; // nome do seu banco de dados

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Prepara e vincula
$stmt = $conn->prepare("INSERT INTO usuarios (nome) VALUES (?)");
$stmt->bind_param("s", $nome);

// Define o valor da variável e executa
$nome = $_POST['nome'];
$stmt->execute();

echo "Usuário cadastrado com sucesso!";

$stmt->close();
$conn->close();
?>

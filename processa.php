<!-- cria_banco.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "arlendbteste.mysql.database.azure.com"; 
$username = "arlendbteste"; 
$password = "3KT8zx203@Brasil"; 
$dbname = "tabela1"; // Certifique-se de que esse banco de dados já exista

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// SQL para criar a tabela
$sql = "CREATE TABLE IF NOT EXISTS colaborador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'colaborador' criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Fecha a conexão
$conn->close();
?>

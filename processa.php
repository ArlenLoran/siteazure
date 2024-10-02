<!-- processa.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$servername = "arlendbteste.mysql.database.azure.com"; 
$username = "arlendbteste"; 
$password = "3KT8zx203@Brasil"; 
$dbname = "tabela1"; 

// Caminho para o arquivo CA
$ca = 'DigiCertGlobalRootG2.crt'; // Atualize este caminho

// Cria conexão com SSL
$conn = new mysqli($servername, $username, $password, $dbname, 3306, null, MYSQLI_CLIENT_SSL, $ca);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexão falhou: " . $conn->connect_error]);
    exit();
}

// Resto do código para processar a requisição
$nome = $_POST['nome'] ?? null;
$senha = $_POST['senha'] ?? null;

if (empty($nome) || empty($senha)) {
    echo json_encode(["status" => "error", "message" => "Nome e senha não podem ser vazios."]);
    exit();
}

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO colaborador (nome, senha) VALUES (?, ?)");
$stmt->bind_param("ss", $nome, $senha_hash);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Colaborador cadastrado com sucesso!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro ao cadastrar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

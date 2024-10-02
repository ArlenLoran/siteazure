<!-- processa.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$servername = "arlendbteste.mysql.database.azure.com"; 
$username = "arlendbteste"; 
$password = "3KT8zx203@Brasil"; 
$dbname = "tabela1"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexão falhou: " . $conn->connect_error]);
    exit();
}

$nome = $_POST['nome'] ?? null;
$senha = $_POST['senha'] ?? null;

if (empty($nome) || empty($senha)) {
    echo json_encode(["status" => "error", "message" => "Nome e senha não podem ser vazios."]);
    exit();
}

// Criptografar a senha antes de armazená-la
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Debug: Verificar valores
var_dump($nome, $senha_hash); // Adicione esta linha para ver o que está sendo enviado
$stmt = $conn->prepare("INSERT INTO usuarios (nome, senha) VALUES (?, ?)");
if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Erro na preparação da declaração: " . $conn->error]);
    exit();
}

$stmt->bind_param("ss", $nome, $senha_hash);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Usuário cadastrado com sucesso!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro ao cadastrar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

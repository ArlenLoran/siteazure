<!-- processa.php -->
<?php
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

$stmt = $conn->prepare("INSERT INTO usuarios (nome) VALUES (?)");
$stmt->bind_param("s", $nome);

$nome = $_POST['nome'];

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Usuário cadastrado com sucesso!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro ao cadastrar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

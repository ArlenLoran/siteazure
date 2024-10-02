<!-- processa.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Informações de conexão
$servername = "arlendbteste.mysql.database.azure.com"; 
$username = "arlendbteste"; 
$password = "3KT8zx203@Brasil"; 
$dbname = "tabela1"; 
$ca = 'DigiCertGlobalRootCA.crt'; // Atualize para o caminho do seu certificado CA

// Inicializa a conexão
$con = mysqli_init();

if (!$con) {
    die("Falha ao inicializar: " . mysqli_connect_error());
}

// Configura SSL
mysqli_ssl_set($con, NULL, NULL, $ca, NULL, NULL);

// Tenta conectar
if (!mysqli_real_connect($con, $servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    echo json_encode(["status" => "error", "message" => "Conexão falhou: " . mysqli_connect_error()]);
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

$stmt = $con->prepare("INSERT INTO colaborador (nome, senha) VALUES (?, ?)");
$stmt->bind_param("ss", $nome, $senha_hash);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Colaborador cadastrado com sucesso!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro ao cadastrar: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>

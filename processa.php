<!-- processa.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$servername = "arlendbteste.mysql.database.azure.com"; 
$username = "arlendbteste"; 
$password = "3KT8zx203@Brasil"; 
$dbname = "tabela1"; 

// Caminho para os arquivos de certificado SSL
$ca = 'DigiCertGlobalRootG2.crt'; // Substitua pelo caminho do seu arquivo CA

$conn = new mysqli($servername, $username, $password, $dbname, 3306, null, MYSQLI_CLIENT_SSL, $ca);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexão falhou: " . $conn->connect_error]);
    exit();
}

// Resto do código...

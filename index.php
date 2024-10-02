<?php
// Inicializa a conexão
$con = mysqli_init();

// Configura a conexão SSL
mysqli_ssl_set($con, NULL, NULL, "DigiCertGlobalRootG2.crt.pem", NULL, NULL);

// Conecta ao banco de dados
$hostname = "arlendbteste.mysql.database.azure.com";
$username = "arlendbteste";
$password = "3KT8zx203@Brasil"; // Substitua pelo seu password
$database = "tabela1"; // Substitua pelo seu nome do banco de dados

$conn = mysqli_real_connect($con, $hostname, $username, $password, $database, 3306, MYSQLI_CLIENT_SSL);

// Verifica a conexão
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Exibe uma mensagem de sucesso
echo "Conexão bem-sucedida ao banco de dados!";

// Fecha a conexão
mysqli_close($con);
?>

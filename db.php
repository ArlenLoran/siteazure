<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function getDbConnection() {
    $con = mysqli_init();
    
    // Configura o certificado SSL
    mysqli_ssl_set($con, NULL, NULL, $_ENV['CA_CERT_PATH'], NULL, NULL);
    
    // Realiza a conexão
    if (mysqli_real_connect($con, $_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE'], 3306, NULL, MYSQLI_CLIENT_SSL)) {
        return $con;
    } else {
        throw new Exception("Erro na conexão: " . mysqli_connect_error());
    }
}
?>

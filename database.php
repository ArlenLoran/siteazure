<?php

// Inclui o autoloader do Composer para carregar dependências
require 'vendor/autoload.php';

// Inclui o arquivo de configuração
$config = require 'config.php';

// Inicializa a conexão
$con = mysqli_init();

// Configura o certificado SSL
$caCertPath = $config['ca_cert_path']; // Caminho para o seu certificado CA
mysqli_ssl_set($con, NULL, NULL, $caCertPath, NULL, NULL);

// Realiza a conexão
$host = $config['db_host'];         // Endereço do servidor MySQL
$username = $config['db_username']; // Nome de usuário do banco de dados
$password = $config['db_password']; // Senha do banco de dados
$database = $config['db_database']; // Nome do banco de dados

if (mysqli_real_connect($con, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    echo "Conexão bem-sucedida ao banco de dados!\n";
    
    // Aqui você pode realizar suas operações com o banco de dados
    // Exemplo de uma consulta
    $query = "SELECT * FROM usuarios";
    $result = mysqli_query($con, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            print_r($row);
        }
    } else {
        echo "Erro na consulta: " . mysqli_error($con);
    }

    // Fecha a conexão
    mysqli_close($con);
} else {
    echo "Erro na conexão: " . mysqli_connect_error();
}
?>

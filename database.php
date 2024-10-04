<?php

// Inclui o autoloader do Composer para carregar dependências
require 'vendor/autoload.php';

// Inclui o arquivo de configuração
$config = require 'config.php';

// Função para estabelecer a conexão com o banco de dados
function createConnection($config) {
    $con = mysqli_init();
    
    // Configura o certificado SSL
    mysqli_ssl_set($con, NULL, NULL, $config['ca_cert_path'], NULL, NULL);
    
    // Tenta conectar ao banco de dados
    if (mysqli_real_connect($con, $config['db_host'], $config['db_username'], $config['db_password'], $config['db_database'], 3306, NULL, MYSQLI_CLIENT_SSL)) {
        return $con;
    } else {
        throw new Exception("Erro na conexão: " . mysqli_connect_error());
    }
}

// Função para executar uma consulta e retornar os resultados
function executeQuery($con, $query) {
    $result = mysqli_query($con, $query);
    
    if ($result === false) {
        throw new Exception("Erro na consulta: " . mysqli_error($con));
    }
    
    return $result;
}

try {
    // Estabelece a conexão
    $connection = createConnection($config);
    echo "Conexão bem-sucedida ao banco de dados!\n";
    
    // Exemplo de uma consulta
    $query = "SELECT * FROM usuarios";
    $result = executeQuery($connection, $query);
    
    // Processa os resultados
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
    }
    
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    // Fecha a conexão, se estiver aberta
    if (isset($connection) && $connection) {
        mysqli_close($connection);
    }
}
?>

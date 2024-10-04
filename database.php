<?php

require 'config.php';

// Inicializa a conexão
$con = mysqli_init();

// Configura o certificado SSL
$caCertPath = 'DigiCertGlobalRootCA.crt.pem'; // Caminho para o seu certificado CA
mysqli_ssl_set($con, NULL, NULL, $caCertPath, NULL, NULL);

// Realiza a conexão
$host = 'arlendbteste.mysql.database.azure.com';
$username = $config['db_username'];
$password = '3KT8zx203@Brasil'; // Substitua pelo seu password
$database = 'tabela1'; // Substitua pelo seu nome do banco de dados

if (mysqli_real_connect($con, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    echo "Conexão bem-sucedida ao banco de dados!";
    
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

<?php

require 'config.php';

// Inicializa a conexão
$con = mysqli_init();

// Configura o certificado SSL
mysqli_ssl_set($con, NULL, NULL, $config['ca_cert_path'], NULL, NULL);

// Realiza a conexão
if (mysqli_real_connect($con, $config['db_host'], $config['db_username'], $config['db_password'], $config['db_database'], 3306, NULL, MYSQLI_CLIENT_SSL)) {
    echo "Conexão bem-sucedida ao banco de dados!<br>";
    
    // Exemplo de uma consulta
    $query = "SELECT * FROM usuarios"; // Ajuste aqui para a tabela desejada
    $result = mysqli_query($con, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            print_r($row); // Mostra os dados da tabela
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

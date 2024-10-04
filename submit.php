<?php
// Inclui o autoloader do Composer para carregar dependências
require 'vendor/autoload.php';

// Inclui o arquivo de configuração
$config = require 'config.php';

// Inicializa a conexão
$con = mysqli_init();

// Configura o certificado SSL
$caCertPath = 'DigiCertGlobalRootCA.crt.pem'; // Caminho para o seu certificado CA
mysqli_ssl_set($con, NULL, NULL, $caCertPath, NULL, NULL);

// Realiza a conexão
$host = $config['db_host'];         // Endereço do servidor MySQL
$username = $config['db_username']; // Nome de usuário do banco de dados
$password = $config['db_password']; // Senha do banco de dados
$database = $config['db_database']; // Nome do banco de dados

if (mysqli_real_connect($con, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    echo "Conexão bem-sucedida ao banco de dados!<br>";
    
    // Captura os dados do formulário
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    
    // Insere os dados no banco
    $query = "INSERT INTO usuarios (name, email) VALUES ('$name', '$email')";
    
    if (mysqli_query($con, $query)) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário: " . mysqli_error($con);
    }

    // Fecha a conexão
    mysqli_close($con);
} else {
    echo "Erro na conexão: " . mysqli_connect_error();
}
?>

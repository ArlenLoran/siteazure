<?php

// Inclui o autoloader do Composer para carregar dependências
require 'vendor/autoload.php';

use Dotenv\Dotenv;

// Cria uma instância do Dotenv e carrega as variáveis de ambiente do arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Retorna as configurações do banco de dados como um array associativo
return [
    'db_host' => $_ENV['DB_HOST'],         // Endereço do servidor MySQL
    'db_username' => $_ENV['DB_USERNAME'], // Nome de usuário do banco de dados
    'db_password' => $_ENV['DB_PASSWORD'], // Senha do banco de dados
    'db_database' => $_ENV['DB_DATABASE'], // Nome do banco de dados (ajustado de DB_NAME para DB_DATABASE)
    'ca_cert_path' => $_ENV['CA_CERT_PATH'], // Caminho para o certificado CA
];

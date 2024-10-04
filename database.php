<?php

// Inclui o autoloader do Composer para carregar dependências
require 'vendor/autoload.php';

// Inclui o arquivo de configuração
$config = require 'config.php';

// Imprime as variáveis de configuração
echo "Configurações do Banco de Dados:\n";
echo "Host: " . $config['db_host'] . "\n";
echo "Usuário: " . $config['db_username'] . "\n";
echo "Senha: " . $config['db_password'] . "\n";
echo "Banco de Dados: " . $config['db_database'] . "\n";
echo "Caminho do Certificado CA: " . $config['ca_cert_path'] . "\n";

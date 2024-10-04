<?php

require 'config.php';

/**
 * Cria uma conexão PDO com o banco de dados.
 *
 * @return PDO
 * @throws PDOException
 */
function createPdoConnection(array $config): PDO
{
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => $config['ca_cert_path'], // Caminho para o certificado CA
    ];

    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_database']};charset=utf8",
        $config['db_username'],
        $config['db_password'],
        $options
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

/**
 * Cria uma conexão MySQLi com o banco de dados.
 *
 * @return mysqli
 */
function createMysqliConnection(array $config): mysqli
{
    $mysqli = mysqli_init();
    mysqli_ssl_set($mysqli, NULL, NULL, $config['ca_cert_path'], NULL, NULL);

    if (!mysqli_real_connect($mysqli, $config['db_host'], $config['db_username'], $config['db_password'], $config['db_database'], 3306, NULL, MYSQLI_CLIENT_SSL)) {
        error_log("MySQLi connection failed: " . mysqli_connect_error(), 3, __DIR__ . '/errors.log');
        die("An error occurred while connecting to the database.");
    }

    return $mysqli;
}

try {
    // Conectando ao banco de dados com PDO
    $pdo = createPdoConnection($config);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage(), 3, __DIR__ . '/errors.log');
    die("An error occurred while connecting to the database.");
}

// Cria uma conexão MySQLi
$conexao = createMysqliConnection($config);

// Exemplo de consulta usando MySQLi
$query = "SELECT * FROM usuarios"; // Ajuste aqui para a tabela desejada
$result = mysqli_query($conexao, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row); // Mostra os dados da tabela
    }
} else {
    echo "Erro na consulta: " . mysqli_error($conexao);
}

// Fecha a conexão MySQLi
mysqli_close($conexao);

// Você pode usar $pdo e $conexao em outros arquivos conforme necessário

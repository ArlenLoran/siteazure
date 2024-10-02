<?php
// Configurações de conexão
$db_config = [
    'user' => 'arlendbteste',
    'password' => '3KT8zx203@Brasil',
    'host' => 'arlendbteste.mysql.database.azure.com',
    'port' => 3306,
    'database' => 'tabela1',
    'ssl_ca' => 'DigiCertGlobalRootG2.crt.pem' // Caminho para o certificado CA
];

// Inicializa a conexão
$con = mysqli_init();
if (!$con) {
    die("Falha ao inicializar a conexão: " . mysqli_connect_error());
}

// Configura SSL
mysqli_ssl_set($con, NULL, NULL, $db_config['ssl_ca'], NULL, NULL);

// Conecta ao banco de dados
if (!mysqli_real_connect($con, $db_config['host'], $db_config['user'], $db_config['password'], $db_config['database'], $db_config['port'], NULL, MYSQLI_CLIENT_SSL)) {
    die("Erro de conexão: " . mysqli_connect_error());
}

try {
    // Consultando todos os usuários
    $select_users_query = "SELECT * FROM usuarios";
    $result = mysqli_query($con, $select_users_query);

    // Verifica se a consulta retornou resultados
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "Usuários cadastrados:<br>";
            while ($usuario = mysqli_fetch_assoc($result)) {
                echo "ID: " . htmlspecialchars($usuario['id']) . ", Nome: " . htmlspecialchars($usuario['nome']) . ", Senha: " . htmlspecialchars($usuario['senha']) . "<br>";
            }
        } else {
            echo "Nenhum usuário encontrado.";
        }
    } else {
        throw new Exception("Erro na consulta: " . mysqli_error($con));
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    // Fechando a conexão
    mysqli_close($con);
}
?>

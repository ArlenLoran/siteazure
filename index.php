<?php
// Configurações de conexão
$host = "arlendbteste.mysql.database.azure.com";
$port = 3306;
$username = "arlendbteste"; // Substitua pelo seu usuário
$password = "3KT8zx203@Brasil"; // Substitua pela sua senha
$database = "tabela1"; // Nome do banco de dados
$ssl_ca = "DigiCertGlobalRootG2.crt.pem"; // Caminho para o certificado CA

// Inicializa a conexão
$con = mysqli_init();
if (!$con) {
    die("Falha ao inicializar a conexão: " . mysqli_connect_error());
}

// Configura SSL
mysqli_ssl_set($con, NULL, NULL, $ssl_ca, NULL, NULL);

// Conecta ao banco de dados
if (!mysqli_real_connect($con, $host, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consultando todos os usuários
$query = "SELECT * FROM usuarios";
$result = mysqli_query($con, $query);

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
    echo "Erro na consulta: " . mysqli_error($con);
}

// Fecha a conexão
mysqli_close($con);
?>

<?php
// Configurações
$db_host = "arlendbteste.mysql.database.azure.com";
$db_user = "arlendbteste";
$db_password = "3KT8zx203@Brasil"; // Substitua pela sua senha
$db_name = "tabela1";

// Inicializa a conexão
$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, "DigiCertGlobalRootG2.crt.pem", NULL, NULL); // Substitua pelo caminho correto para o certificado

// Conecta ao banco de dados
if (!mysqli_real_connect($con, $db_host, $db_user, $db_password, $db_name, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consulta para selecionar todos os usuários
$query = "SELECT * FROM usuarios";
$result = mysqli_query($con, $query);

// Verifica se a consulta retornou resultados
if (mysqli_num_rows($result) > 0) {
    // Início da tabela HTML
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Senha</th></tr>";

    // Loop através dos resultados e exibe cada usuário
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['senha']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum usuário encontrado.";
}

// Fecha a conexão
mysqli_close($con);
?>

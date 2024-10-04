<?php
// Inicializa a conexão
$con = mysqli_init();

// Configura o certificado SSL
$caCertPath = 'DigiCertGlobalRootCA.crt.pem'; // Caminho para o seu certificado CA
mysqli_ssl_set($con, NULL, NULL, $caCertPath, NULL, NULL);

// Realiza a conexão
$host = 'arlendbteste.mysql.database.azure.com';
$username = 'arlendbteste';
$password = '3KT8zx203@Brasil'; // Substitua pelo seu password
$database = 'tabela1'; // Substitua pelo seu nome do banco de dados

if (mysqli_real_connect($con, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    // Verifica se os dados foram enviados
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = mysqli_real_escape_string($con, $_POST['nome']);
        $email = mysqli_real_escape_string($con, $_POST['email']);

        // Insere os dados na tabela
        $query = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";
        
        if (mysqli_query($con, $query)) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário: " . mysqli_error($con);
        }
    }

    // Fecha a conexão
    mysqli_close($con);
} else {
    echo "Erro na conexão: " . mysqli_connect_error();
}
?>

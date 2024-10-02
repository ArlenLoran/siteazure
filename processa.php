<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    // Conexão com o banco de dados
    $con = mysqli_init();
    mysqli_ssl_set($con, NULL, NULL, "DigiCertGlobalRootG2.crt.pem", NULL, NULL);
    
    // Tente conectar ao banco de dados
    if (!mysqli_real_connect($con, "arlendbteste.mysql.database.azure.com", "arlendbteste", "3KT8zx203@Brasil", "tabela1", 3306, NULL, MYSQLI_CLIENT_SSL)) {
        die("Erro de conexão: " . mysqli_connect_error());
    }

    // Prepara a consulta para evitar injeção de SQL
    $stmt = $con->prepare("INSERT INTO usuarios (nome, senha) VALUES (?, ?)");
    
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $con->error);
    }

    $stmt->bind_param("ss", $nome, $senha);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fecha a conexão
    $stmt->close();
    mysqli_close($con);
}
?>

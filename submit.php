<?php
// Inclui o arquivo de conexão com o banco de dados
$con = include 'database.php';

// Captura os dados do formulário
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);

// Insere os dados no banco
$query = "INSERT INTO usuarios (nome, email) VALUES ('$name', '$email')";

if (mysqli_query($con, $query)) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar usuário: " . mysqli_error($con);
}

// Fecha a conexão
mysqli_close($con);
?>

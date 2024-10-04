<?php
require 'db.php';

try {
    $con = getDbConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = mysqli_real_escape_string($con, $_POST['nome']);
        $email = mysqli_real_escape_string($con, $_POST['email']);

        $query = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";
        
        if (mysqli_query($con, $query)) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

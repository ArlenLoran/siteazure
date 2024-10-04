<?php
// Inclui o arquivo de conexão com o banco de dados
$con = include 'database.php';

// Consulta os usuários
$query = "SELECT * FROM usuarios";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>Nenhum usuário encontrado.</td></tr>";
}

// Fecha a conexão
mysqli_close($con);
?>

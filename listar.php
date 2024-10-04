<?php
require 'db.php';

try {
    $con = getDbConnection();

    $query = "SELECT * FROM usuarios";
    $result = mysqli_query($con, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Nome: " . htmlspecialchars($row['nome']) . " - Email: " . htmlspecialchars($row['email']) . "<br>";
        }
    } else {
        echo "Erro na consulta: " . mysqli_error($con);
    }

    mysqli_close($con);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

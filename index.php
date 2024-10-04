<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Usuário</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form id="userForm">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <input type="submit" value="Cadastrar">
    </form>

    <script>
        $(document).ready(function() {
            $('#userForm').on('submit', function(event) {
                event.preventDefault(); // Impede o envio normal do formulário

                $.ajax({
                    url: 'submit.php', // O arquivo que processa o input
                    type: 'POST',
                    data: $(this).serialize(), // Serializa os dados do formulário
                    success: function(response) {
                        alert(response); // Exibe a resposta do PHP
                    },
                    error: function() {
                        alert('Erro ao cadastrar usuário. Tente novamente.');
                    }
                });
            });
        });
    </script>
</body>
</html>

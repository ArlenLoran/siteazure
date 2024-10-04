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
    
    <button id="listUsers">Listar Usuários</button>
    
    <h2>Usuários Cadastrados</h2>
    <table id="usersTable" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os dados dos usuários serão inseridos aqui -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Função para cadastrar usuário
            $('#userForm').on('submit', function(event) {
                event.preventDefault(); // Impede o envio normal do formulário

                $.ajax({
                    url: 'submit.php', // O arquivo que processa o input
                    type: 'POST',
                    data: $(this).serialize(), // Serializa os dados do formulário
                    success: function(response) {
                        alert(response); // Exibe a resposta do PHP
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Erro ao cadastrar usuário: ' + errorThrown);
                    }
                });
            });

            // Função para listar usuários
            $('#listUsers').on('click', function() {
                $.ajax({
                    url: 'list.php', // O arquivo que processa a listagem
                    type: 'GET',
                    success: function(response) {
                        $('#usersTable tbody').html(response); // Insere os dados na tabela
                    },
                    error: function() {
                        alert('Erro ao listar usuários. Tente novamente.');
                    }
                });
            });
        });
    </script>
</body>
</html>

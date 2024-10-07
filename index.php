<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            margin-bottom: 30px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Cadastro de Usuário</h1>
        <form id="userForm" class="mb-4">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

        <button id="listUsers" class="btn btn-secondary mb-3">Listar Usuários</button>
        
        <h2>Usuários Cadastrados</h2>
        <table class="table table-striped table-bordered" id="usersTable">
            <thead class="thead-dark">
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
    </div>

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

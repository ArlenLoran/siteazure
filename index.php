<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Cadastro de Usuários</h1>
    <form id="cadastroForm">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <input type="submit" value="Cadastrar">
    </form>

    <h2>Usuários Cadastrados</h2>
    <div id="usuariosList"></div>
    <button id="listarBtn">Listar Todos os Usuários</button>

    <script>
        $(document).ready(function() {
            // Enviar dados do formulário via AJAX
            $('#cadastroForm').on('submit', function(event) {
                event.preventDefault(); // Impede o envio normal do formulário
                
                $.ajax({
                    type: 'POST',
                    url: 'cadastrar.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        listarUsuarios(); // Atualiza a lista após o cadastro
                    },
                    error: function() {
                        alert('Erro ao cadastrar usuário.');
                    }
                });
            });

            // Listar usuários
            $('#listarBtn').on('click', function() {
                listarUsuarios();
            });

            function listarUsuarios() {
                $.ajax({
                    type: 'GET',
                    url: 'listar.php',
                    success: function(response) {
                        $('#usuariosList').html(response);
                    },
                    error: function() {
                        alert('Erro ao listar usuários.');
                    }
                });
            }
        });
    </script>
</body>
</html>

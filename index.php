<!-- index.html -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuárioss</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Cadastro de Usuários</h1>
    <form id="cadastroForm">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Cadastrar</button>
    </form>
    <div id="resultado"></div>

    <script>
        $(document).ready(function() {
            $('#cadastroForm').on('submit', function(event) {
                event.preventDefault(); // Previne o envio normal do formulário

                $.ajax({
                    type: 'POST',
                    url: 'processa.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#resultado').html(response);
                        $('#cadastroForm')[0].reset(); // Limpa o formulário após o envio
                    },
                    error: function() {
                        $('#resultado').html('Ocorreu um erro ao cadastrar o usuário.');
                    }
                });
            });
        });
    </script>
</body>
</html>

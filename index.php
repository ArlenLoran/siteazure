<!-- index.html -->
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
        <input type="text" id="nome" name="nome" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <button type="submit">Cadastrar</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#cadastroForm').on('submit', function(event) {
                event.preventDefault(); // Previne o envio normal do formulário

                $.ajax({
                    type: 'POST',
                    url: 'processa.php',
                    data: $(this).serialize(),
                    dataType: 'json', // Espera uma resposta em JSON
                    success: function(response) {
                        if (response.status === "success") {
                            alert(response.message); // Alerta de sucesso
                            $('#cadastroForm')[0].reset(); // Limpa o formulário após o envio
                        } else {
                            alert("Erro: " + response.message); // Alerta de erro
                        }
                    },
                    error: function() {
                        alert('Ocorreu um erro ao cadastrar o usuário.'); // Erro de comunicação
                    }
                });
            });
        });
    </script>
</body>
</html>

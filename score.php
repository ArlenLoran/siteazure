<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Placa</title>
    <script>
        function pesquisar() {
            const invnum = document.getElementById('invnum').value;
            const resultadoInput = document.getElementById('resultado');

            fetch('seu_script.php', { // Altere 'seu_script.php' para o caminho do seu arquivo PHP
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `invnum=${invnum}`
            })
            .then(response => response.json())
            .then(data => {
                resultadoInput.value = data.length > 0 ? data.join(', ') : 'Nenhum resultado encontrado';
            })
            .catch(error => {
                console.error('Erro:', error);
                resultadoInput.value = 'Erro na pesquisa';
            });
        }
    </script>
</head>
<body>

    <h1>Pesquisar Placa</h1>
    <input type="text" id="invnum" placeholder="Digite o número da nota" />
    <button onclick="pesquisar()">Pesquisar</button>
    <br><br>
    <input type="text" id="resultado" placeholder="Resultado" readonly />

</body>
</html>

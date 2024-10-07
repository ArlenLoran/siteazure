<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Nota</title>
</head>
<body>

    <h1>Pesquisar Nota</h1>
    <form id="searchForm" method="POST" action="process.php">
        <input type="text" name="invoice_number" placeholder="Digite o número da nota" required>
        <button type="submit">Pesquisar</button>
    </form>

    <div id="result">
        <!-- Os inputs dos resultados aparecerão aqui -->
    </div>

    <script>
        // Captura o envio do formulário
        document.getElementById('searchForm').onsubmit = function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            const formData = new FormData(this);

            // Faz a requisição usando fetch
            fetch('process.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = ''; // Limpa resultados anteriores

                // Cria inputs para cada coluna retornada
                for (const [key, value] of Object.entries(data)) {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = key;
                    input.placeholder = key;
                    input.value = value;
                    resultDiv.appendChild(input);
                    resultDiv.appendChild(document.createElement('br'));
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        };
    </script>

</body>
</html>

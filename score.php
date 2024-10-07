<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Nota</title>
</head>
<body>

    <h1>Pesquisar Nota</h1>
    <form id="searchForm" method="POST">
        <input type="text" name="invoice_number" placeholder="Digite o número da nota" required>
        <button type="submit">Pesquisar</button>
    </form>

    <div id="result">
        <!-- Input para a placa do veículo aparecerá aqui -->
        <input type="text" id="tractorNum" placeholder="Placa do veículo" readonly>
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
                const tractorNumInput = document.getElementById('tractorNum');

                if (data.error) {
                    // Se houver erro, mostre uma mensagem
                    tractorNumInput.value = ''; // Limpa o campo
                    alert(data.error);
                    return;
                }

                // Preenche o input com a placa do veículo
                if (data.TR?.TRACTOR_NUM) {
                    tractorNumInput.value = data.TR.TRACTOR_NUM;
                } else {
                    tractorNumInput.value = ''; // Limpa o campo se não encontrar
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        };
    </script>

</body>
</html>

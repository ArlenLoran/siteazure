<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Invoice</title>
    <script>
        async function consultar() {
            const invoice = document.getElementById('invoice').value;
            const response = await fetch('consulta.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ invoice: invoice })
            });
            const data = await response.json();
            if (data && data.tractorNum) {
                document.getElementById('tractorNum').value = data.tractorNum;
            } else {
                alert('Placa não encontrada ou erro na consulta.');
            }
        }
    </script>
</head>
<body>
    <h1>Consulta de Invoice</h1>
    <label for="invoice">Número da Invoice:</label>
    <input type="text" id="invoice" required>
    <button onclick="consultar()">Consultar</button>

    <br><br>

    <label for="tractorNum">Placa do Trator:</label>
    <input type="text" id="tractorNum" readonly>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Placa</title>
    <script>
        function pesquisar() {
            const invnum = document.getElementById('invnum').value;
            
            // Inputs para preencher com os resultados
            const resultadoInputs = {
                trlr_num: document.getElementById('trlr_num'),
                invnum: document.getElementById('invoice'),
                trlr_broker: document.getElementById('trlr_broker'),
                driver_nam: document.getElementById('driver_nam'),
                driver_lic_num: document.getElementById('driver_lic_num'),
                trlr_typ: document.getElementById('trlr_typ'),
                nottxt: document.getElementById('nottxt'),
                yard_loc: document.getElementById('yard_loc'),
                tractor_num: document.getElementById('tractor_num'),
                trlr_seal1: document.getElementById('trlr_seal1'),
                trlr_seal2: document.getElementById('trlr_seal2'),
                trlr_seal3: document.getElementById('trlr_seal3'),
            };

            fetch('seu_script.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `invnum=${encodeURIComponent(invnum)}`
            })
            .then(response => response.json())
            .then(data => {
                console.log('Dados retornados:', data);

                // Preenche os inputs com os dados retornados
                if (data.length > 0) {
                    const result = data[0]; // Assumindo que estamos interessados apenas no primeiro resultado
                    resultadoInputs.trlr_num.value = result.trlr_num || '';
                    resultadoInputs.invnum.value = result.invnum || '';
                    resultadoInputs.trlr_broker.value = result.trlr_broker || '';
                    resultadoInputs.driver_nam.value = result.driver_nam || '';
                    resultadoInputs.driver_lic_num.value = result.DRIVER_LIC_NUM || '';
                    resultadoInputs.trlr_typ.value = result.trlr_typ || '';
                    resultadoInputs.nottxt.value = result.NOTTXT || '';
                    resultadoInputs.yard_loc.value = result.YARD_LOC || '';
                    resultadoInputs.tractor_num.value = result.TRACTOR_NUM || '';
                    resultadoInputs.trlr_seal1.value = result.TRLR_SEAL1 || '';
                    resultadoInputs.trlr_seal2.value = result.TRLR_SEAL2 || '';
                    resultadoInputs.trlr_seal3.value = result.TRLR_SEAL3 || '';
                } else {
                    // Limpa os campos se não houver resultados
                    Object.values(resultadoInputs).forEach(input => input.value = '');
                    alert('Nenhum resultado encontrado');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro na pesquisa');
            });
        }
    </script>
</head>
<body>

    <h1>Pesquisar Placa</h1>
    <input type="text" id="invnum" placeholder="Digite o número da nota" />
    <button onclick="pesquisar()">Pesquisar</button>
    <br><br>

    <input type="text" id="trlr_num" placeholder="Placa do Veículo" readonly />
    <input type="text" id="invoice" placeholder="Invoice" readonly />
    <input type="text" id="trlr_broker" placeholder="Nome da Transportadora" readonly />
    <input type="text" id="driver_nam" placeholder="Nome do Motorista" readonly />
    <input type="text" id="driver_lic_num" placeholder="Carteira do Motorista" readonly />
    <input type="text" id="trlr_typ" placeholder="Tipo do Veículo" readonly />
    <input type="text" id="nottxt" placeholder="Comentário" readonly />
    <input type="text" id="yard_loc" placeholder="Doca" readonly />
    <input type="text" id="tractor_num" placeholder="Pager" readonly />
    <input type="text" id="trlr_seal1" placeholder="Lacre 1" readonly />
    <input type="text" id="trlr_seal2" placeholder="Lacre 2" readonly />
  

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Placa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .header {
            background-color: #f6c200;
            padding: 20px;
            text-align: center;
            color: #000;
            border-bottom: 3px solid #d84f26;
        }
        .btn-dhl {
            background-color: #d84f26;
            color: #fff;
        }
        .btn-dhl:hover {
            background-color: #b6391e;
        }
        .result-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .inspection-questions label {
            font-weight: bold;
        }
        .form-control:readonly {
            background-color: #f7f7f7;
            opacity: 1; /* Para garantir que o fundo fique visível */
        }
    </style>
    <script>
        function pesquisar() {
            const invnum = document.getElementById('invnum').value;

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

            fetch('consulta.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `invnum=${encodeURIComponent(invnum)}`
            })
            .then(response => response.json())
            .then(data => {
                console.log('Dados retornados:', data);
                if (data.length > 0) {
                    const result = data[0];
                    resultadoInputs.trlr_num.value = result.trlr_num || 'N/A';
                    resultadoInputs.invnum.value = result.invnum || 'N/A';
                    resultadoInputs.trlr_broker.value = result.trlr_broker || 'N/A';
                    resultadoInputs.driver_nam.value = result.driver_nam || 'N/A';
                    resultadoInputs.driver_lic_num.value = result.DRIVER_LIC_NUM || 'N/A';
                    resultadoInputs.trlr_typ.value = result.trlr_typ || 'N/A';
                    resultadoInputs.nottxt.value = result.NOTTXT || 'N/A';
                    resultadoInputs.yard_loc.value = result.YARD_LOC || 'N/A';
                    resultadoInputs.tractor_num.value = result.TRACTOR_NUM || 'N/A';
                    resultadoInputs.trlr_seal1.value = (result.TRLR_SEAL1 === 'NA') ? 'N/A' : result.TRLR_SEAL1;
                    resultadoInputs.trlr_seal2.value = (result.TRLR_SEAL2 === 'NA') ? 'N/A' : result.TRLR_SEAL2;
                    resultadoInputs.trlr_seal3.value = (result.TRLR_SEAL3 === 'NA') ? 'N/A' : result.TRLR_SEAL3;
                } else {
                    Object.values(resultadoInputs).forEach(input => input.value = 'N/A');
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

    <header class="header">
        <h1>Pesquisa de Placa</h1>
    </header>

    <div class="container mt-5">
        <div class="form-group">
            <input type="text" class="form-control" id="invnum" placeholder="Digite o número da nota" />
            <button class="btn btn-dhl mt-3" onclick="pesquisar()">Pesquisar</button>
        </div>

        <div class="result-container mt-4">
            <h2 class="text-center">Resultados da Pesquisa</h2>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="trlr_num" placeholder="Placa do Veículo" readonly />
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="invoice" placeholder="Invoice" readonly />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="trlr_broker" placeholder="Nome da Transportadora" readonly />
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="driver_nam" placeholder="Nome do Motorista" readonly />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="driver_lic_num" placeholder="Carteira do Motorista" readonly />
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="trlr_typ" placeholder="Tipo do Veículo" readonly />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="nottxt" placeholder="Comentário" readonly />
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="yard_loc" placeholder="Doca" readonly />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="tractor_num" placeholder="Pager" readonly />
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="trlr_seal1" placeholder="Lacre 1" readonly />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="trlr_seal2" placeholder="Lacre 2" readonly />
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="trlr_seal3" placeholder="Lacre 3" readonly />
                </div>
            </div>
        </div>

        <div class="inspection-questions mt-4">
            <h2 class="text-center">Perguntas de Inspeção</h2>
            <form>
                <div class="form-group">
                    <label>1. O veículo está em boas condições?</label>
                    <div>
                        <label class="mr-3"><input type="radio" name="questao1" value="sim"> Sim</label>
                        <label><input type="radio" name="questao1" value="nao"> Não</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>2. Todos os lacres estão intactos?</label>
                    <div>
                        <label class="mr-3"><input type="radio" name="questao2" value="sim"> Sim</label>
                        <label><input type="radio" name="questao2" value="nao"> Não</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>3. A documentação está em ordem?</label>
                    <div>
                        <label class="mr-3"><input type="radio" name="questao3" value="sim"> Sim</label>
                        <label><input type="radio" name="questao3" value="nao"> Não</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>4. O motorista possui a habilitação correta?</label>
                    <div>
                        <label class="mr-3"><input type="radio" name="questao4" value="sim"> Sim</label>
                        <label><input type="radio" name="questao4" value="nao"> Não</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>5. O veículo possui o seguro necessário?</label>
                    <div>
                        <label class="mr-3"><input type="radio" name="questao5" value="sim"> Sim</label>
                        <label><input type="radio" name="questao5" value="nao"> Não</label>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

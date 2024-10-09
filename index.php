<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include 'Configuracoes/headgerais.php';
        renderHead("Usuários");
    ?>
    
    <style>
        /* Estilo da sobreposição de carregamento */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none; /* Inicialmente escondido */
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Fica acima de outros elementos */
        }
        .loading-text {
            font-size: 20px;
            color: #333;
        }
    </style>
</head>
<body>
<div id="global-loader">
    <div class="whirly-loader"></div>
</div>

<div id="loadingOverlay">
    <div class="loading-text">Carregando...</div>
</div>

<div class="main-wrapper">
    <!-- Header -->
    <?php include 'Configuracoes/header.php'; ?>
    <!-- /Header -->

    <!-- Sidebar -->
    <?php include 'Configuracoes/menulateral.php'; ?>
    <!-- /Sidebar -->

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Cadastrar</h4>
                    <h6>Cadastre um novo EPI</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form id="epiForm" enctype="multipart/form-data">
                        <!-- Campo CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '', ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Digite a Invoice / Placa</label>
                                    <input type="text" id="invnum" name="invnum" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" onclick="pesquisar()"> Pesquisar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form id="epiForm" enctype="multipart/form-data">
                        <!-- Campo CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '', ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="row">
                            <!-- Campos de entrada para os dados do veículo -->
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Placa do veículo</label>
                                    <input type="text" id="trlr_num" name="trlr_num" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- Adicione os outros campos conforme necessário... -->
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Lacre 3</label>
                                    <input type="text" id="trlr_seal3" name="trlr_seal3" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulário de Auditoria -->
            <div class="card">
                <div class="card-body">
                    <h4>Auditoria de Veículo</h4>
                    <form id="auditoriaForm">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12 question-wrapper">
                                <div class="form-group">
                                    <label>1. O veículo está em boas condições de funcionamento?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="q1" value="sim" id="q1-sim">
                                        <label class="form-check-label" for="q1-sim">Sim</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="q1" value="nao" id="q1-nao">
                                        <label class="form-check-label" for="q1-nao">Não</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Adicione as outras perguntas conforme necessário... -->
                            <div class="col-lg-12">
                                <div class="form-group d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Enviar Auditoria</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
    include 'Configuracoes/scriptsgerais.php';
?>

<script>
function pesquisar() {
    event.preventDefault(); // Impede o envio do formulário
    document.getElementById('loadingOverlay').style.display = 'flex'; // Mostra a sobreposição

    const invnum = document.getElementById('invnum').value;

    fetch('consultar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'invnum=' + encodeURIComponent(invnum)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingOverlay').style.display = 'none'; // Esconde a sobreposição
        if (data.error) {
            alert(data.error);
        } else if (data.length > 0) {
            // Preenche os inputs com os dados retornados
            const item = data[0];
            document.getElementById('trlr_num').value = item.trlr_num || 'N/A';
            document.getElementById('invoice').value = item.invnum || 'N/A';
            document.getElementById('trlr_broker').value = item.trlr_broker || 'N/A';
            document.getElementById('driver_nam').value = item.driver_nam || 'N/A';
            document.getElementById('driver_lic_num').value = item.DRIVER_LIC_NUM || 'N/A';
            document.getElementById('trlr_typ').value = item.trlr_typ || 'N/A';
            document.getElementById('nottxt').value = item.NOTTXT || 'N/A';
            document.getElementById('yard_loc').value = item.YARD_LOC || 'N/A';
            document.getElementById('tractor_num').value = item.TRACTOR_NUM || 'N/A';
            document.getElementById('trlr_seal1').value = (item.TRLR_SEAL1 === 'NA' ? 'N/A' : item.TRLR_SEAL1) || 'N/A';
            document.getElementById('trlr_seal2').value = (item.TRLR_SEAL2 === 'NA' ? 'N/A' : item.TRLR_SEAL2) || 'N/A';
            document.getElementById('trlr_seal3').value = (item.TRLR_SEAL3 === 'NA' ? 'N/A' : item.TRLR_SEAL3) || 'N/A';
        }
    })
    .catch(error => {
        document.getElementById('loadingOverlay').style.display = 'none'; // Esconde a sobreposição
        console.error('Erro:', error);
    });
}
</script>

</body>
</html>

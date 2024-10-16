<?php

// Proteção contra XSS
// Função para escapar caracteres especiais em HTML. Isso ajuda a prevenir ataques Cross-Site Scripting (XSS) ao garantir que caracteres especiais em strings não sejam interpretados como código HTML.
function escape_html($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include 'Configuracoes/headgerais.php';
        renderHead("Check-list de veículo");
    ?>

    <style>
        .pagination {
            display: flex;
            justify-content: end;
            margin-top: 20px;
        }
        .signature-wrapper {
            border: 2px solid #ccc;
            border-radius: 5px;
            position: relative;
            display: none;
            padding: 10px;
            width: 100%;
        }
        .signature-pad {
            width: 100%;
            height: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .icon-btn {
            position: relative; /* Para posicionar a tooltip corretamente */
            margin-left: 10px;
            width: 30px; /* Tamanho do círculo */
            height: 30px; /* Tamanho do círculo */
            border-radius: 50%;
            border: 1px solid #ddd;
            background-color: #fff;
            transition: background-color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .icon-btn i {
            color: orange;
            font-size: 16px; /* Tamanho do ícone */
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }
        .icon-btn:hover {
            background-color: #f0f0f0;
        }
        .dataTables_filter {
    display: none;
}

    </style>
</head>
<body>
<div id="global-loader">
    <div class="whirly-loader"></div>
</div>

<div class="main-wrapper">
    <!-- Header -->
    <?php include 'Configuracoes/header.php'; ?>
    <!-- /Header -->

    <!-- Sidebar -->
    <?php include 'Configuracoes/menulateral.php'; ?>
    <!-- /Sidebar -->

<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; text-align:center; padding-top:20%;">
    <div style="color:white; font-size:20px;">Carregando...</div>
</div>


    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Auditoria</h4>
                    <h6>Relatório de auditoria de inbound</h6>
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
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Placa do veículo</label>
                                    <input type="text" id="trlr_num" name="trlr_num" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Invoice</label>
                                    <input type="text" id="invoice" name="invoice" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Transportadora</label>
                                    <input type="text" id="trlr_broker" name="trlr_broker" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Motorista</label>
                                    <input type="text" id="driver_nam" name="driver_nam" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Carteira do motorista</label>
                                    <input type="text" id="driver_lic_num" name="driver_lic_num" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Tipo do veículo</label>
                                    <input type="text" id="trlr_typ" name="trlr_typ" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Comentário</label>
                                    <input type="text" id="nottxt" name="nottxt" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Doca</label>
                                    <input type="text" id="yard_loc" name="yard_loc" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Pager</label>
                                    <input type="text" id="tractor_num" name="tractor_num" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Lacre 1</label>
                                    <input type="text" id="trlr_seal1" name="trlr_seal1" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="codigoEpi"> Lacre 2</label>
                                    <input type="text" id="trlr_seal2" name="trlr_seal2" class="form-control" readonly>
                                </div>
                            </div>

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

            <style>
    .card-body {
        padding: 20px; /* Ajuste o padding do card body */
    }

    .question-wrapper {
        background-color: #f8f9fa; /* Cinza claro */
        padding: 15px; /* Espaçamento interno */
        border-radius: 5px; /* Cantos arredondados */
        margin-bottom: 15px; /* Espaçamento entre perguntas */
        margin-left: 15px;
        width: calc(100% - 30px); /* Largura total menos as margens */
        box-sizing: border-box; /* Inclui padding e border no cálculo da largura */
    }
</style>

<div class="card">
    <div class="card-body">
        <h4>Auditoria de Veículo</h4>
        <form id="auditoriaForm">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12 question-wrapper">
                    <div class="form-group">
                        <label>1. O veículo está calçado corretamente?</label>
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

                <div class="col-lg-12 col-sm-12 col-12 question-wrapper">
                    <div class="form-group">
                        <label>2. O motorista entregou a chave do veículo?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" value="sim" id="q2-sim">
                            <label class="form-check-label" for="q2-sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" value="nao" id="q2-nao">
                            <label class="form-check-label" for="q2-nao">Não</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12 col-12 question-wrapper">
                    <div class="form-group">
                        <label>3. O veículo está com mal cheiro?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q3" value="sim" id="q3-sim">
                            <label class="form-check-label" for="q3-sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q3" value="nao" id="q3-nao">
                            <label class="form-check-label" for="q3-nao">Não</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- User Table -->
<div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="assets/img/icons/filter.svg" alt="img">
                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                </a>
                            </div>
                            <div>
                                <input type="text" class="form-control" id="global_search" placeholder="Buscar na tabela...">
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a id="excelButton" data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" id="filter_nome" placeholder="Digite o nome">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" id="filter_email" placeholder="Digite o e-mail">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" id="filter_status" placeholder="Digite o status">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" id="filter_data_criacao" class="datetimepicker cal-icon" placeholder="Escolha a data de criação">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto" id="apply_filters"><img src="assets/img/icons/search-whites.svg" alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>
                                    <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                    </label>
                                    </th>
                                    <th>LPN</th>
                                    <th>SKU</th>
                                    <th>Local</th>
                                    <th>Lote</th>
                                    <th>Quantidade</th>
                                    <th>Status Rec</th>
                                    <th>Data de venc</th>
                                    <th>Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                            
</tbody>

                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="pagination-container">
                    <ul class="pagination">
                            <!-- Links de página serão adicionados dinamicamente -->
                        </ul>
                    </div>
                    
                </div>
            </div>


            <div class="card">
    <div class="card-body">
        <h4>Auditoria de Veículo</h4>
        <form id="auditoriaForm">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12 question-wrapper">
                    <div class="form-group">
                        <label>4. O assoalho apresenta condições de carregamento?</label>
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

                <div class="col-lg-12 col-sm-12 col-12 question-wrapper">
                    <div class="form-group">
                        <label>5. O veículo está limpo?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" value="sim" id="q2-sim">
                            <label class="form-check-label" for="q2-sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" value="nao" id="q2-nao">
                            <label class="form-check-label" for="q2-nao">Não</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12 col-12 question-wrapper">
                    <div class="form-group">
                        <label>6. Há furos na lateral e/ou teto?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q3" value="sim" id="q3-sim">
                            <label class="form-check-label" for="q3-sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q3" value="nao" id="q3-nao">
                            <label class="form-check-label" for="q3-nao">Não</label>
                        </div>
                    </div>
                </div>

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

<!-- Adicionar o estilo CSS -->
<style>
    .modal-content {
        background: #fff;
    }
    .modal-header {
        background: #fff;
        border-bottom: 1px solid #dee2e6;
    }
    .modal-title {
        font-weight: 600;
    }
    .modal-body {
        text-align: center;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .img-fluid {
        max-height: 80vh; /* Ajuste o valor conforme necessário */
        object-fit: contain;
    }
</style>
        
<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/js/jquery.slimscroll.min.js"></script>

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>

<script src="assets/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/select2/js/select2.min.js"></script>

<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script src="assets/js/script.js"></script>


<script>
$(document).ready(function() {
    // Função para inicializar o DataTable
    function inicializarDataTable() {
        const table = $('#userTable').DataTable({
            paging: false,
            searching: true,
            info: true,
            lengthChange: false,
            pageLength: 10,
            language: {
                paginate: {
                    previous: "Anterior",
                    next: "Próximo"
                },
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "Nenhum registro encontrado",
                emptyTable: "Nenhum dado disponível na tabela",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totais)"
            }
        });

        // Evento de busca customizado
        $('#global_search').on('keyup', function() {
            table.search(this.value).draw();
        });
    }

    // Função para carregar dados na tabela
    function loadData(invnum) {

        fetch('teste.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'invnum=' + encodeURIComponent(invnum)
        })
        .then(response => response.json())
        .then(data => {
            var tbody = $('#userTable tbody');
            tbody.empty();

            let currentSKU = null;
            let totalExpected = 0;
            let totalReceived = 0;
            let description = '';

            // Verifica se a resposta contém erro
            if (data.error) {
                Swal.fire("Erro", data.error, "error");
                return;
            }

            // Verifica se há dados
            if (data.length === 0) {
                Swal.fire("Alerta", "Não há relatório para esta busca.", "warning");
                return;
            }

            $.each(data, function(index, row) {
                if (index === 0) return; // Ignora a primeira linha (cabeçalho)

                const sku = row[1]; // SKU
                const quantidade = parseInt(row[4]); // QUANTIDADE
                const status = row[5]; // STATUS
                const local = row[2]; // LOCAL
                const lote = row[3]; // LOTE
                const dataVencimento = row[6]; // DATA VENCIMENTO
                
                // Se mudamos de SKU, adicionamos a linha de totais
                if (currentSKU && currentSKU !== sku) {
                    tbody.append(`
                        <tr style="background-color: #f2f0f0">
                            <td><label class="checkboxs" style="display: none"><input type="checkbox"><span class="checkmarks"></span></label></td>
                            <td><strong>Descrição do SKU:</strong> ${description}</td>
                            <td><strong>Total esperado:</strong> ${totalExpected}</td>
                            <td><strong>Total recebido:</strong> ${totalReceived}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    `);
                    
                    // Resetar totais
                    totalExpected = 0;
                    totalReceived = 0;
                }

                // Atualizar o SKU atual e somar as quantidades
                currentSKU = sku;
                description = row[12]; // DESCRIÇÃO DO SKU
                totalExpected = row[9]; // TOTAL ESPERADO
                totalReceived = row[10]; // TOTAL RECEBIDO
                // Adicionar linha do item
                tbody.append(`
                    <tr>
                        <td><label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label></td>
                        <td>${row[0]}</td>
                        <td>${sku}</td>
                        <td>${local}</td>
                        <td>${lote}</td>
                        <td>${quantidade}</td>
                        <td>${status}</td>
                        <td>${dataVencimento}</td>
                        <td class="text-center">
                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="si si-user me-2" style="font-size: 20px;"></i>Adicionar comentário
                                </a>
                            </div>
                        </td>
                    </tr>
                `);
            });

            // Adicionar a última linha de totais
            if (currentSKU) {
                tbody.append(`
                    <tr style="background-color: #f2f0f0">
                        <td><label class="checkboxs" style="display: none"><input type="checkbox"><span class="checkmarks"></span></label></td>
                        <td><strong>Descrição do SKU:</strong> ${description}</td>
                        <td><strong>Total esperado:</strong> ${totalExpected}</td>
                        <td><strong>Total recebido:</strong> ${totalReceived}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                `);
            }

            inicializarDataTable(); // Inicializa o DataTable após preencher os dados
        })
        .catch(error => {
            console.error("Erro ao carregar os dados: " + error);
        })
        .finally(() => {
            $('#global-loader').hide();
        });
    }

    // Função de busca
    window.pesquisar = function() {
        event.preventDefault(); // Impede o envio do formulário

        // Limpa os inputs antes de realizar a consulta
        const inputs = [
            'trlr_num', 
            'invoice', 
            'trlr_broker', 
            'driver_nam', 
            'driver_lic_num', 
            'trlr_typ', 
            'nottxt', 
            'yard_loc', 
            'tractor_num', 
            'trlr_seal1', 
            'trlr_seal2', 
            'trlr_seal3'
        ];

        inputs.forEach(id => {
            document.getElementById(id).value = ''; // Limpa cada input
        });

        // Limpa a tabela
        $('#userTable tbody').empty(); // Limpa o conteúdo da tabela
        if ($.fn.DataTable.isDataTable('#userTable')) {
            $('#userTable').DataTable().clear().destroy();
        }

        const invnum = document.getElementById('invnum').value; // invoice é o invnum

        // Mostra o overlay
        $('#global-loader').show();

        fetch('consultar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'invnum=' + encodeURIComponent(invnum)
        })
        .then(response => response.json())
        .then(data => {
            // Esconde o overlay ao receber a resposta
            $('#global-loader').hide();

            if (data.error) {
                Swal.fire("Erro", data.error, "error");
            } else if (data.length > 0) {
                // Preenche os inputs com os dados retornados
                const item = data[0];
                document.getElementById('trlr_num').value = item.TRLR_NUM || 'N/A';
                document.getElementById('invoice').value = item.INVNUM || 'N/A';
                document.getElementById('trlr_broker').value = item.TRLR_BROKER || 'N/A';
                document.getElementById('driver_nam').value = item.DRIVER_NAM || 'N/A';
                document.getElementById('driver_lic_num').value = (item.DRIVER_LIC_NUM === 'NA' ? 'N/A' : item.DRIVER_LIC_NUM) || 'N/A';
                document.getElementById('trlr_typ').value = item.TRLR_TYP || 'N/A';
                document.getElementById('nottxt').value = item.NOTTXT || 'N/A';
                document.getElementById('yard_loc').value = item.YARD_LOC || 'N/A';
                document.getElementById('tractor_num').value = item.TRACTOR_NUM || 'N/A';
                document.getElementById('trlr_seal1').value = (item.TRLR_SEAL1 === 'NA' ? 'N/A' : item.TRLR_SEAL1) || 'N/A';
                document.getElementById('trlr_seal2').value = (item.TRLR_SEAL2 === 'NA' ? 'N/A' : item.TRLR_SEAL2) || 'N/A';
                document.getElementById('trlr_seal3').value = (item.TRLR_SEAL3 === 'NA' ? 'N/A' : item.TRLR_SEAL3) || 'N/A';

                loadData(invnum)

            } else {
                // Mostra um alerta caso não haja resultados
                Swal.fire("Alerta", "Não há relatório para esta busca.", "warning");
            }
        })
        .catch(error => {
            // Esconde o overlay em caso de erro
            document.getElementById('overlay').style.display = 'none';
            console.error('Erro:', error);
            Swal.fire("Erro", "Ocorreu um erro ao consultar os dados.", "error");
        });
    };
});
</script>

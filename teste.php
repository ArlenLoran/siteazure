


<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include 'Configuracoes/headgerais.php';
        renderHead("Usuários");
    ?>

<style>
        .pagination {
            display: flex;
            justify-content: end;
            margin-top: 20px; /* Espaço entre a paginação e a tabela */
        }
    </style>

    <style>
.dataTables_filter {
    display: none; /* Oculta o campo de busca padrão do DataTable */
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

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lista de Usuários</h4>
                    <h6>Gerenciamento de usuários cadastrados</h6>
                </div>
                <!--
                <div class="page-btn">
                    <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#cadastrarusuariomodal">
                        <img src="assets/img/icons/plus.svg" alt="img"> Cadastrar Usuário
                    </button>
                </div>-->
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
        </div>
    </div>
    <!-- /Page Wrapper -->
</div>


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
    // Função para carregar dados na tabela
    function loadData() {
        $.ajax({
            url: 'tabela.php', // Substitua pelo caminho do seu script PHP
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var tbody = $('#userTable tbody');
                tbody.empty(); // Limpa a tabela antes de adicionar novos dados

                // Adiciona os dados recebidos à tabela
                $.each(data, function(index, row) {
                    if (index === 0) return; // Ignora a primeira linha (cabeçalho)

                    var tr = $('<tr></tr>');
                    tr.append('<td><label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label></td>');
                    tr.append('<td>' + row[0] + '</td>'); // LPN
                    tr.append('<td>' + row[1] + '</td>'); // Local
                    tr.append('<td>' + row[2] + '</td>'); // Lote
                    tr.append('<td>' + row[3] + '</td>'); // Quantidade
                    tr.append('<td>' + row[6] + '</td>'); // Status Rec
                    tr.append('<td>' + row[8] + '</td>'); // Data de venc
                    tr.append('<td class="text-center">' +
                            '<a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">' +
                                '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu">' +
                                '<a href="javascript:void(0);" class="dropdown-item">' +
                                    '<i class="si si-user me-2" style="font-size: 20px;"></i>Adicionar comentário' +
                                '</a>' +
                            '</div>' +
                        '</td>' +
                        '</tr>'); // Botão de detalhes

                    tbody.append(tr);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erro ao carregar os dados: " + error);
            }
        });
    }

    // Carregar os dados na tabela ao iniciar a página
    loadData();
});
</script>





</body>
</html>

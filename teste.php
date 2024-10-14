


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
<!-- Modal de Edição de Usuário -->
<div class="modal fade" id="editarusuariomodal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="editarusuarioform" action="Telas/ScriptsUsuarios/editarusuario.php" method="POST">
                    <input type="hidden" id="edit_user_id" name="edit_user_id">
                    <input type="hidden" id="edit_user_admin" name="edit_user_admin">

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="edit_user_nome">Nome</label>
                                <input type="text" class="form-control" id="edit_user_nome" name="edit_user_nome" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="edit_user_email">E-mail</label>
                                <input type="email" class="form-control" id="edit_user_email" name="edit_user_email" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="edit_user_status">Status</label>
                                <select class="form-select" id="edit_user_status" name="edit_user_status" required>
                                    <option value="APROVADO">Aprovado</option>
                                    <option value="REPROVADO">Reprovado</option>
                                    <option value="PENDENTE">Pendente</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="edit_user_nivel">Nível de acesso</label>
                                <select class="form-select" id="edit_user_nivel" name="edit_user_nivel" required>
                                    <option value="USUÁRIO">Usuário</option>
                                    <option value="LIDERANÇA">Liderança</option>
                                    <option value="OMS">OMS</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="edit_user_op">Operação</label>
                                <select class="form-select" id="edit_user_op" name="edit_user_op" required>
                                    <option value="Embu">Embu</option>
                                    <option value="Itupeva">Itupeva</option>
                                    <option value="Viana">Viana</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal de Cadastro de Usuário -->
<div class="modal fade" id="cadastrarusuariomodal" tabindex="-1" aria-labelledby="cadastrarUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Adicionando a classe modal-lg para tornar o modal mais largo -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastrarUserModalLabel">Cadastrar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Formulário para cadastrar usuário -->
            <form id="cadastrarusuarioform" method="POST">
                <div class="modal-body">
                    <div class="row"> <!-- Usando uma row do Bootstrap para colocar dois inputs por linha -->
                        <div class="col-md-6"> <!-- Coluna para o campo Nome -->
                            <div class="mb-3">
                                <label for="nomecadastro" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nomecadastro" name="nomecadastro" required>
                            </div>
                        </div>
                        <div class="col-md-6"> <!-- Coluna para o campo E-mail -->
                            <div class="mb-3">
                                <label for="emailcadastro" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="emailcadastro" name="emailcadastro" required>
                            </div>
                        </div>
                    </div>
                    <div class="row"> <!-- Nova row para os campos de Senha -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="senhacadastro" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senhacadastro" name="senhacadastro" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirmarsenhacadastro" class="form-label">Confirmar Senha</label>
                                <input type="password" class="form-control" id="confirmarsenhacadastro" name="confirmarsenhacadastro" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end w-100"> <!-- Div para alinhar botões à direita -->
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="botaocadastrar" class="btn btn-primary">Cadastrar Usuário</button>
                    </div>
                </div>
            </form>
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
    // Função para inicializar o DataTable
    function inicializarDataTable() {
        if ($.fn.DataTable.isDataTable('#userTable')) {
            $('#userTable').DataTable().destroy();
        }

        const table = $('#userTable').DataTable({
            paging: true,
            searching: true, // Altere para true para habilitar a busca
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
                search: "Buscar:",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totais)"
            }
        });

        // Evento de busca customizado
        $('#global_search').on('keyup', function() {
            table.search(this.value).draw(); // Filtra a tabela com base no valor do campo de busca
        });
    }

    // Função para buscar os dados via AJAX
    function loadTableData() {
        $('#global-loader').show();

        $.ajax({
            url: 'tabela.php', // URL do seu arquivo PHP
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $('tbody').empty();

                $.each(data, function(index, row) {
                    $('tbody').append(
                        '<tr>' +
                        '<td><label class="checkboxs"><input type="checkbox"><span class="checkmarks"></span></label></td>' +
                        '<td>' + row.LODNUM + '</td>' +
                        '<td>' + row.STOLOC + '</td>' +
                        '<td>' + row.LOTNUM + '</td>' +
                        '<td>' + row.RCVQTY + '</td>' +
                        '<td>' + row.RCVSTS + '</td>' +
                        '<td>' + row.EXPIRE_DTE + '</td>' +
                        '<td><a href="#" class="btn btn-info">Ver Detalhes</a></td>' +
                        '</tr>'
                    );
                });

                inicializarDataTable(); // Inicializa o DataTable após preencher os dados
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição: ' + error);
            },
            complete: function() {
                $('#global-loader').hide();
            }
        });
    }

    // Chama a função para carregar os dados quando a página carrega
    loadTableData();
});
</script>

</body>
</html>

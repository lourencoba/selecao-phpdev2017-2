<?php
require_once '../_inc/global.php';

$form = new GForm();

$header = new GHeader('Vacinação');
$header->addLib(array('paginate', 'maskMoney'));
$header->show(false, 'animal_vacina/animal_vacina.php');
// ---------------------------------- Header ---------------------------------//


$html .= '<div id="divTable" class="row">';
$html .= getWidgetHeader();
//<editor-fold desc="Formulário de Filtro">
$html .= $form->open('filter', 'form-inline filterForm');
$html .= $form->addInput('text', 'p__vac_var_nome', false, array('placeholder' => 'Vacina', 'class' => 'sepV_b m-wrap small'), false, false, false);
$html .= $form->addInput('text', 'p__ani_var_nome', false, array('placeholder' => 'Animal', 'class' => 'sepV_b m-wrap small'), false, false, false);
$html .= $form->addInput('text', 'p__pro_var_nome', false, array('placeholder' => 'Proprietário', 'class' => 'sepV_b m-wrap small'), false, false, false);

$html .= getBotoesFiltro();
$html .= getBotaoAdicionar();
$html .= $form->close();
//</editor-fold>

$paginate = new GPaginate('animalVacina', 'animal_vacina_load.php', SYS_PAGINACAO);
$html .= $paginate->get();
$html .= '</div>'; //divTable
$html .= getWidgetFooter();
echo $html;

echo '<div id="divForm" class="row divForm">';
include 'animal_vacina_form.php';
echo '</div>';

// ---------------------------------- Footer ---------------------------------//
$footer = new GFooter();
$footer->show();
?>
<script>
    var pagCrud = 'animal_vacina_crud.php';
    var pagView = 'animal_vacina_view.php';
    var pagLoad = 'animal_vacina_load.php';

    function filtrar(page) {
        animalVacinaLoad('', '', '', $('#filter').serializeObject(), page);
        return false;
    }

    $(function() {
        filtrar(1);
        $('#filter select').change(function() {
            filtrar(1);
            return false;
        });
        $('#filter').submit(function() {
            if ($('#filter').attr('action').length === 0) {
                filtrar(1);
                return false;
            }
        });
        $('#p__btn_limpar').click(function() {
            clearForm('#filter');
            filtrar(1);
        });
        $(document).on('click', '#p__btn_adicionar', function() {
            scrollTop();
            unselectLines();

            showForm('divForm', 'ins', 'Adicionar');
        });

        $(document).on('click', '.l__btn_editar, tr.linhaRegistro td:not([class~="acoes"])', function() {
            var anv_int_codigo = $(this).parents('tr.linhaRegistro').attr('id');

            scrollTop();
            selectLine(anv_int_codigo);

            loadForm(URL_API + 'animalvacinas/' + anv_int_codigo + '/' + API_KEY, function(json) {
                showForm('divForm', 'upd', 'Editar');
            });
        });
        
        $(document).on('click', '.btn_aplicar_vacina', function() {
            var anv_int_codigo = $(this).attr('anv_int_codigo');

            scrollTop();
            
            $.gDisplay.showYN("Confirma a aplicação da vacina?", function() {
                $.gAjax.exec('PUT', URL_API + 'aplicacaovacina/' + anv_int_codigo, false, false, function(json) {
                    if (json.status) {
                        filtrar();
                    }
                });
            });
        });


        $(document).on('click', '.l__btn_excluir', function() {
            var anv_int_codigo = $(this).parents('tr.linhaRegistro').attr('id');

            $.gDisplay.showYN("Quer realmente deletar o item selecionado?", function() {
                $.gAjax.exec('DELETE', URL_API + 'animalvacinas/' + anv_int_codigo + '/' + API_KEY, false, false, function(json) {
                    if (json.status) {
                        filtrar();
                    }
                });
            });
        });
    });
</script>
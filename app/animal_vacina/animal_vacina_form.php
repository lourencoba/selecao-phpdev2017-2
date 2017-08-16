<?php

//------------------------------ Combo dos animais ----------------------------------//
$mysql = new GDbMysql();
$query = "SELECT ani_int_codigo, ani_var_nome FROM vw_animal";
$mysql->execute($query);

$animais = array();
if ($mysql->numRows() > 0) {
    while ($mysql->fetch()) {
        $animais[$mysql->res['ani_int_codigo']] = $mysql->res['ani_var_nome'];
    }
}
//------------------------------ Combo dos animais ----------------------------------//

//------------------------------ Combo das vacinas ----------------------------------//
$mysql = new GDbMysql();
$query = "SELECT vac_int_codigo, vac_var_nome FROM vw_vacina";
$mysql->execute($query);

$vacinas = array();
if ($mysql->numRows() > 0) {
    while ($mysql->fetch()) {
        $vacinas[$mysql->res['vac_int_codigo']] = $mysql->res['vac_var_nome'];
    }
}
//------------------------------ Combo das vacinas ----------------------------------//

//------------------------------ Combo dos usuários ----------------------------------//
$mysql = new GDbMysql();
$query = "SELECT usu_int_codigo, usu_var_nome FROM vw_usuario";
$mysql->execute($query);

$usuarios = array();
if ($mysql->numRows() > 0) {
    while ($mysql->fetch()) {
        $usuarios[$mysql->res['usu_int_codigo']] = $mysql->res['usu_var_nome'];
    }
}
//------------------------------ Combo das usuários ----------------------------------//

$form = new GForm();

//<editor-fold desc="Header">
$title = '<span class="acaoTitulo"></span>';
$tools = '<a id="f__btn_voltar"><i class="fa fa-arrow-left font-blue-steel"></i> <span class="hidden-phone font-blue-steel bold uppercase">Voltar</span></a>';
$htmlForm .= getWidgetHeader($title, $tools);
//</editor-fold>
//<editor-fold desc="Formulário">
$htmlForm .= $form->open('form', 'form-vertical form');
$htmlForm .= $form->addInput('hidden', 'acao', false, array('value' => 'ins', 'class' => 'acao'), false, false, false);
$htmlForm .= $form->addInput('hidden', 'anv_int_codigo', false, array('value' => ''), false, false, false);
$htmlForm .= $form->addSelect('ani_int_codigo', $animais, '', 'Animal*', array('validate' => 'required'), false, false, true, '', 'Selecione...');
$htmlForm .= $form->addSelect('vac_int_codigo', $vacinas, '', 'Vacina*', array('validate' => 'required'), false, false, true, '', 'Selecione...');
$htmlForm .= $form->addDateField('anv_dat_programacao', 'Programação*', false, false, array('dateFormat' => "'dd/mm/yy'"), false, false, false, 'Selecione...');
$htmlForm .= $form->addSelect('usu_int_codigo', $usuarios, '', 'Usuário*', array('validate' => 'required'), false, false, true, '', 'Selecione...');

$htmlForm .= '<div class="form-actions">';
$htmlForm .= getBotoesAcao(true);
$htmlForm .= '</div>';
$htmlForm .= $form->close();
//</editor-fold>
$htmlForm .= getWidgetFooter();

echo $htmlForm;
?>
<script>
    $(function() {
        $('#form').submit(function() {
            var anv_int_codigo = $('#anv_int_codigo').val();
            $('#p__selecionado').val();
            if ($('#form').gValidate()) {
                var method = ($('#acao').val() == 'ins') ? 'POST' : 'PUT';
                var endpoint = ($('#acao').val() == 'ins') ? URL_API + 'animalvacinas' + '/' + API_KEY : URL_API + 'animalvacinas/' + anv_int_codigo + '/' + API_KEY;

                $.gAjax.exec(method, endpoint, $('#form').serializeArray(), false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            }
            return false;
        });

        $('#f__btn_cancelar, #f__btn_voltar').click(function() {
            showList();
            return false;
        });

        $('#f__btn_excluir').click(function() {
            var ani_int_codigo = $('#anv_int_codigo').val();

            $.gDisplay.showYN("Quer realmente deletar o item selecionado?", function() {
                $.gAjax.exec('DELETE', URL_API + 'animalvacinas/' + anv_int_codigo + '/' + API_KEY, false, false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            });
        });
    });
</script>
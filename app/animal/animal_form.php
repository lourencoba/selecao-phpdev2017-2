<?php

//------------------------------ Combo dos proprietários ----------------------------------//
$mysql = new GDbMysql();
$query = "SELECT pro_int_codigo, pro_var_nome FROM vw_proprietario";
$mysql->execute($query);

$proprietarios = array();
if ($mysql->numRows() > 0) {
    while ($mysql->fetch()) {
        $proprietarios[$mysql->res['pro_int_codigo']] = $mysql->res['pro_var_nome'];
    }
}
//------------------------------ Combo dos proprietários ----------------------------------//

//------------------------------ Combo das raças ----------------------------------//
$mysql = new GDbMysql();
$query = "SELECT rac_int_codigo, rac_var_nome FROM vw_raca";
$mysql->execute($query);

$racas = array();
if ($mysql->numRows() > 0) {
    while ($mysql->fetch()) {
        $racas[$mysql->res['rac_int_codigo']] = $mysql->res['rac_var_nome'];
    }
}
//------------------------------ Combo das raças ----------------------------------//

$form = new GForm();

//<editor-fold desc="Header">
$title = '<span class="acaoTitulo"></span>';
$tools = '<a id="f__btn_voltar"><i class="fa fa-arrow-left font-blue-steel"></i> <span class="hidden-phone font-blue-steel bold uppercase">Voltar</span></a>';
$htmlForm .= getWidgetHeader($title, $tools);
//</editor-fold>
//<editor-fold desc="Formulário">
$htmlForm .= $form->open('form', 'form-vertical form');
$htmlForm .= $form->addInput('hidden', 'acao', false, array('value' => 'ins', 'class' => 'acao'), false, false, false);
$htmlForm .= $form->addInput('hidden', 'ani_int_codigo', false, array('value' => ''), false, false, false);
$htmlForm .= $form->addInput('text', 'ani_var_nome', 'Nome*', array('maxlength' => '50', 'validate' => 'required'));
$htmlForm .= $form->addSelect('pro_int_codigo', $proprietarios, '', 'Proprietário*', array('validate' => 'required'), false, false, true, '', 'Selecione...');
$htmlForm .= $form->addSelect('ani_cha_vivo', array('S' => 'Sim', 'N' => 'Não'), '', 'Vivo*', array('validate' => 'required'), false, false, true, '', 'Selecione...');

$htmlForm .= $form->addInput('text', 'ani_dec_peso', 'Peso*', array('maxlength' => '100', 'validate' => 'required'));
$htmlForm .= $form->addSelect('rac_int_codigo', $racas, '', 'Raça*', array('validate' => 'required'), false, false, true, '', 'Selecione...');


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
        $('#ani_dec_peso').maskMoney({thousands:'.', decimal:',', precision:3,  affixesStay: false});

        $('#form').submit(function() {
            var ani_int_codigo = $('#ani_int_codigo').val();
            $('#p__selecionado').val();
            if ($('#form').gValidate()) {
                var method = ($('#acao').val() == 'ins') ? 'POST' : 'PUT';
                var endpoint = ($('#acao').val() == 'ins') ? URL_API + 'animais' + '/' + API_KEY : URL_API + 'animais/' + ani_int_codigo + '/' + API_KEY;

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
            var ani_int_codigo = $('#ani_int_codigo').val();

            $.gDisplay.showYN("Quer realmente deletar o item selecionado?", function() {
                $.gAjax.exec('DELETE', URL_API + 'usuarios/' + ani_int_codigo + '/' + API_KEY, false, false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            });
        });
    });
</script>
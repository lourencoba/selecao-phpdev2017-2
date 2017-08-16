<?php
require_once '_inc/global.php';

$msg = "";

//Caso tenha sido enviado, loga o usuário
if (isset($_POST['usu_var_email'])) { 
    if (GAuth::login($_POST['usu_var_email'], $_POST['usu_var_senha'])) {
        header("Location: ".URL_SYS."index.php");   
    }
    else {
        $msg = '<div class="alert alert-danger">Usuário ou senha inválidos.</div>'; 
    }
}

$header = new GHeaderParent("Login");
$header->show();

$html .= '<meta name="description" content="">';
$html .= '<meta name="author" content="">';

$html .= '<!--[if lt IE 9]> ';
$html .= '<script src="' . URL_SYS_THEME . 'plugins/respond.min.js"></script> ';
$html .= '<script src="' . URL_SYS_THEME . 'plugins/excanvas.min.js"></script> ';
$html .= '<![endif]-->';

// fechar head
$html .= '</head>';
$html .= '<body class="page-md">';
$html .= '<script>var URL_API = "' . URL_API . '";</script>';
$html .= '<div class="page-header">'; 
$html .= '<div class="page-header-top">';
$html .= '<div class="container">';
$html .= '<div class="page-logo">';
$html .= '<a href="' . URL_SYS . 'index.php"><img src="' . URL_SYS_THEME . '_img/logo-simplesvet.png" alt="logo" class="logo-default" /></a>';
$html .= '</div>';
$html .= '<a href="javascript:;" class="menu-toggler"></a>';
$html .= '</div>'; //.container
$html .= '</div>'; //.page-header-top
$html .= '</div>';
$html .= '<div class="page-content">';
$html .= '<div class="container">';
$html .= '<div class="row">';
$html .= $msg;
$html .= '<div class="col-md-6 col-lg-6 col-sm-12 offset-md-6 offset-lg-6" style="padding-top:50px;">';
$form = new GForm();

$html .= $form->open('login');
$html .= $form->addInput('text', 'usu_var_email', 'Login*', array('maxlength' => '100', 'validate' => 'required;email'));
$html .= $form->addInput('password', 'usu_var_senha', 'Senha*', array('maxlength' => '100', 'validate' => 'required'));
$html .= '<input type="submit" value="Logar" class="btn btn-default">';
$html .= $form->close();

$html .= '</div>';
$html .= '</div>';

echo $html;

// ---------------------------------- Footer ---------------------------------//
$footer = new GFooter();
$footer->show();
?>

<script>
$('#login').submit(function() {
    if ($('#login').gValidate()) {
        return true;
    }
    return false;
});
</script>
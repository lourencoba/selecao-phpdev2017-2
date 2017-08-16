<?php

/**
 * Classe de autenticação
 */

class GAuth {

    /*
     * Faz o login do usuário
     * @param string $usu_var_email 
     * @param string $usu_var_senha
     * @return boolean
     */
    public static function login($usu_var_email, $usu_var_senha) {        
        $mysql = new GDbMysql();

        $params = array ('ss', 
            $usu_var_email,
            $usu_var_senha
        );

        $mysql->execute("SELECT usu_int_codigo, usu_var_nome FROM usuario WHERE usu_var_email = ? AND usu_var_senha = MD5(?);", $params, true, MYSQL_ASSOC);
        if ($mysql->fetch()) {
            $ret = $mysql->res;
            //Atribuindo os dados do usuário na sessão
            session_start();
            $_SESSION['usu_int_codigo'] = $ret['usu_int_codigo'];
            $_SESSION['usu_var_nome'] =   $ret['usu_var_nome'];
            $_SESSION['usu_var_email'] =  $usu_var_email;

            $mysql->close();
            return true;
        }

        $mysql->close();
        return false;
    }

    /*
     * Faz o logout
     */
    public static function logout() {
        if (isset($_SESSION['usu_int_codigo']) && !empty($_SESSION['usu_int_codigo'])) {
            unset($_SESSION['usu_int_codigo']);
            unset($_SESSION['usu_var_nome']);
            unset($_SESSION['usu_var_email']);
            session_destroy();
        }
    }

    /*
     * Verifica se o usuário está logado
     *
     * @return boolean
     */
    public static function logado() {
        if (isset($_SESSION['usu_int_codigo']) && !empty($_SESSION['usu_int_codigo'])) {
            return true;
        }

        return false;
    }

}
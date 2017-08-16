<?php
require_once '_inc/global.php';

GAuth::logout();

header("Location: ".URL_SYS."login.php");

?>
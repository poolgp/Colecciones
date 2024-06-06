<?php

session_start();

require_once('../php_librarys/bd.php');

if (isset($_POST['insertCantante'])) {
    insertCantante();
}

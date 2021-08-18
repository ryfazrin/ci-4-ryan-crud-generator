<?php
require 'config.php';

if (@$_SERVER['REQUEST_METHOD'] !== 'POST') die('0');

/*------------------------------------------------
              getTablesByDatabase 
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'getTablesByDatabase') {

    $engine->getTablesByDatabase($_POST);
}

/*------------------------------------------------
              getColumnsByTable 
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'getColumnsByTable') {

    $engine->getColumnsByTable($_POST);

}

/*------------------------------------------------
              getPrimaryColumnsByTable  
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'getPrimaryColumnsByTable') {

    $engine->getPrimaryColumnsByTable($_POST);

}

/*------------------------------------------------
					generate  
--------------------------------------------------*/
if (isset($_POST['act']) && $_POST['act'] === 'generate') {

    $engine->generate($_POST);

}

?>
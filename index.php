<?php
require 'config.php';

$p = isset($_GET['page']) ? $_GET['page'] : '';

$title = 'RYAN CI-4 CRUD Generator';

switch ( $p ) {
  case 'generator':
    $data = array();
    $data['title'] = $title;
    $data['databases'] = $engine->getDatabases();
    $viewLoader->load_template('generator', $data);
    break;

  default:
    $data = array();
	  $data['title'] = $title;
    $viewLoader->load_template('home', $data);
    break;
}
?>

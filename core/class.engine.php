<?php
/**
 * My Ryan CI-4 CRUD Generator
 * Inspired: adel.qusay */ 

 class Engine
 {
    Public $db;

    function __construct($config)
    {
      // $this->config = $config;
      $db = mysqli_connect($config['HOST'], $config['USER'], $config['PASS']);
      if(!$db) die("Database error");

      $this->db = $db;
    }

    // private function for "Create Query"
    Private function createQuery($query)
    {
      return mysqli_query($this->db, $query);
    }

    // Get Databases
    public function getDatabases()
    {
      $result = $this->createQuery("SHOW DATABASES");

      $databaseList = null;

      while ($databases = mysqli_fetch_array($result)) {
        $databaseList[] = $databases[0];
      }

      return $databaseList;
    }

    // Get Table by Database
    public function getTablesByDatabase($_FPOST)
    {
      $_POST = $this->sanitize($_FPOST);

      $result = $this->createQuery("SHOW TABLES FROM ".$_POST['database']);

      $tableListHtml = '<option value="" selected="selected">-- Select --</option>';

      while ($table = mysqli_fetch_array($result)) {
        $tableListHtml .= '<option value="'. $table[0] .'">' . $table[0] . '</option>';
      }

      die($tablesListHtml);
    }

    public function getPrimaryColumnByTable($_FPOST)
    {
      $_POST = $this->sanitize($_FPOST); 
      
      $result = $this->createQuery('SHOW KEYS FROM '.$_POST['table'].' WHERE Key_name = \'PRIMARY\'');

      $primaryColumnsListHtml = '';

      while($column = mysqli_fetch_array($result))
      {
        $primaryColumnsListHtml .= '<option value="' .trim($column['Column_name']).'">' . trim($column['Column_name']).'</option>';
      }

      die ($primaryColumnsListHtml);
    }

    public function getColumnsByTable()
    {
      # code...
    }

    public function generate()
    {
      # code...
    }

    //  ===================

    public function getBetween()
    {
      # code...
    }

    public function snakeToCamel()
    {
      # code...
    }

    public function colToLabel()
    {
      # code...
    }

    public function sanitize()
    {
      # code...
    }
 }
 
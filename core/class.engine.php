<?php
/**
 * My Ryan CI-4 CRUD Generator
 * Inspired: adel.qusay */ 

 class Engine
 {
   Public $config;

   function __construct($config)
   {
     $this->config = $config;
   }

   public function getDatabases()
   {
     $db = mysqli_connect($this->config['HOST'], $this->config['USER'], $this->config['PASS']);

     if(!db) die("Database error");

     $result = mysqli_query($db, "show DATABASES");

     $databaseList = null;

     while ($databases = mysqli_fetch_array($result)) {
       $databaseList[] = $databases[0];
     }

     return $databaseList;
   }

   public function getTablesByDatabase()
   {
     # code...
   }

   public function getPrimaryColumnByTable()
   {
     # code...
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
 
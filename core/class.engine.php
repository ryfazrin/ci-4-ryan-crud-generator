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

    // Get Primary Column
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

    // Get All Column
    public function getColumnsByTable($_FPOST)
    {
      $_POST = $this->sanitize($_FPOST);

      $result = $this->createQuery("DESC ".$_POST['table']);
      $pkResult = mysqli_fetch_array($this->createQuery('SHOW KEYS FROM '.$_POST['table'].' WHERE Key_name = \'PRIMARY\''));

      $columnsListHtml = '<ul class="list-group>';

      while ($column = mysqli_fetch_array($result)) {
        $disabled = ( $column[0] == trim($pkResult['Column_name']))? 'disabled' : '';
        $columnsListHtml .= '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"><div class="row">
          <input type="text" name="column[]" id="column" class="form-control" value="'.$column[0].'" placeholder="" maxlength="50" hidden>
          <div class="col-md-2">
            <div class="form-group">
              <label for="label" class="form-label">Label:</label>
              <input type="text" name="label[]" id="label" class="form-control" value="'.$this->colToLabel($column[0]).'" placeholder="" maxlength="50" required>
            </div>
          </div>	
          <div class="col-md-2">
            <div class="form-group">
              <label for="name" class="form-label">Name/ID:</label>
              <input type="text" name="name[]" id="name" class="form-control" value="'.$this->snakeToCamel($column[0]).'" placeholder="" maxlength="50" required>
            </div>
          </div>	
          <div class="col-md-2">
            <div class="form-group">
              <label for="iType" class="form-label">Input type:</label>
              <select class="form-control" name="iType[]" id="iType">
                <option value="1" '.(strpos($column[1], 'var') !== false ? 'selected="selected"' : "").'>Text field</option>
                <option value="2" '.(strpos($column[1], 'int') !== false ? 'selected="selected"' : "").'>Number field</option>
                <option value="3" '.(strpos($column[0], 'pass') !== false ? 'selected="selected"' : "").'>Password field</option>
                <option value="4">Email field</option>
                <option value="5" '.(strpos($column[1], 'text') !== false ? 'selected="selected"' : "").'>Text area</option>
                <option value="6">Select</option>
                <option value="7" '.(strpos($column[1], 'date') !== false ? 'selected="selected"' : "").'>Date</option>
              </select>
            </div>
          </div>									
          <div class="col-md-2">
            <div class="form-group">
              <label for="maxlength" class="form-label">Max length:</label>
              <input type="number" name="maxlength[]" id="maxlength" class="form-control" value="'. $this->getBetween($column[1], '(', ')').'" placeholder="" number="true" maxlength="50">
            </div>
          </div>							
          <div class="col-md-2">
            <div class="form-group">
              <label for="required" class="form-label">Required:</label>
              <select class="form-control" name="required[]" id="required" required>
                <option value="1" '.(strpos($column[2], 'NO') !== false ? 'selected="selected"' : "").'>Yes</option>
                <option value="0" '.(strpos($column[2], 'YES') !== false ? 'selected="selected"' : "").'>No</option>
              </select>
            </div>
          </div>	
          <div class="col-md-1">
            <div class="form-group">
              <label for="dtShow" class="form-label">DT:</label>
              <select class="form-control" name="dtShow[]" id="dtShow" required>
                <option value="1" selected>Y</option>
                <option value="0">N</option>
              </select>
            </div>
          </div>
          <div class="col-md-1">
            <div class="form-group">
              <a class="btn btn-danger mt-4 '.$disabled.'" href="#"><i class="fa fa-trash"></i></a>
            </div>
          </div>
        </div>
        </li>';
      }

      die($columnsListHtml.'</ul>');
    }

    public function generate($_FPOST)
    {
      
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
 
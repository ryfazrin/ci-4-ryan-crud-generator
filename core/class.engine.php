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
      $_POST = $this->sanitize($_FPOST);
      
      $crudTitle = $_POST['crudTitle'];
      $controlerName = lcfirst(preg_replace("/[^A-Za-z0-9]/", "", $_POST['crudName']));
      $uControlerName = ucfirst($controlerName);
      $modelName = $controlerName.'Model';
      $uModelName = ucfirst($modelName);
      $crudName = $_POST['crudName'];
      $table = $_POST['table'];
      $primaryKey = $_POST['primaryKey'];
      $column = $_POST['column'];
      $label = $_POST['label'];
      $name = $_POST['name'];
      $iType = $_POST['iType'];
      $maxlength = $_POST['maxlength'];
      $required = $_POST['required'];
      $dtShow = $_POST['dtShow'];
      $response = array();
      $htmlInputs = '                        <div class="row">'."\n";
      $ciSelect = '';
      $ciFields = '';
      $ciValidation = '';
      $ciDataTable = '';
      $htmlDataTable = '';
      $allowedFields = '';
      $htmlEditFields = '';

      // filter null input required fields
      if (!isset($crudName) || $crudName == '' ||
          !isset($crudTitle) || $crudTitle == '' ||
          !isset($table) || $table == '' ||
          !isset($primaryKey) || $primaryKey == '')
      {
        $response['success'] = FALSE;
        $response['message'] = 'Please fill all required fields.';

        die(json_encode($response));
      }

      // generate Input type
      for ($i=0; $i < count($column); $i++) { 
        $inputLabel = (isset($label[$i]) AND $label[$i] != '')? $label[i] : '';
        $inputName = (isset($name[$i]) AND $name[$i] != '')? $name[i] : '';
        $inputMaxlength = (isset($maxlength[$i]) AND $maxlength[$i] != '')? ' maxlength="'.$maxlength[$i].'"' : '';
        $inputRequired = (isset($required[$i]) AND $required[$i] == 1)? 'required' : '';
        $htmlInputRequired = (isset($required[$i]) AND $required[$i] == 1)? '<span class="text-danger">*</span> ' : '';
        $crudShow = (isset($name[$i]) AND $name[$i] != '')? 1 : 0;
        $ciValidationMaxLength = (isset($maxlength[$i]) AND $maxlength[$i] != '')? '|max_length['.$maxlength[$i].']' : '';
        $ciValidationRequired = (isset($required[$i]) AND $required[$i] == 1)? 'required' : 'permit_empty';
        $ciValidationType = '';

        // find type field
        if ($column[$i] == trim($primaryKey)) {
          $htmlInputs .= ' 							<input type="hidden" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputLabel.'" '.$inputMaxlength.' '.$inputRequired.'>'."\n";
          $ciValidationType = '|numeric';

        } elseif ($iType[$i] == '1' && $crudShow == '1') {
          $htmlInputs .= '              <div class="col-md-4">
                <div class="form-group">
	                <label for="'.$inputName.'"> '.$inputLabel.': '.$htmlInputRequired.'</label>
                  <input type="text" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputLabel.'" '.$inputMaxlength.' '.$inputRequired.'>
                </div>
              </div>'."\n";
        } elseif ($iType[$i] == '2' && $crudShow == '1') {
          $htmlInputs .= '              <div class="col-md-4">
                <div class="form-group">
	                <label for="'.$inputName.'"> '.$inputLabel.': '.$htmlInputRequired.'</label>
                  <input type="number" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputLabel.'" '.$inputMaxlength.' number="true" '.$inputRequired.'>
                </div>
              </div>'."\n";
        } elseif ($iType[$i] == '3' && $crudShow == '1') {
          $htmlInputs .= '              <div class="col-md-4">
                <div class="form-group">
	                <label for="'.$inputName.'"> '.$inputLabel.': '.$htmlInputRequired.'</label>
                  <input type="password" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputLabel.'" '.$inputMaxlength.' '.$inputRequired.'>
                </div>
              </div>'."\n";
        } elseif ($iType[$i] == '4' && $crudShow == '1') {
          $htmlInputs .= '              <div class="col-md-4">
                <div class="form-group">
	                <label for="'.$inputName.'"> '.$inputLabel.': '.$htmlInputRequired.'</label>
                  <input type="email" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputLabel.'" '.$inputMaxlength.' '.$inputRequired.'>
                </div>
              </div>'."\n";
        } elseif ($iType[$i] == '5' && $crudShow == '1') {
          $htmlInputs .= '              <div class="col-md-4">
                <div class="form-group">
	                <label for="'.$inputName.'"> '.$inputLabel.': '.$htmlInputRequired.'</label>
                  <textarea cols="40" rows="5" id="" name="'.$inputName.'" class="form-control" placeholder="'.$inputLabel.'" '.$inputMaxlength.' '.$inputRequired.'></textarea>
                </div>
              </div>'."\n";
        } elseif ($iType[$i] == '6' && $crudShow == '1') {
          $htmlInputs .= '              <div class="col-md-4">
              <div class="form-group">
                <label for="'.$inputName.'"> '.$inputLabel.': '.$htmlInputRequired.'</label>
                <select id="'.$inputName.'" name="'.$inputName.'" class="custom-select" '.$inputRequired.'>
                  <option value="select1">select1</option>
                  <option value="select2">select2</option>
                  <option value="select3">select3</option>
                </select>
              </div>
            </div>'."\n";
        }  elseif ($iType[$i] == '7' && $crudShow == '1') {
          $htmlInputs .= '              <div class="col-md-4">
                <div class="form-group">
	                <label for="'.$inputName.'"> '.$inputLabel.': '.$htmlInputRequired.'</label>
                  <input type="date" id="'.$inputName.'" name="'.$inputName.'" class="form-control" dateISO="true" '.$inputRequired.'>
                </div>
              </div>'."\n";
        } else {
          $htmlInputs .= '             <div class="row">'."\n";
          $htmlInputs .= '              <input type="text" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputLabel.'"'.$inputMaxlength.' '.$inputRequired.'>'."\n";
        }
        
        // add field to list fields
        $ciFields .= '        $fields[\''.$column[$i].'\'] = $this->request->getPost(\''.$inputName.'\');'."\n";
        
        // list Validation field
        if ($column[$i] != $primaryKey)
          $ciValidation .= '            \''.$column[$i].'\' => [\'label\' => \''.$inputLabel.'\', \'rules\' => \''. $ciValidationRequired . $ciValidationType . $ciValidationMaxLength .'\'],'."\n";

        // Data Table
        if ($dtShow[$i] == '1') {
          $ciDataTable .= '       $value->'.$column[$i].','."\n";
          $htmlDataTable .= '         <th>'.$inputLabel.'</th>';
          $ciSelect .= $column[$i].', ';
        }

        // add allowed Fields
        if ($column[$i] != $primaryKey)
          $allowedFields .= '\''.$column[$i].'\'';

        if (($i % 3 == 0)) {
          $htmlInputs .= '            </div>'."\n"; 
          $htmlInputs .= '            <div class="row">'."\n";
        }

        if (!next($column))
          $htmlInputs .= '            </div>'."\n";

        if ($crudShow == '1')
          $htmlEditFields .= '      $("#edit-form #'.$inputName.'").val(response.'.$column[$i].');'."\n";
      }
      
      $ciSelect = substr($ciSelect, 0, -2);
      $allowedFields - substr($allowedFields, 0, -2);

      // get template contents
      $model = file_get_contents(MVC_TPL .'/Model.tpl.php');
      $controler = file_get_contents(MVC_TPL .'/Controler.tpl.php');
      $view = file_get_contents(MVC_TPL .'/View.tpl.php');

      $find = [
        '@@@table@@@', '@@@primaryKey@@@', '@@@allowedFields@@@',
        '@@@controlerName@@@', '@@@uControler@@@',
        '@@@modelName@@@', '@@@uModelName@@@',
        '@@@crudTitle@@@', '@@@htmlInputs@@@', '@@@ciFields@@@', '@@@ciValidation@@@',
        '@@@ciDataTable@@@', '@@@htmlDataTable@@@', '@@@htmlEditFields@@@', '@@@ciSelect@@@'
      ];
      $replace =[
        $table, $primaryKey, $allowedFields,
        $controlerName, $uControlerName,
        $modelName, $uModelName,
        $crudTitle, $htmlInputs, $ciFields, $ciValidation,
        $ciDataTable, $htmlDataTable, $htmlEditFields, $ciSelect
      ];

      // replace the @@@[name]@@@, $[name] to template
      $model = str_replace($find, $replace, $model);
      $controler = str_replace($find, $replace, $controler);
      $view = str_replace($find, $replace, $view);

      // Put the content to finish folder
      file_put_contents(DOWNLOADS .'/Models/'.$uModelName.'.php', $model);
      file_put_contents(DOWNLOADS .'/Controllers/'.$uControlerName.'.php', $controler);
      file_put_contents(DOWNLOADS .'/Views/'.$controlerName.'.php', $view);

      $response['success'] = true;
      $response['message'] = 
        '<a class="text-white" href="'.BASE_URL.'/download.php?t=c&f='.$uControlerName.'.php'.'" target="_blank">('.$uControlerName.'.php'.') Controller</a>'.
        '<br /> <a class="text-white" href="'.BASE_URL.'/download.php?t=m&f='.$uModelName.'.php'.'" target="_blank">('.$uModelName.'.php'.') Model</a>'.
        '<br /> <a class="text-white" href="'.BASE_URL.'/download.php?t=v&f='.$controlerName.'.php'.'" target="_blank">('.$controlerName.'.php'.') View</a>';

      die(json_encode($response));
    }

    //  ===================

    public function getBetween($string, $start, $end)
    {
      $string = ' ' . $string;
      
      $ini = strpos($string, $start);      
      if ($ini == 0) return '';

      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;

      return substr($string, $ini, $len);
    }

    public function snakeToCamel($str)
    {
      return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }

    public function colToLabel($str)
    {
      return ucfirst(str_replace('_', ' ', $str));
    }

    public function sanitize(array $input, array $fields = array(), $utf8_encode = true)
    {
      if (empty($fields)) {
        $fields = array_keys($input);
      }

      $return = array();

      foreach ($fields as $field) {
        if (!isset($input[$field])) {
          continue;
        } else {
          $value = $input[$field];

          if (is_array($value)) {
            $value = $this->sanitize($value);
          }

          if (is_string($value)) {
            if (strpos($value, "\r" !== false)) {
              $value = trim($value);
            }

            if (function_exists('iconv') && function_exists('mb_detect_encoding') && $utf8_encode) {
              $current_encoding = mb_detect_encoding($value);

              if ($current_encoding != 'UTF-8' && $current_encoding != 'UTF-16') {
                $value = iconv($current_encoding, 'UTF-8', $value);
              }
            }
            $value = filter_var($value, FILTER_SANITIZE_STRING);
          }
          $return[$field] = $value;
        }
      }

      return $return;
    }
 }
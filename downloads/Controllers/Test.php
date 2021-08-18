<?php
// CI-4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TestModel;

class Test extends BaseController
{
	
    protected $testModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->testModel = new TestModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function index()
	{

	    $data = [
                'controller'    	=> 'test',
                'title'     		=> 'testTitle'				
			];
		
		return view('test', $data);
			
	}

	public function getAll()
	{
 		$response = array();		
		
	    $data['data'] = array();
 
		$result = $this->testModel->select('id, username, password, nama')->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '	<button type="button" class="btn btn-sm btn-outline-warning" onclick="edit('. $value->id .')"><i class="fas fa-pencil-alt text-black"></i></button>';
			$ops .= '	<button type="button" class="btn btn-sm btn-outline-danger" onclick="remove('. $value->id .')"><i class="fas fa-trash-alt text-black"></i></button>';
			$ops .= '</div>';
			
			$data['data'][$key] = array(
       $value->id,
       $value->username,
       $value->password,
       $value->nama,

				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->testModel->where('id' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			
			throw new \CodeIgniter\Exceptions\PageNotFoundException();

		}	
		
	}	
	
	public function add()
	{

        $response = array();

        $fields['id'] = $this->request->getPost('id');
        $fields['username'] = $this->request->getPost('username');
        $fields['password'] = $this->request->getPost('password');
        $fields['nama'] = $this->request->getPost('nama');


        $this->validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required|max_length[255]'],
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[255]'],
            'nama' => ['label' => 'Nama', 'rules' => 'required|max_length[255]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->testModel->insert($fields)) {
												
                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Insertion error!';
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function edit()
	{

        $response = array();
		
        $fields['id'] = $this->request->getPost('id');
        $fields['username'] = $this->request->getPost('username');
        $fields['password'] = $this->request->getPost('password');
        $fields['nama'] = $this->request->getPost('nama');


        $this->validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required|max_length[255]'],
            'password' => ['label' => 'Password', 'rules' => 'required|max_length[255]'],
            'nama' => ['label' => 'Nama', 'rules' => 'required|max_length[255]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->testModel->update($fields['id'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = 'Successfully updated';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Update error!';
				
            }
        }
		
        return $this->response->setJSON($response);
		
	}
	
	public function remove()
	{
		$response = array();
		
		$id = $this->request->getPost('id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->testModel->where('id', $id)->delete()) {
								
				$response['success'] = true;
				$response['messages'] = 'Deletion succeeded';	
				
			} else {
				
				$response['success'] = false;
				$response['messages'] = 'Deletion error!';
				
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
		
}	
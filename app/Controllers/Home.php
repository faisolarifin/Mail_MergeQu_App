<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TokenModel;

class Home extends ResourceController
{
	public function __construct()
	{
		$this->token = new TokenModel();
	}
	public function index()
	{
		//get user param
		$userkey = $this->request->getPost('userKey');
		$usertoken = $this->request->getPost('userToken');
		$lock = $this->request->getPost('secretKey');
		$result = $this->token->select('token_num,plans,expired,status')->where('token_num', $usertoken)->find();
		
		//authorization
		if ($userkey == null || $usertoken == null || $lock == null) return $this->failNotFound('terjadi kesalahan!'); 
		if ($lock !== 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew') return $this->failNotFound('terjadi kesalahan!');
		if ($result == null) return $this->failNotFound('terjadi kesalahan!');

		//show result
		$data['status'] = 200;
		$data['data'] = $result;
		return $this->respond($data);
	}
	

}

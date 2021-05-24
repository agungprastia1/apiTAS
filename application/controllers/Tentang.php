<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Tentang extends RestController
{
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('M_models', 'model');
		$this->methods['index_get']['limit'] = 500;
	}

	public function index_post()
	{
		$data = [
			'created_at' => date("y-m-d H-i-s"),
			'updated_at' => date("y-m-d H-i-s"),
			'judul' => $this->post('judul'),
			'kontent' => $this->post('kontent'),
			'no_hp' => $this->post('no_hp')

		];
		$c = 0;
		foreach ($data as $key => $value) {
			if ($value == null) {
				$c += 1;
			}
		}

		if ($c > 0) {
			$this->response([
				'status' => false,
				'message' => 'HTTP_BAD_REQUEST',
				'data' => $data
			], 400);
		} else {
			if ($this->model->post('tentang', $data)) {
				$this->response([
					'status' => true,
					'message' => 'HTTP_OK',
					'data' => $this->model->post('tentang', $data)
				], 201);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Not Modified',
					'data' => []
				], 304);
			}
		}
	}

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'created_at' => $this->put('created_at'),
			'updated_at' => date("y-m-d H-i-s"),
			'judul' => $this->put('judul'),
			'kontent' => $this->put('kontent'),
			'no_hp' => $this->put('no_hp')
		];

		$c = 0;
		foreach ($data as $key => $value) {
			if ($value == null) {
				$c += 1;
			}
		}

		if ($c > 0) {
			$this->response([
				'status' => false,
				'message' => 'HTTP_BAD_REQUEST',
				'data' => $data
			], 400);
		} else {
			if ($this->model->put('tentang', $data, $id)) {
				$this->response([
					'status' => true,
					'message' => 'HTTPS_OK',
					'data' => $this->model->put('tentang', $data, $id)
				], 201);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Not Modified',
					'data' => []
				], 304);
			}
		}
	}

	public function index_get()
	{
		$id = $this->get('id');
		$page = $this->model->get('tentang', $id);
		if ($id === null) {
			if ($page) {
				$this->response([
					'status' => true,
					'message' => 'HTTP_OK',
					'data' => $page
				], 200);
			} else {
				$this->response([
					'status' => false,
					'message' => 'HTTP_NOT_FOUND',
					'data' => []
				], 404);
			}
		} else {
			if ($page) {
				$this->response([
					'status' => true,
					'message' => 'HTTP_OK',
					'data' => $page
				], 200);
			} else {
				$this->response([
					'status' => false,
					'message' => 'HTTP_NOT_FOUND',
					'data' => []
				], 404);
			}
		}
	}

	public function index_delete()
	{
		$id = $this->delete('id');
		$page = $this->model->delete('tentang', $id);
		if ($id === null) {
			if ($page) {
				$this->response([
					'status' => true,
					'message' => 'HTTP_OK',
					'data' => $page
				], 200);
			} else {
				$this->response([
					'status' => false,
					'message' => 'HTTP_NOT_FOUND'
				], 404);
			}
		} else {
			if ($page) {
				$this->response([
					'status' => true,
					'message' => 'HTTP_OK',
					'data' => $page
				], 200);
			} else {
				$this->response([
					'status' => false,
					'message' => 'HTTP_NOT_FOUND'
				], 404);
			}
		}
	}
}

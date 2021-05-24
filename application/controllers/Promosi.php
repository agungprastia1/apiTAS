<?php
defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;

class Promosi extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_models', 'model');
        $this->methods['index_get']['limit'] = 500;
    }
    public function index_post()
    {
        $data = [
            'created_at' => date("y-m-d H-i-s"),
            'updated_at' => date("y-m-d H-i-s"),
            'id_toko' => $this->post('id_toko'),
            'nama_promosi' => $this->post('nama_promosi'),
            'deskripsi_promosi' => $this->post('deskripsi_promosi'),
            'gambar_promosi' => $this->addfoto()
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
                'message' => 'BAD REQUEST',
                'data' => $data
            ], 304);
        } else {
            if ($this->model->post('promosi', $data)) {
                $this->response([
                    'status' => true,
                    'message' => 'HTTP_CREATED',
                    'data' => $this->model->post('promosi', $data)
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'HTTP_NOT_MODIFIED',
                    'data' => $this->model->post('promosi', $data)
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
            'id_toko' => $this->put('id_toko'),
            'nama_promosi' => $this->put('nama_promosi'),
            'deskripsi_promosi' => $this->put('deskripsi_promosi'),
            'gambar_promosi' => $this->put('gambar_promosi')
        ];

        $c = 0;
        foreach ($data as $key => $value) {
            if ($value == null) {
                $c += 1;
            }
        }

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'id tidak boleh kosong',
                'data' => $id
            ], 400);
        } else {
            if ($this->model->put('promosi', $data, $id)) {
                $this->response([
                    'status' => true,
                    'message' => 'HTTP_CREATED',
                    'data' => $this->model->put('promosi', $data, $id)
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'HTTP_NOT_MODIFIED',
                    'data' => []
                ], 304);
            }
        }
    }

    public function index_get()
    {
        $id = $this->get('id');
        $data = $this->model->get('promosi', $id);
        if ($id === null) {
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'HTTP_OK',
                    'data' => $data
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'HTTP_NOT_FOUND',
                    'data' => $data
                ], 404);
            }
        } else {
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'HTTP_OK',
                    'data' => $data
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'HTTP_NOT_FOUND',
                    'data' => $data
                ], 404);
            }
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        $data = $this->model->delete('promosi', $id);
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID TIDAK BOLEH KOSONG',
                'data' => $id
            ], 400);
        } else {
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'deleted',
                    'data' => $data
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data not found!',
                    'data' => $data
                ], 404);
            }
        }
    }

    public function addfoto()
    {
        $foto = $_FILES['gambar_promosi']['name'];
        $tmp = $_FILES['gambar_promosi']['tmp_name'];
        $fotobaru = $foto;

        $path = "asset/img/" . $fotobaru;

        if (move_uploaded_file($tmp, $path)) {
            $res = $fotobaru;
            return $res;
        }
        return "logo.jpg";
    }
}

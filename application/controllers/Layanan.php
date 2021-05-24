<?php
defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;

class Layanan extends RestController
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
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa"),
            'id_toko' => $this->post('id_toko'),
            'nama_layanan' => $this->post('nama_layanan'),
            'deskripsi_layanan' => $this->post('deskripsi_layanan'),
            'gambar_layanan' => $this->addfoto(),
        ];
        $c = 0;
        foreach ($data as $key => $value) {
            if ($value === null) {
                $c += 1;
            }
        }

        if ($c > 0) {
            $this->response([
                'status' => false,
                'message' => 'data not modified',
                'data' => $data
            ], 406);
        } else {
            $res = $this->model->post('layanan', $data);
            if ($res) {
                $this->response([
                    'status' => true,
                    'message' => 'HTTP_CREATED',
                    'data' => $res
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'INTERNAL SERVER ERORR',
                    'data' => $res
                ], 500);
            }
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'created_at' => $this->put('created_at'),
            'updated_at' => date("Y-m-d h:i:sa"),
            'id_toko' => $this->put('id_toko'),
            'nama_layanan' => $this->put('nama_layanan'),
            'deskripsi_layanan' => $this->put('deskripsi_layanan'),
            'gambar_layanan' => $this->put('gambar_layanan'),
        ];
        $c = 0;
        foreach ($data as $key => $value) {
            if ($value === null) {
                $c += 1;
            }
        }

        if ($c > 0) {
            $this->response([
                'status' => false,
                'message' => 'data not modified',
                'data' => $data
            ], 406);
        } else {
            $res = $this->model->put('layanan', $data, $id);
            if ($res) {
                $this->response([
                    'status' => true,
                    'message' => 'UPDATED',
                    'data' => $res
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'INTERNAL SERVER ERROR'
                ], 500);
            }
        }
    }

    public function addfoto()
    {
        $foto = $_FILES['gambar_layanan']['name'];
        $tmp = $_FILES['gambar_layanan']['tmp_name'];
        $fotobaru = $foto;

        $path = "asset/img/" . $fotobaru;

        if (move_uploaded_file($tmp, $path)) {
            $res = $fotobaru;
            return $res;
        }
        return "logo.jpg";
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'statuss' => false,
                'message' => 'HTTP_BAD_REQUEST'
            ], 400);
        } else {
            $data = $this->model->delete('layanan', $id);
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'Deleted',
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

    public function index_get()
    {
        $id = $this->get('id');
        $data = $this->model->get('layanan', $id);
        if ($id === null) {
            if ($data) {
                $this->response($data, 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data not found',
                    'data' => $data
                ], 404);
            }
        } else {
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'HTTPS_OK',
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
}

<?php
defined('BASEPATH') or exit('no direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Foto extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_foto', 'model');
        $this->methods['index_get']['limit'] = 500;
    }

    public function index_post()
    {
        $id = $this->post('id');
        $data = [
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa"),
            'email' => $this->post('email'),
            'user_id' => $this->post('user_id'),
            'foto_profil' => $this->addfoto()
        ];
        $res = $this->model->cek('foto_profil', $data['email'], $data['user_id']);
        if (count($res) > 0) {
            $this->index_put($data, $id);
        } else {
            $post = $this->model->post('foto', $data);
            if ($post) {
                $this->response([
                    'status' => true,
                    'message' => 'foto di upload',
                    'data' => $data
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'foto gagal di upload',
                    'data' => []
                ]);
            }
        }
    }

    public function index_put($put = true, $id = true)
    {
        $data = $this->model->put('foto', $put, $id);
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'id  tidak ditemukan'
            ], 400);
        }
        if ($data > 0) {
            $this->response([
                'status' => true,
                'message' => 'UPDATED',
                'data' => $data
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data not updated',
                'data' => $data
            ], 404);
        }
    }
    public function addfoto()
    {
        $foto = $_FILES['foto_profil']['name'];
        $tmp = $_FILES['foto_profil']['tmp_name'];
        $fotobaru = $foto;

        $path = "asset/img/" . $fotobaru;

        if (move_uploaded_file($tmp, $path)) {
            $res = $fotobaru;
            return $res;
        }
        return "logo.jpg";
    }

    public function toko_post()
    {
        $id = $this->post('id');
        $data = [
            'created_at' => $this->post('created_at'),
            'updated_at' => date("Y-m-d h:i:sa"),
            'email' => $this->post('email'),
            'user_id' => $this->post('user_id'),
            'foto_toko' => $this->FotoToko()
        ];
        $res = $this->model->cekToko($data['email'], $data['user_id']);

        if (count($res) > 0) {
            $this->index_put($data, $id);
        } else {
            $post = $this->model->post('foto', $data);
            if ($post) {
                $this->response([
                    'status' => true,
                    'message' => 'foto di upload',
                    'data' => $data
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data not modified',
                    'data' => $data
                ]);
            }
        }
    }
    public function toko_put($put, $id)
    {
        $data = $this->model->put('foto', $put, $id);
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'BAD REQUEST',
                'data' => []
            ], 400);
        }
        if ($data > 0) {
            $this->response([
                'status' => true,
                'message' => 'UPDATED',
                'data' => []
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data not updated'
            ], 404);
        }
    }
    public function FotoToko()
    {
        $foto = $_FILES['foto_toko']['name'];
        $tmp = $_FILES['foto_toko']['tmp_name'];
        $fotobaru = $foto;

        $path = "asset/img/" . $fotobaru;

        if (move_uploaded_file($tmp, $path)) {
            $res = $fotobaru;
            return $res;
        }
        return "logo.jpg";
    }

    public function index_get()
    {
        $id = $this->get('id');
        $data = [
            'created_at' => $this->get('created_at'),
            'updated_at' => $this->get('updated_at'),
            'email' => $this->get('email'),
            'user_id' => $this->get('user_id')
        ];
        $res = $this->model->cekFoto($data['email'], $data['user_id']);
        if ($res) {
            $this->response([
                'status' => true,
                'message' => 'HTTP_OK',
                'data' => $res
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'not found',
                'data' => []
            ], 404);
        }
    }
    public function toko_get()
    {
        $id = $this->get('id');
        $data = [
            'created_at' => $this->get('created_at'),
            'updated_at' => $this->get('updated_at'),
            'email' => $this->get('email'),
            'user_id' => $this->get('user_id')
        ];
        $res = $this->model->cekToko($data['email'], $data['user_id']);
        if ($res) {
            $this->response([
                'status' => true,
                'message' => 'HTTP_OK',
                'data' => $res
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'not found',
                'data' => []
            ], 404);
        }
    }
}

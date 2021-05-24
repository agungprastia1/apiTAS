<?php
defined('BASEPATH') or exit('no direct script access allowed ');

use chriskacerguis\RestServer\RestController;

class Kegiatan extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_models', 'model');
        $this->methods['index_get']['limit'] = 500;
    }
    public function index_get()
    {
        $id = $this->get('id');
        $page = $this->model->get('kegiatan', $id);
        if ($id == null) {
            if ($page) {
                $this->response([
                    'status' => true,
                    'message' => 'Semua kegiatan',
                    'data' => $page
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'kegiatan tidak ditemukan',
                    'data' => $page
                ], 404);
            }
        } else {
            if ($page) {
                $this->response([
                    'status' => true,
                    'message' => 'kegiatan berdaserkan id',
                    'data' => $page
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id kegiatan tidak ditemukan',
                    'data' => $page
                ], 404);
            }
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'HTTP_BAD_REQUEST',
                'data' => []
            ], 400);
        } else {
            $page = $this->model->delete('kegiatan', $id);
            if ($page > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'deleted'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'No Page were found'
                ], 404);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa"),
            'title' => $this->post('title'),
            'tubnail' => $this->post('tubnail'),
            'konten' => $this->post('konten'),
            'gambar' => $this->addfoto()
        ];
        $c = 0;
        foreach ($data as $key => $value) {
            $cek = $value ?? null;
            if ($cek === null) {
                $c += 1;
            }
        }
        if ($c > 0) {
            $this->response([
                'status' => false,
                'message' => 'HTTP_BAD_REQUEST'
            ], 400);
        } else {
            $this->model->post('kegiatan', $data);
            $this->response([
                'status' => true,
                'message' => 'HTTP_CREATED',
                'data' => $data
            ], 201);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'created_at' => $this->put('created_at'),
            'updated_at' => date("Y-m-d h:i:sa"),
            'title' => $this->put('title'),
            'tubnail' => $this->put('tubnail'),
            'konten' => $this->put('konten'),
            'gambar' => $this->put('gambar')
        ];
        $c = 0;
        foreach ($data as $key => $value) {
            $cek = $value ?? null;
            if ($cek === null) {
                $c += 1;
            }
        }
        if ($c > 0) {
            var_dump($data);
            $this->response([
                'status' => false,
                'message' => 'HTTP_NOT_MODIFIED'
            ], 400);
        } else {
            $this->model->put('kegiatan', $data, $id);
            $this->response([
                'status' => true,
                'message' => 'updated'
            ], 200);
        }
    }

    public function addfoto()
    {
        $foto = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $fotobaru = $foto;

        $path = "asset/img/" . $fotobaru;

        if (move_uploaded_file($tmp, $path)) {
            $res = $fotobaru;
            return $res;
        }
        return "logo.jpg";
    }
}

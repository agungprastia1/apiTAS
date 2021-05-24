<?php
defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;

class Toko extends RestController
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
            'user_id' => $this->post('user_id'),
            'nama' => $this->post('nama'),
            'nama_toko' => $this->post('nama_toko'),
            'email' => $this->post('email'),
            'no_hp' => $this->post('no_hp'),
            'provinsi' => $this->post('provinsi'),
            'kecamatan' => $this->post('kecamatan'),
            'kabupaten' => $this->post('kabupaten'),
            'alamat_toko' => $this->post('alamat_toko'),
            'deskripsi_toko' => $this->post('deskripsi_toko')
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
                'message' => 'data tidak boleh kosong',
                'data' => $data
            ], 304);
        } else {
            $res = $this->model->post('toko', $data);
            if ($res) {
                $this->response([
                    'status' => true,
                    'message' => 'created',
                    'data' => $res
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'HTTP_INTERNAL_ERROR',
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
            'updated_at' => date("y-m-d H-i-s"),
            'user_id' => $this->put('user_id'),
            'nama' => $this->put('nama'),
            'nama_toko' => $this->put('nama_toko'),
            'email' => $this->put('email'),
            'no_hp' => $this->put('no_hp'),
            'provinsi' => $this->put('provinsi'),
            'kecamatan' => $this->put('kecamatan'),
            'kabupaten' => $this->put('kabupaten'),
            'alamat_toko' => $this->put('alamat_toko'),
            'deskripsi_toko' => $this->put('deskripsi_toko')
        ];

        $c = 0;
        foreach ($data as $key => $value) {
            if ($value === null) {
                $c += 1;
            }
        }
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => "ID TIDAK BOLEH KOSONG",
                'DATA' => $id
            ], 400);
        } else {
            if ($c > 0) {
                $this->response([
                    'status' => false,
                    'message' => "tidak boleh kosong",
                    'data' => $data
                ], 403);
            } else {
                $res = $this->model->put('toko', $data, $id);
                if ($res) {
                    $this->response([
                        'ststus' => true,
                        'message' => 'UPDATED',
                        'data' => $res
                    ], 200);
                } else {
                    $this->response([
                        'ststus' => true,
                        'message' => 'NOT MODIFIED',
                        'data' => $data
                    ], 403);
                }
            }
        }
    }

    public function index_get()
    {
        $id = $this->get('id');
        $data = $this->model->get('toko', $id);
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
                    'message' => 'HTTP_FORBIDDEN',
                    'data' => $data
                ], 403);
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
                    'message' => 'toko not found',
                    'data' => $data
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
                'message' => 'ID TIDAK BOLEH KOSONG',
                'data' => $id
            ], 400);
        } else {
            $res = $this->model->delete('toko', $id);
            if ($res) {
                $this->response([
                    'status' => true,
                    'message' => 'DELETED',
                    'data' => $res
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'HTTP_NO_FOUND',
                    'data' => $res
                ], 404);
            }
        }
    }
}

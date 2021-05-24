<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_models', 'model');
        $this->methods['index_get']['limit'] = 500;
    }

    // tambah User
    public function index_post()
    {
        $data = [
            'created_at' => date("y-m-d H-i-s"),
            'updated_at' => date("y-m-d H-i-s"),
            'nama' => $this->post('nama'),
            'nama_toko' => $this->post('nama_toko'),
            'email' => $this->post('email'),
            'email_verified_at' => $this->post('email_verified_at'),
            'no_hp' => $this->post('no_hp'),
            'provinsi' => $this->post('provinsi'),
            'kecamatan' => $this->post('kecamatan'),
            'kabupaten' => $this->post('kabupaten'),
            'alamat' => $this->post('alamat'),
            'password' => md5($this->post('password'))
        ];
        // $c = 0;
        // foreach ($data as $key => $value) {
        //     if ($value === null) {
        //         $c += 1;
        //     }
        // }
        // if ($c > 0) {
        //     $this->response([
        //         'status' => false,
        //         'message' => 'data tidak boleh kosong'
        //     ], 400);
        // } else {
        echo $data['password'];
        $res = $this->model->post('akun', $data);
        if ($res) {
            $this->response([
                'status' => true,
                'message' => 'CREATED',
                'data' => $res
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'DATA NOT MODIFIED',
                'data' => $res
            ], 500);
        }
        // }
    }

    // edit User
    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'created_at' => $this->put('created_at'),
            'updated_at' => date("y-m-d H-i-s"),
            'nama' => $this->put('nama'),
            'nama_toko' => $this->put('nama_toko'),
            'email' => $this->put('email'),
            'email_verified_at' => $this->put('email_verified_at'),
            'no_hp' => $this->put('no_hp'),
            'provinsi' => $this->put('provinsi'),
            'kecamatan' => $this->put('kecamatan'),
            'kabupaten' => $this->put('kabupaten'),
            'alamat' => $this->put('alamat'),
            'password' => md5($this->put('password'))
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
                'message' => 'id tidak boleh kosong',
                'data' => $id
            ], 400);
        } else {
            if ($c > 0) {
                $this->response([
                    'status' => false,
                    'message' => 'data tidak boleh kosong',
                    'data' => $data
                ], 400);
            } else {
                $res = $this->model->put('akun', $data, $id);
                if ($res) {
                    $this->response([
                        'status' => true,
                        'message' => 'UPDATED',
                        'data' => $res
                    ], 201);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'DATA NOT MODIFIED',
                        'data' => $data
                    ], 500);
                }
            }
        }
    }

    // ambil data
    public function index_get()
    {
        $id = $this->get('id');
        $data = $this->model->get('akun', $id);
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
                    'message' => 'data not found',
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
                    'message' => 'data not found',
                    'data' => $data
                ], 404);
            }
        }
    }

    // delete data
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'id tidak boleh kosong',
                'data' => $id
            ], 400);
        } else {
            $data = $this->model->delete('akun', $id);
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'DELETED',
                    'data' => $data
                ]);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data not found',
                    'data' => $data
                ], 404);
            }
        }
    }
}

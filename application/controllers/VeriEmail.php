<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class VeriEmail extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth', 'auth');
        $this->load->model('M_models', 'model');
        $this->methods['index_get']['limit'] = 500;
    }

    // ambil email yg belum di verifikasi
    public function index_get()
    {
        $id = $this->get('id');
        $data = $this->auth->getWherenull('akun', $id);

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
                $this->response($data, 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data not found'
                ], 404);
            }
        }
    }

    // verikasi email
    public function index_put()
    {
        $id = $this->put('id');
        $data = date("y-m-d H-i-s");
        $akun = $this->auth->getWherenull('akun', $id);
        if (count($akun) > 0) {
            if ($this->auth->verifiEmail('akun', $data, $id)) {
                var_dump($id);
                $this->auth_post($id);
                $this->response([
                    'status' => true,
                    'message' => 'HTTP_OK',
                    'data' => $akun
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data not modified',
                    'data' => $akun
                ], 403);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'data not found',
                'data' => $akun
            ], 404);
        }
    }
    public function auth_post($id)
    {
        $data = [
            'user_id' => $id,
            'key' => md5($id . date('y-m-d H:i:s')),
            'level' => 2,
            'date_created' => date('y-m-d H:i:s')
        ];
        $this->model->post('keys', $data);
    }

    public function emailVerifi_get()
    {
        $id = $this->get('id');
        $data = $this->auth->getVerifi($id);

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
}

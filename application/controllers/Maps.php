<?php
defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;

class Maps extends RestController
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
            'user_id' => $this->post('user_id'),
            'maps' => $this->post('maps')
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
                'message' => 'HTTP_BAD_REQUEST',
                'data' => $data
            ], 400);
        } else {
            $res = $this->model->post('maps', $data);
            $this->response([
                'status' => true,
                'message' => 'HTTP_CREATED',
                'data' => $res
            ], 201);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'created_at' => $this->put('created_at'),
            'updated_at' => date("Y-m-d h:i:sa"),
            'user_id' => $this->put('user_id'),
            'maps' => $this->put('maps')
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
                'message' => 'ID TIDAK BOLEH KOSONG',
                'data' => $id
            ], 400);
        } else {
            if ($c > 0) {
                $this->response([
                    'status' => false,
                    'message' => 'HTTPS_BAD_REQUEST'
                ], 400);
            } else {
                $res = $this->model->put('maps', $data, $id);
                if ($res > 0) {
                    $this->response([
                        'status' => true,
                        'message' => 'HTTP_CREATED',
                        'data' => $res
                    ], 201);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'HTTP_NOT_MODIFIED',
                        'data' => $res
                    ], 304);
                }
            }
        }
    }

    public function index_get()
    {
        $id = $this->get('id');
        $data = $this->model->get('maps', $id);
        if ($id === null) {
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'HTTPS_OK',
                    'data' => $data
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'No data were found',
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

    public function index_delete()
    {
        $id = $this->delete('id');
        $data = $this->model->delete('maps', $id);
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID TIDAK BOLEH KOSONG',
                'data' => $id
            ], 400);
        } else {
            if ($data > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'deleted',
                    'data' => $data
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data not modified',
                    'data' => $data
                ], 403);
            }
        }
    }
}

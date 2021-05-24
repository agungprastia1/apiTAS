<?php
defined('BASEPATH') or exit('no direct script access allowed');

// use chriskacerguis\RestServer\RestController;

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth', 'auth');
        $this->load->model('M_models', 'model');
    }

    public function index()
    {
        $run = false;
        $email = $this->input->post('email');
        $pass = md5($this->input->post('password'));
        $akun = $this->auth->cek_akun($email, $pass);
        if ($akun->num_rows() != 0) {
            foreach ($akun->result() as $a) {
                $em = $a->email;
            }
            foreach ($akun->result() as $p) {
                $pa = $p->password;
            }
            foreach ($akun->result() as $id) {
                $sek = $id->id;
            }
            foreach ($akun->result() as $na) {
                $name = $na->nama;
            }

            if (($email == $em) && ($pass == $pa)) {
                $run = true;
            }
        }

        if ($run == true) {
            if ($em === null) {
                $respon =  [
                    'status' => false,
                    'message' => 'email belum terdaftar',
                    'data' => []
                ];
                print_r($respon);
            } else {
                $data = [
                    'user_id' => $sek,
                    'key' => md5($sek . date('H:i:s')),
                    'level' => 2,
                    'date_created' => date('y-m-d H:i:s')
                ];
                $this->model->post('keys', $data);
                $respon = [
                    'status' => true,
                    'message' => 'Login',
                    'data' => $data
                ];
                print_r($respon);
            }
        } else {
            $respon = [
                'status' => false,
                'message' => 'email atau password salah',
                'data' => []
            ];
            print_r($respon);
        }
    }

    public function logout($token)
    {
        $this->model->destroy($token);
        $this->session->sess_destroy();
        $respon = [
            'status' => true,
            'message' => 'Logout',
            'data' => []
        ];
        print_r($respon);
    }
}

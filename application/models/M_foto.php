<?php
defined('BASEPATH') or exit('no direct script access allowed');
class M_foto extends CI_model
{
    public function cek($foto, $email, $id)
    {
        return $this->db->query("SELECT $foto FROM foto where email = '" . $email . "' and user_id = $id")->result_array();
    }

    public function cekFoto($email, $id)
    {
        return $this->db->query("SELECT * FROM foto where email = '" . $email . "' AND user_id = $id")->result_array();
    }

    public function cekToko($email, $id)
    {
        return $this->db->query("SELECT * FROM foto where email = '" . $email . "' AND user_id = $id")->result_array();
    }

    public function post($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function put($table, $data, $id)
    {
        $this->db->update($table, $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}

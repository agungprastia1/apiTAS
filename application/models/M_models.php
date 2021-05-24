<?php
defined('BASEPATH') or exit('no direct script access allowed');
class M_models extends CI_model
{
    // ambil data user
    public function get($data, $id = null)
    {
        if ($id === null) {
            return $this->db->get($data)->result_array();
        } else {
            return $this->db->get_where($data, ['id' => $id])->result_array();
        }
    }

    // tambah data
    public function post($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    // delete data berdasarkan id
    public function delete($table, $id)
    {
        $this->db->delete($table, ['id' => $id]);
        return $this->db->affected_rows();
    }

    // update data 
    public function put($table, $data, $id)
    {
        $this->db->update($table, $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}

<?php
defined('BASEPATH') or exit('no direct script access allowed');
class M_auth extends CI_model
{
    public function getAuth($id)
    {
        return $this->db->query("SELECT * FROM `keys` WHERE user_id = $id")->result_array();
    }

    // ambil email user
    public function getWhere($table, $data)
    {
        return $this->db->get_where($table, ['email' => $data])->result_array();
    }

    // cek apakah email sudah diverifikasi
    public function getWherenull($table, $id = null)
    {
        if ($id === null) {
            return $this->db->get_where($table, ['email_verified_at' => 'null'])->result_array();
        } else {
            return $this->db->get_where($table, ['email_verified_at' => 'null', 'id' => $id])->result_array();
        }
    }

    // cek apakah email sudah diverifikasi
    public function getVerifi($id = null)
    {
        if ($id === null) {
            return $this->db->query("SELECT * FROM `akun` WHERE `email_verified_at` != 'null'")->result_array();
        } else {
            return $this->db->query("SELECT * FROM `akun` WHERE `email_verified_at` != 'null' && `id` = $id")->result_array();
        }
    }

    // Verifikasi email
    public function verifiEmail($table, $data, $id)
    {
        return $this->db->query("UPDATE `$table` SET `email_verified_at` = '$data' WHERE `id` = '$id'");
    }

    // reset password
    public function ressetPass($table, $data, $email)
    {
        return $this->db->query("UPDATE `$table` SET `password` = '$data' WHERE `email` = '$email'");
    }

    public function cek_akun($user, $pass)
    {
        return $this->db->get_where('akun', ['email' => $user, 'password' => $pass]);
    }
    public function destroy($token)
    {
        return $this->db->delete('keys', ['key' => $token]);
    }
}

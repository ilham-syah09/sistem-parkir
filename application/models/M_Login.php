<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Login extends CI_Model
{
    function cek($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('admin');
        $data = $query->row();

        if ($data) {
            if (password_verify($password, $data->password)) {
                $login        =    array(
                    'is_logged_in'    => true,
                    'username'        => $username,
                    'id'              => $data->id,
                    'role'            => 'admin'
                );
                if ($login) {
                    $this->session->set_userdata('log_admin', $login);
                    $this->session->set_userdata($login);
                    return 'admin';
                }
            } else {
                return 'Username atau Password Salah!!';
            }
        } else {
            $this->db->where('email', $username);
            $query = $this->db->get('user');
            $data = $query->row();

            if ($data) {
                if (password_verify($password, $data->password)) {
                    $login        =    array(
                        'is_logged_in'    => true,
                        'username'        => $username,
                        'id'              => $data->id,
                        'role'            => 'user'
                    );
                    if ($login) {
                        $this->session->set_userdata('log_user', $login);
                        $this->session->set_userdata($login);
                        return 'user';
                    }
                } else {
                    return 'Username atau Password Salah!!';
                }
            } else {
                return 'Username atau Password Salah!!';
            }
        }
    }
}

/* End of file MLogin.php */
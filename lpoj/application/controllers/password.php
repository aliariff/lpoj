<?php

class Password extends CI_Controller
{

    public function index()
    {
        $ceksess = $this->Usermodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->load->view('user_password');
        }
    }

    public function editPass()
    {
        $ceksess = $this->Usermodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $username = $this->session->userdata('username');
            $oldpass  = $this->input->post("oldpass");
            $newpass  = $this->input->post("newpass");
            $conpass  = $this->input->post("conpass");

            $hash = do_hash($oldpass, 'sha1');
            $q    = "select 1 from pc_user where user_password='" . $hash . "' and user_name='" . $username . "' ";
            $qr   = $this->db->query($q);
            if ($qr->num_rows() > 0 && $newpass && ($newpass == $conpass)) {
                $hash = do_hash($newpass, 'sha1');
                $q    = "UPDATE pc_user
                        SET user_password='" . $hash . "'
                        WHERE user_name='" . $username . "' ";
                $this->db->query($q);
            }
            redirect(site_url() . '/password');
        }
    }

}

<?php

class Session extends CI_Controller
{

    public function index()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->Usermodel->checkPassword($username, $password);

    }

    public function contest()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->Contestmodel->checkContestPassword($username, $password);
    }
    public function manager()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($username == "admin" && $password == "llp") {
            //$this->load->library("session");
            $this->session->set_userdata("admin", true);
            //echo $this->session->userdata("admin");
            //echo "pp";
            redirect("manager");
        } else {
            redirect(base_url());
        }
    }
}

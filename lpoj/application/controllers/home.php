<?php

class Home extends CI_Controller
{

    public function index()
    {
        //checking user session
        $ceksess = $this->Usermodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->load->view('user_home');
        }
    }
}

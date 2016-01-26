<?php

class Rank extends CI_Controller
{

    public function index()
    {
        $ceksess = $this->Usermodel->checkSession() && $this->Usermodel->checkContestSession();

        if ($ceksess == false) {
            redirect(site_url('/home'));
        } else {
            $this->load->view('user_rank');
        }
    }
}

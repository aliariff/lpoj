<?php

class Liverank extends CI_Controller
{

    public function index()
    {
        $ceksess    = $this->Usermodel->checkSessionProbset();
        $ceksess2   = $this->Adminmodel->checkSession();
        $cekcontest = $this->session->userdata('contestid');
        if (($ceksess == false && $ceksess2 == false) || !$cekcontest) {
            redirect(site_url() . '/login');
        } else {
            $this->load->view('live_view');
        }

    }
}

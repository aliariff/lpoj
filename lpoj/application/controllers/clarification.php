<?php

class Clarification extends CI_Controller
{

    public function index()
    {
        $ceksess = $this->Usermodel->checkSession() && $this->Usermodel->checkContestSession();

        if ($ceksess == false) {
            redirect(site_url('/home'));
        } else {
            $this->load->view('user_clarification');
        }
    }

    public function all()
    {
        $ceksess = $this->Usermodel->checkSession() && $this->Usermodel->checkContestSession();

        if ($ceksess == false) {
            redirect(site_url('/home'));
        } else {
            $conid = $this->Participantmodel->getMyContestId();

            $data = array(
                'conid' => $conid,
            );

            $this->load->view('user_clarification_all', $data);
        }
    }
}

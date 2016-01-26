<?php

class Contest_select extends CI_Controller
{

    public function index()
    {
        $this->load->model('Usermodel');
        $ceksess = $this->Usermodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $contestid = $this->input->post('contest');
            $verify    = $this->Participantmodel->checkIsParticipant($contestid);

            if ($verify != -1) {
                $data = array(
                    'username'      => $this->session->userdata('username'),
                    'sessionkey'    => $this->session->userdata('sessionkey'),
                    'participantid' => $verify,
                );
                $this->session->set_userdata($data);
            } else {
                $data = array(
                    'username'      => $this->session->userdata('username'),
                    'sessionkey'    => $this->session->userdata('sessionkey'),
                    'participantid' => -1,
                );
                $this->session->set_userdata($data);
                $this->session->set_flashdata('contesterror', 'User not Registered');
            }
            redirect(site_url('home'));
        }
    }
}

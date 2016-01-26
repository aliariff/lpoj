<?php

class Problem extends CI_Controller
{

    public function detail($problemid)
    {
        $ceksess = $this->Usermodel->checkSession() && $this->Usermodel->checkContestSession();

        if ($ceksess == false) {
            redirect(site_url('/home'));
        } else {
            $problemid = $this->db->escape($problemid);
            if ($this->Problemmodel->getProblemInContest($problemid)) {
                $data = array('problemid' => $problemid);
                $this->load->view('user_problem', $data);
            } else {
                redirect(site_url('/home'));
            }
        }
    }
}

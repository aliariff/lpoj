<?php

class Solution extends CI_Controller
{

    public function index()
    {
        $ceksess = $this->Usermodel->checkSession() && $this->Usermodel->checkContestSession();

        if ($ceksess == false) {
            redirect(site_url('/home'));
        } else {
            $this->load->view('user_solution');
        }
    }
    public function viewSolution($idSubmit)
    {
        $ceksess = $this->Usermodel->checkPrev($idSubmit);
        if ($ceksess) {
            echo "<pre>" . $this->Submitmodel->getSolutionContentById($idSubmit) . "</pre>";
        } else {
            echo "ooh tidak isa";
        }

    }
    public function refreshVerdict($idSubmit)
    {
        /*$ceksess = $this->Usermodel->checkPrev($idSubmit);
        if($ceksess)
        {*/
        echo $this->Submitmodel->getSolutionVerdictById($idSubmit);
        /*}
    else
    {
    echo "refresh";
    }*/
    }
}

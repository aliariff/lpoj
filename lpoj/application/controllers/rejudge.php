<?php

class Rejudge extends CI_Controller
{
    public function index()
    {
        $probid = $this->input->post('probid');
        exec("python " . COMPILER_FOLDER . "compilerDaemonMk4b/rejudge.py " . $probid);
        redirect('contest/problem/' . $probid);
    }
}

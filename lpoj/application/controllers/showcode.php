<?php

class Showcode extends CI_Controller
{

    public function readCode($fileName, $probid, $submitid)
    {
        $token   = explode("_-_", $fileName);
        $ceksess = $this->Usermodel->checkSessionSubmission($token[3]);
        if ($ceksess == false) {
            redirect(site_url() . '/home');
        } else {
            $path = COMPILER_FOLDER . "backup/" . $probid . "/" . $fileName;
            $lang = "cpp";
            if (substr($fileName, -1) == 's') {
                $lang = "pas";
            }
            $data = array(
                'fileName' => $fileName,
                'path'     => $path,
                'submitid' => $submitid,
                'lang'     => $lang,
            );
            if ($this->Usermodel->checkSession()) {
                $this->load->view('showcode_user_view', $data);
            } else {
                $this->load->view('showcode_view', $data);
            }

        }
    }
}

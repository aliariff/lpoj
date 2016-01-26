<?php

class Upload extends CI_Controller
{

    public function index()
    {
        $ceksess = $this->Usermodel->checkSession() && $this->Usermodel->checkContestSession();
        if ($ceksess == false) {
            redirect(site_url() . '/home');
        } else {
            if ($problem = $this->input->post('submitproblem') == 0) {
                $this->session->set_flashdata('uploaderror', 'Problem is not valid');
            } else if ($_FILES["userfile"]["error"] > 0) {
                if ($_FILES["userfile"]["error"] == 1) {
                    $this->session->set_flashdata('uploaderror', "File size exceed the limit");
                } else if ($_FILES["userfile"]["error"] == 2) {
                    $this->session->set_flashdata('uploaderror', "File size exceed the limit");
                } else if ($_FILES["userfile"]["error"] == 3) {
                    $this->session->set_flashdata('uploaderror', "The uploaded file just partially uploaded ");
                } else if ($_FILES["userfile"]["error"] == 4) {
                    // Proses submit copas kode
                    /*if(!empty($this->input->post('usercode')))
                    {
                    $problem  = $this->input->post('submitproblem');
                    $time = now();
                    $username = $this->session->userdata('username');
                    $participant = $this->session->userdata('participantid');
                    $fname = "solution.".$this->input->post('lang');
                    $fileformat = $problem."_-_".$username."_-_".$fname;

                    $hashcode1     = do_hash($time."_-_".$fileformat,'sha1');
                    $hashcode2    = do_hash($time, 'md5');

                    $hashcode    = $hashcode1.$hashcode2;

                    $fileformat = $time."_-_".$hashcode."_-_".$fileformat;

                    $this->load->model('Submitmodel');
                    $iid = $this->Submitmodel->SaveToDb($time,$problem,$participant,$fname,$hashcode);

                    $compilerCount = 1;
                    file_put_contents(COMPILER_FOLDER . "upload/".$fileformat, $this->input->post('usercode'));

                    $this->session->set_flashdata('uploadok','Berhasil Berhasil Berhasil Horeeee');
                    }
                    else
                    {*/
                    $this->session->set_flashdata('uploaderror', "No file submitted");
                    //}
                } else {
                    $this->session->set_flashdata('uploaderror', "PHP Error Code : " . $_FILES["userfile"]["error"]);
                }

                //echo "Error: " . $_FILES["file"]["error"] . "<br />";
            } else if (!(in_array(end(explode(".", $_FILES["userfile"]["name"])), array("c", "cpp", "java", "pas")))) {
                $this->session->set_flashdata('uploaderror', 'The filetype is not allowed');
            } else {
                if (file_exists(COMPILER_FOLDER . "upload/" . $_FILES["userfile"]["name"])) {
                    $this->session->set_flashdata('fileexist', $_FILES["userfile"]["name"]);
                    //echo $_FILES["userfile"]["name"] . " already exists. ";
                } else {
                    $problem     = $this->input->post('submitproblem');
                    $time        = now();
                    $username    = $this->session->userdata('username');
                    $participant = $this->session->userdata('participantid');
                    $fname       = $_FILES["userfile"]["name"];
                    $fileformat  = $problem . "_-_" . $username . "_-_" . $fname;

                    $exploder  = explode(".", $fname);
                    $validator = preg_replace('/[^0-9a-z\.]/i', '', $fname);

                    if (count($exploder) > 2) {
                        $this->session->set_flashdata('uploaderror', 'Filename only can contains single dot(.) for file extension');
                    } else if ($validator != $fname) {
                        $this->session->set_flashdata('uploaderror', 'Please only use alphanumerics characters for filename 0-9 a-z');
                    } else {
                        $hashcode1 = do_hash($time . "_-_" . $fileformat, 'sha1');
                        $hashcode2 = do_hash($time, 'md5');

                        $hashcode = $hashcode1 . $hashcode2;

                        $fileformat = $time . "_-_" . $hashcode . "_-_" . $fileformat;

                        $this->load->model('Submitmodel');
                        $iid = $this->Submitmodel->SaveToDb($time, $problem, $participant, $fname, $hashcode);

                        $compilerCount = 1;

                        move_uploaded_file($_FILES["userfile"]["tmp_name"], COMPILER_FOLDER . "upload/" . $fileformat);

                        $this->session->set_flashdata('uploadok', 'File Uploaded Successfully yeeeee');
                        redirect(site_url() . '/solution');
                    }
                }
            }
            redirect(site_url() . '/submit');
        }
    }
}

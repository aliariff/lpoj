<?php

class UploadTestCase extends CI_Controller
{

    public function prob($id)
    {
        $ceksess  = $this->Usermodel->checkSessionProbset();
        $ceksess2 = $this->Adminmodel->checkSession();
        if ($ceksess == false && $ceksess2 == false || !$id) {
            redirect(site_url() . '/login');
        } else if ($ceksess2) {
            $data = array('problemid' => $id);
            $this->load->view('addTestCase', $data);
        } else {
            $user = $this->session->userdata('username');
            $q    = 'SELECT problem_id FROM pc_problem WHERE user_name = "' . $user . '" and problem_id = "' . $id . '"';
            $qr   = $this->db->query($q);
            if ($qr->num_rows() > 0) {
                $data = array('problemid' => $id);
                $this->load->view('addTestCase', $data);
            } else {
                redirect(site_url() . '/probset');
            }
        }
    }

    public function upload()
    {
        $ceksess  = $this->Usermodel->checkSessionProbset();
        $ceksess2 = $this->Adminmodel->checkSession();
        if ($ceksess == false && $ceksess2 == false) {
            redirect(site_url() . '/login');
        } else {
            $size = $this->input->post('size');
            $pid  = $this->input->post('pid');
            //CAMIN
            if (isset($_FILES["zip"]) && $_FILES["zip"]["tmp_name"] != "") {

                //delete all testcase PID

                $user = $this->session->userdata('username');
                $q    = "delete from pc_testcase where inputcase like 'testCase" . $pid . "%'";
                $qr   = $this->db->query($q);
                exec("rm " . COMPILER_FOLDER . "inputcase/testCase" . $pid . "*");

                exec("rm " . COMPILER_FOLDER . "outputcase/hasil" . $pid . "*");
                //

                $zip_temp = COMPILER_FOLDER . "zip_temp/";
                $zip      = new ZipArchive;
                if ($zip->open($_FILES["zip"]["tmp_name"]) === true) {
                    $zip->extractTo($zip_temp);
                    $zip->close();
                    //echo 'ZIP opened successfuly';
                } else {
                    //echo 'ZIP failed to open';
                }
                if ($dir = opendir($zip_temp)) {
                    $size = 1;
                    while (($file = readdir($dir)) !== false) {
                        //echo $file;
                        $filename = explode(".", $file);

                        if ($filename[1] == "in") {
                            exec("mv " . $zip_temp . $file . " " . COMPILER_FOLDER . "inputcase/testCase" . $pid . "_" . $filename[0]);
                            echo "mv " . $zip_temp . $file . COMPILER_FOLDER . "inputcase/testCase" . $pid . "_" . $filename[0];
                            //Membuat bayangan $_FILES[picase]
                            $_FILES["picase" . $filename[0]]["tmp_name"] = $zip_temp . $file;
                            $_FILES["picase" . $filename[0]]["error"]    = 0;
                        } else if ($filename[1] == "out") {
                            exec("mv " . $zip_temp . $file . " " . COMPILER_FOLDER . "outputcase/hasil" . $pid . "_" . $filename[0]);
                            //Membuat bayangan $_FILES[picase]
                            $_FILES["pocase" . $filename[0]]["tmp_name"] = $zip_temp . $file;
                            $_FILES["pocase" . $filename[0]]["error"]    = 0;
                            $size++;
                        } else if ($filename[1] == "txt") {
                            $txt = fopen($zip_temp . $file, 'r');
                            $i   = 1;
                            while ($line = fgets($txt)) {

                                $score = preg_split('/ |\r\n|\r|\n/', $line);
                                //print_r($score);
                                for ($j = 0; $j < count($score); $j++) {
                                    if (!is_numeric($score[$j])) {
                                        continue;
                                    }

                                    $_POST['pros' . $i++] = $score[$j];
                                }
                            }
                            fclose($txt);
                            exec("rm " . $zip_temp . $file);
                        }
                    }
                    $size--;
                    closedir($dir);
                } else {
                    echo "can't opendir()";
                }

            }
            //END

            for ($i = 1; $i <= $size; $i++) {
                if ($_FILES["picase" . $i]["error"] > 0) {
                    if (file_exists(COMPILER_FOLDER . "inputcase/testCase" . $pid . "_" . $i)) {
                        //echo $_FILES["file"]["name"] . " already exists. ";
                    } else {
                        $myFile = COMPILER_FOLDER . "inputcase/testCase" . $pid . "_" . $i;
                        $fh     = fopen($myFile, 'w');
                        fwrite($fh, "");
                        fclose($fh);
                        exec("fromdos " . COMPILER_FOLDER . "inputcase/testCase" . $pid . "_" . $i);
                    }
                } else {
                    move_uploaded_file($_FILES["picase" . $i]["tmp_name"],
                        COMPILER_FOLDER . "inputcase/testCase" . $pid . "_" . $i);
                    exec("fromdos " . COMPILER_FOLDER . "inputcase/testCase" . $pid . "_" . $i);
                }

                if ($_FILES["pocase" . $i]["error"] > 0) {
                    if (file_exists(COMPILER_FOLDER . "outputcase/hasil" . $pid . "_" . $i)) {
                        //echo $_FILES["file"]["name"] . " already exists. ";
                    } else {
                        $myFile = COMPILER_FOLDER . "outputcase/hasil" . $pid . "_" . $i;
                        $fh     = fopen($myFile, 'w');
                        fwrite($fh, "");
                        fclose($fh);
                        exec("fromdos " . COMPILER_FOLDER . "outputcase/hasil" . $pid . "_" . $i);
                    }

                } else {
                    move_uploaded_file($_FILES["pocase" . $i]["tmp_name"],
                        COMPILER_FOLDER . "outputcase/hasil" . $pid . "_" . $i);
                    exec("fromdos " . COMPILER_FOLDER . "outputcase/hasil" . $pid . "_" . $i);
                }

                $newdata = array(
                    'problem_id' => $pid,
                    'inputcase'  => "testCase" . $pid . "_" . $i,
                    'outputcase' => "hasil" . $pid . "_" . $i,
                    'persentase' => $this->input->post('pros' . $i),
                );
                $a  = "testCase" . $pid . "_" . $i;
                $q  = 'SELECT persentase FROM pc_testcase WHERE inputcase = "' . $a . '" ';
                $qr = $this->db->query($q);
                if (!$qr->num_rows()) {
                    $this->db->insert("pc_testcase", $newdata);
                }
                foreach ($qr->result() as $row) {
                    if ($row->persentase != $this->input->post('pros' . $i)) {
                        $this->db->where('inputcase', $a);
                        $this->db->update('pc_testcase', $newdata);
                    }
                }

            }
            redirect(site_url() . '/uploadtestcase/prob/' . $pid);
        }
    }
    public function deletetestcase()
    {
        $ceksess  = $this->Usermodel->checkSessionProbset();
        $ceksess2 = $this->Adminmodel->checkSession();
        if ($ceksess == false && $ceksess2 == false) {
            redirect(site_url() . '/login');
        } else {
            $val = $this->input->post('hidden1');
            $pid = $this->input->post('hidden2');

            $user = $this->session->userdata('username');
            $q    = 'SELECT problem_id FROM pc_problem WHERE user_name = "' . $user . '" and problem_id = "' . $pid . '"';
            $qr   = $this->db->query($q);
            if ($qr->num_rows() > 0 || $ceksess2) {
                $q  = "delete from pc_testcase where inputcase = '" . $val . "'";
                $qr = $this->db->query($q);
                exec("rm " . COMPILER_FOLDER . "inputcase/" . $val);
                $val = str_replace("testCase", "hasil", $val);
                exec("rm " . COMPILER_FOLDER . "outputcase/" . $val);
            }
            redirect(site_url() . '/uploadtestcase/prob/' . $pid);
        }
    }
}

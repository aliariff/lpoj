<?php

class Probset extends CI_Controller
{

    public function index()
    {
        //checking user session
        $ceksess = $this->Usermodel->checkSessionProbset();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->load->view('probset_home');
        }
    }

    public function addContest()
    {
        $ceksess = $this->Usermodel->checkSessionProbset();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $contestname = $this->input->post("conname");
            if ($contestname) {
                $user = $this->session->userdata('username');
                $this->db->query("insert into pc_contest(CONTEST_NAME,CONTEST_START,CONTEST_FREEZE,CONTEST_END,USER_NAME) values ('" . $contestname . "',0,0,0,'" . $user . "')");
                $this->db->query("insert into pc_probset(CONTEST_ID, USER_NAME, PROBSET_STATUS) values ('" . $this->db->insert_id() . "', '" . $user . "', 1)");
                redirect(site_url() . '/probset');
            } else {
                $this->load->view('probset_contest');
            }

        }
    }

    public function addProblem()
    {
        $ceksess = $this->Usermodel->checkSessionProbset();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->Probsetmodel->addProblem();
        }
    }

    public function addParticipant()
    {
        $ceksess = $this->Usermodel->checkSessionProbset();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $data["contest"] = $this->Probsetmodel->getAllMyContest();
            $this->load->view('probset_participant', $data);
        }
    }

    public function changePass()
    {
        $ceksess = $this->Usermodel->checkSessionProbset();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $data['username'] = $this->session->userdata('username');
            $this->load->view('probset_changepass', $data);
        }
    }

    public function editPass()
    {
        $ceksess = $this->Usermodel->checkSessionProbset();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $username = $this->session->userdata('username');
            $pass     = $this->input->post("new-password");
            $repass   = $this->input->post("re-password");
            $stat     = $this->input->post("edit-status");

            if ($username && $pass && ($pass == $repass)) {
                $hash = do_hash($pass, 'sha1');
                $q    = "	UPDATE pc_user
						SET user_password='" . $hash . "', user_status='2'
						WHERE user_name='" . $username . "' ";
                $this->db->query($q);
            } else if (!$pass && !$repass) {
                $q = "	UPDATE pc_user
						SET user_status='2'
						WHERE user_name='" . $username . "' ";
                $this->db->query($q);
            }
            redirect(site_url() . '/probset/changePass');
        }
    }

    public function getAddParticipant()
    {
        $ceksess = $this->Usermodel->checkSessionProbset();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $contest_id = $this->input->post("contest_id");
            if ($this->input->post("view")) {
                redirect(site_url() . '/probset/viewParticipantInContest/' . $contest_id);
            } else {
                $users = $this->input->post("user_names");
                $mode  = $this->input->post("mode");
                $users = explode("\n", $users);

                if ($mode == 1) {
                    $participant = array();
                    $this->db->trans_start();
                    foreach ($users as $i) {
                        if ($i == null || $i == "") {
                            continue;
                        }

                        $i  = str_replace("\r", '', $i);
                        $q  = "select * from pc_participant where user_name='" . $i . "' and contest_id='" . $contest_id . "'";
                        $qr = $this->db->query($q);
                        if ($qr->num_rows() > 0) {
                            continue;
                        }

                        $p = array("USER_NAME" => $i, "CONTEST_ID" => $contest_id);
                        $this->db->insert("pc_participant", $p);
                        array_push($participant, $p);
                    }
                    $this->db->trans_complete();
                    redirect(site_url() . '/probset/addParticipant');
                } else if ($mode == 2) {
                    foreach ($users as $i) {
                        if ($i == null || $i == "") {
                            continue;
                        }

                        $i = str_replace("\r", '', $i);
                        $q = "delete from pc_participant where user_name='" . $i . "' and contest_id='" . $contest_id . "'";
                        $this->db->query($q);
                    }
                    redirect(site_url() . '/probset/addParticipant');
                }
            }
        }
    }

    public function viewParticipantInContest($contestid)
    {
        $ceksess = $this->Usermodel->checkSessionProbset();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $user = $this->session->userdata('username');
            $q    = "select * from pc_contest where user_name='" . $user . "' and contest_id = '" . $contestid . "'";
            $qr   = $this->db->query($q);
            if ($qr->num_rows() > 0) {
                $this->Probsetmodel->viewParticipantInContest($contestid);
            } else {
                redirect(site_url() . '/probset/addParticipant');
            }
        }
    }

    public function problem($pid)
    {
        $ceksess = $this->Usermodel->checkSessionProbset();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $user = $this->session->userdata('username');
            $q    = 'SELECT problem_id FROM pc_problem WHERE user_name = "' . $user . '" and problem_id = "' . $pid . '"';
            $qr   = $this->db->query($q);
            if ($qr->num_rows() > 0) {
                $data = array('problemid' => $pid);
                $this->load->view('probset_problem', $data);
            } else {
                redirect(site_url() . '/probset');
            }
        }
    }

    public function detailProblem()
    {
        $ceksess = $this->Usermodel->checkSessionProbset();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $problemid = $this->input->post('problem');
            redirect(site_url() . '/probset/problem/' . $problemid);
        }
    }

    public function editProblem()
    {

        $ceksess = $this->Usermodel->checkSessionProbset();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $pid      = $this->input->post('pid');
            $ptitle   = $this->input->post('ptitle');
            $pcreator = $this->input->post('pcreator');
            $pcontent = $this->input->post('pcontent');

            if (isset($_FILES["picase"]) && $_FILES["picase"]["error"] > 0) {
                if (file_exists("/root/pclp/inputcase/testCase" . $pid)) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    $myFile = "/root/pclp/inputcase/testCase" . $pid;
                    $fh     = fopen($myFile, 'w');
                    fwrite($fh, "");
                    fclose($fh);
                    exec("fromdos /root/pclp/inputcase/testCase" . $pid);
                }
            } else if (isset($_FILES["picase"])) {
                move_uploaded_file($_FILES["picase"]["tmp_name"],
                    "/root/pclp/inputcase/testCase" . $pid);
                exec("fromdos /root/pclp/inputcase/testCase" . $pid);
            }

            if (isset($_FILES["pocase"]) && $_FILES["pocase"]["error"] > 0) {
                if (file_exists("/root/pclp/outputcase/hasil" . $pid)) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    $myFile = "/root/pclp/outputcase/hasil" . $pid;
                    $fh     = fopen($myFile, 'w');
                    fwrite($fh, "");
                    fclose($fh);
                    exec("fromdos /root/pclp/outputcase/hasil" . $pid);
                }

            } else if (isset($_FILES["pocase"])) {
                move_uploaded_file($_FILES["pocase"]["tmp_name"],
                    "/root/pclp/outputcase/hasil" . $pid);
                exec("fromdos /root/pclp/outputcase/hasil" . $pid);
            }

            $picase = "testCase" . $pid;
            $pocase = "hasil" . $pid;

            $prunning = $this->input->post('prunning');
            $pmemory  = $this->input->post('pmemory');

            $myFile = "/root/pclp/limiter/limit" . $pid;
            $fh     = fopen($myFile, 'w');
            fwrite($fh, $prunning);
            fclose($fh);

            $myFile = "/root/pclp/memory/memory" . $pid;
            $fh     = fopen($myFile, 'w');
            fwrite($fh, $pmemory);
            fclose($fh);

            $myFile = "/root/pclp/tollerance/toll" . $pid;
            $fh     = fopen($myFile, 'w');
            fwrite($fh, "0");
            fclose($fh);

            $update = array(
                'problem_title'     => $ptitle,
                'problem_creator'   => $pcreator,
                'problem_content'   => $pcontent,
                'PROBLEM_INPUTCASE' => $picase,
                'PROBLEM_OUTPUCASE' => $pocase,
                'problem_runtime'   => $prunning,
                'problem_memory'    => $pmemory,
            );
            $this->db->where('problem_id', $pid);
            $this->db->update('pc_problem', $update);
            redirect('probset/problem/' . $pid);
        }
    }
}

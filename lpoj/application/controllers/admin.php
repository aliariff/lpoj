<?php

class Admin extends CI_Controller
{

    public function index()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->load->view('admin_home');
        }
    }

    public function problem($pid)
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $q  = 'select problem_id from pc_problem where problem_id = ' . $pid . '';
            $qr = $this->db->query($q);
            if ($qr->num_rows > 0) {
                $data = array('problemid' => $pid);
                $this->load->view('admin_problem', $data);
            } else {
                redirect(site_url() . '/admin');
            }
        }
    }

    public function detailProblem()
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $problemid = $this->input->post('problem');
            redirect(site_url() . '/admin/problem/' . $problemid);
        }
    }

    public function addContest()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $contestname = $this->input->post("conname");
            if ($contestname) {
                $user = $this->session->userdata('username');
                $this->db->query("insert into pc_contest(CONTEST_NAME,CONTEST_START,CONTEST_FREEZE,CONTEST_END,USER_NAME) values ('" . $contestname . "',0,0,0,'" . $user . "')");
                redirect(site_url() . '/admin');
            } else {
                $this->load->view('admin_contest');
            }

        }
    }

    public function addProblem()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->Adminmodel->addProblem();
        }
    }

    public function addParticipant()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $data["contest"] = $this->Adminmodel->getAllContest();
            $this->load->view('admin_participant', $data);
        }
    }

    public function getAddParticipant()
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $contest_id = $this->input->post("contest_id");
            if ($this->input->post("view")) {
                redirect(site_url() . '/admin/viewParticipantInContest/' . $contest_id);
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
                    redirect(site_url() . '/admin/addParticipant');
                } else if ($mode == 2) {
                    foreach ($users as $i) {
                        if ($i == null || $i == "") {
                            continue;
                        }

                        $i = str_replace("\r", '', $i);
                        $q = "delete from pc_participant where user_name='" . $i . "' and contest_id='" . $contest_id . "'";
                        $this->db->query($q);
                    }
                    redirect(site_url() . '/admin/addParticipant');
                }
            }
        }
    }

    public function viewParticipantInContest($contestid)
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->Adminmodel->viewParticipantInContest($contestid);
        }
    }

    public function editProblem()
    {

        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $pid      = $this->input->post('pid');
            $ptitle   = $this->input->post('ptitle');
            $pcreator = $this->input->post('pcreator');
            $pcontent = $this->input->post('pcontent');

            if (isset($_FILES["picase"]["error"]) && $_FILES["picase"]["error"] > 0) {
                if (file_exists("/root/pclp/inputcase/testCase" . $pid)) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    $myFile = "/root/pclp/inputcase/testCase" . $pid;
                    $fh     = fopen($myFile, 'w');
                    fwrite($fh, "");
                    fclose($fh);
                    exec("fromdos /root/pclp/inputcase/testCase" . $pid);
                }
            } else {
                move_uploaded_file($_FILES["picase"]["tmp_name"],
                    "/root/pclp/inputcase/testCase" . $pid);
                exec("fromdos /root/pclp/inputcase/testCase" . $pid);
            }

            if ($_FILES["pocase"]["error"] > 0) {
                if (file_exists("/root/pclp/outputcase/hasil" . $pid)) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    $myFile = "/root/pclp/outputcase/hasil" . $pid;
                    $fh     = fopen($myFile, 'w');
                    fwrite($fh, "");
                    fclose($fh);
                    exec("fromdos /root/pclp/outputcase/hasil" . $pid);
                }

            } else {
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
            redirect('admin/problem/' . $pid);
        }
    }

    public function deleteContest()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {

            $contestid = $this->input->post('contest');
            $probans   = $this->input->post('probans');
            $deleteans = $this->input->post('deleteans');

            if ($contestid && ($deleteans == $probans)) {
                $q  = "select participant_id from pc_participant pcp where pcp.contest_id='" . $contestid . "'";
                $qr = $this->db->query($q);
                foreach ($qr->result() as $row) {
                    $q = "delete from pc_submit where participant_id='" . $row->participant_id . "'";
                    $this->db->query($q);
                    $q = "delete from pc_clarification where participant_id='" . $row->participant_id . "'";
                    $this->db->query($q);
                    $q = "delete from pc_participant where participant_id='" . $row->participant_id . "'";
                    $this->db->query($q);
                }

                $q = "delete from pc_detcon where contest_id = '" . $contestid . "' ";
                $this->db->query($q);
                $q = "delete from pc_contest where contest_id = '" . $contestid . "'";
                $this->db->query($q);
            }
            redirect(site_url() . '/admin');

        }
    }

    public function deleteProblem()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {

            $probid    = $this->input->post('probid');
            $probans   = $this->input->post('probans');
            $deleteans = $this->input->post('deleteans');

            if ($deleteans == $probans) {
                $q = "delete from pc_submit where problem_id='" . $probid . "'";
                $this->db->query($q);

                $q = "delete from pc_detcon where problem_id='" . $probid . "'";
                $this->db->query($q);

                $q = "delete from pc_problem where problem_id='" . $probid . "'";
                $this->db->query($q);

                redirect(site_url() . '/admin');
            } else {
                redirect('admin/problem/' . $probid);
            }

        }
    }

    public function userPrivilege()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $data["alluser"] = $this->Adminmodel->getAllUser();
            $this->load->view('admin_user', $data);
        }
    }

    public function addUser()
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $username = $this->input->post("username");
            $pass     = $this->input->post("password");
            $stat     = $this->input->post("status");

            if ($username && $pass) {
                $q  = "select * from pc_user where user_name='" . $username . "' ";
                $qr = $this->db->query($q);
                if ($qr->num_rows() > 0) {
                    redirect(site_url() . '/admin/userPrivilege');
                }

                $newdata = array(
                    'user_name'     => $username,
                    'user_password' => do_hash($pass, 'sha1'),
                    'user_status'   => $stat,
                );
                $this->db->insert("pc_user", $newdata);
            }

            redirect(site_url() . '/admin/userPrivilege');
        }

    }

    public function editUser()
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $username = $this->input->post("usernameid");
            $pass     = $this->input->post("new-password");
            $repass   = $this->input->post("re-password");
            $stat     = $this->input->post("edit-status");

            if ($username && $pass && ($pass == $repass)) {
                $hash = do_hash($pass, 'sha1');
                $q    = "   UPDATE pc_user
                        SET user_password='" . $hash . "', user_status='" . $stat . "'
                        WHERE user_name='" . $username . "' ";
                $this->db->query($q);
            } else if (!$pass && !$repass) {
                $q = "  UPDATE pc_user
                        SET user_status='" . $stat . "'
                        WHERE user_name='" . $username . "' ";
                $this->db->query($q);
            }

            redirect(site_url() . '/admin/userPrivilege');
        }
    }

    public function deleteUser()
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $username = $this->input->post("usernameid1");

            if ($username) {
                $q = "  delete from pc_user
                        WHERE user_name='" . $username . "' ";
                $this->db->query($q);
            }

            redirect(site_url() . '/admin/userPrivilege');
        }
    }

    public function daemon()
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $this->load->view('admin_daemon');
        }
    }

    public function checkDaemon()
    {
        $ceksess = $this->Adminmodel->checkSession();
        if ($ceksess == false) {
            redirect(site_url() . '/login');
        } else {
            $id   = $this->input->post("id");
            $stat = $this->input->post("stat");
            if ($stat == "on") {
                system("./stopdaemon");
                system("./startdaemon");
            } else if ($stat == "off") {
                system("./stopdaemon");
            }
        }
    }

/*
function addUserall()
{
$ceksess = $this->Adminmodel->checkSession();
if ($ceksess == FALSE){
redirect(site_url().'/login');
}
else
{
$data = array(
// isi nrp di sini
5116100001, 5116100002, ....
// jalankan /admin/addUserall
);

foreach($data as $d){
$username = (string)$d;
$pass = (string)$d;
$stat = 3;

if($username && $pass)
{
$q = "select * from pc_user where user_name='".$username."' ";
$qr = $this->db->query($q);
if ($qr->num_rows() > 0)redirect(site_url().'/admin/userPrivilege');
$newdata = array(
'user_name' => $username,
'user_password' => do_hash($pass,'sha1'),
'user_status' => $stat
);
$this->db->insert("pc_user",$newdata);
}
}

redirect(site_url().'/admin/userPrivilege');
}

}
 */
}

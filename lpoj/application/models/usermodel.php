<?php

class Usermodel extends CI_Model
{

    public function getFullName($username)
    {
        $q   = "SELECT user_fullname FROM pc_user WHERE user_name=" . $this->db->escape($username);
        $qr  = $this->db->query($q);
        $row = $qr->first_row();
        return $row->user_fullname;
    }
    public function getAll()
    {
        $q = $this->db->get("pc_user");
        return $q->result();
    }
    public function setFullName($username, $fullname)
    {
        $newdata = array(
            'user_name'     => $username,
            'user_fullname' => $fullname,
        );
        $this->db->where('user_name', $username);
        $this->db->update('pc_user', $newdata);
        $this->session->set_flashdata(array('detailok' => 'User Detail Updated'));
    }

    public function changePassword($user, $newpass)
    {
        $newdata = array(
            'user_name'     => $user,
            'user_password' => do_hash($newpass, 'sha1'),
        );
        $this->db->where('user_name', $user);
        $this->db->update('pc_user', $newdata);
    }

    public function checkPassword($user, $pass)
    {
        $q = "SELECT user_name, user_lastip, user_status FROM pc_user WHERE user_name=" .
        $this->db->escape($user) . " AND user_password=" .
        $this->db->escape(do_hash($pass, 'sha1'));
        $qr = $this->db->query($q);
        $ip = $this->input->ip_address();

        $this->load->helper('date');
        $key = $ip . now();

        if ($qr->num_rows() > 0) {
            $result = $qr->first_row();
            $sess   = array(
                'username'      => $result->user_name,
                'sessionkey'    => do_hash($key, 'sha1'),
                'participantid' => -1,
                'userstatus'    => $result->user_status,
                'is_logged_in'  => true,
            );
            $this->session->set_userdata($sess);
            $data = array(
                'user_lastip'     => $ip,
                'user_sessionkey' => do_hash($key, 'sha1'),
            );

            $this->db->where('user_name', $user);
            $this->db->update('pc_user', $data);
        } else {
            $this->session->sess_destroy();
        }
        redirect(site_url() . '/login');
    }

    public function checkBoolPass($user, $pass)
    {
        $q = "SELECT user_name FROM pc_user WHERE user_name=" .
        $this->db->escape($user) . " AND user_password=" .
        $this->db->escape(do_hash($pass, 'sha1'));
        $qr = $this->db->query($q);

        if ($qr->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPrev($idSubmit)
    {
        $user = $this->session->userdata('username');
        //echo "select count(SUBMIT_ID) as a from pc_submit join pc_participant on pc_participant.USER_NAME='$user' and submit_ID=$idSubmit";
        $query = $this->db->query("select count(SUBMIT_ID) as a from pc_submit join pc_participant on pc_participant.USER_NAME='$user' and submit_ID=$idSubmit");
        $res   = $query->result();
        //echo $res;
        if ($res[0]->a == 1) {
            return true;
        } else {
            return false;
        }

    }

    public function checkSession()
    {
        $user = $this->session->userdata('username');
        $key  = $this->session->userdata('sessionkey');
        $ip   = $this->input->ip_address();
        if (!$user) {
            return false;
        }

        $this->load->helper('date');

        $q  = "SELECT user_lastip, user_sessionkey,user_status FROM pc_user WHERE user_name=" . $this->db->escape($user);
        $qr = $this->db->query($q);

        $row = $qr->first_row();
        if ($row->user_lastip == $ip && $row->user_sessionkey == $key && $row->user_status == 3) {
            return true;
        } else {
            //$this->session->sess_destroy();
            return false;
        }
    }

    public function checkSessionSubmission($submit_username)
    {
        $user = $this->session->userdata('username');
        $key  = $this->session->userdata('sessionkey');
        $ip   = $this->input->ip_address();
        if (!$user) {
            return false;
        }

        $this->load->helper('date');
        if ($user == $submit_username || $this->Usermodel->checkSessionProbset() || $this->Adminmodel->checkSession()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkSessionProbset()
    {
        $user = $this->session->userdata('username');
        $key  = $this->session->userdata('sessionkey');
        $ip   = $this->input->ip_address();
        if (!$user) {
            return false;
        }

        $this->load->helper('date');

        $q  = "SELECT user_lastip, user_sessionkey, user_status FROM pc_user WHERE user_name=" . $this->db->escape($user);
        $qr = $this->db->query($q);

        $row = $qr->first_row();
        if ($row->user_lastip == $ip && $row->user_sessionkey == $key && $row->user_status == 2) {
            return true;
        } else {
            //$this->session->sess_destroy();
            return false;
        }
    }

    public function checkStatus()
    {
        $user = $this->session->userdata('username');
        if ($user) {
            $sql = "SELECT user_status from pc_user where user_name=" . $this->db->escape($user);
            $qr  = $this->db->query($sql);
            $row = $qr->first_row();
            return $row->user_status;
        }
        return false;
    }

    public function checkContestSession()
    {
        $participant = $this->session->userdata('participantid');
        $now         = now();

        if ($participant != -1) {
            $q  = "SELECT participant_id, user_name, contest_id FROM pc_participant WHERE participant_id= '" . $participant . "'";
            $qr = $this->db->query($q);
            if ($qr->num_rows() > 0) {
                $row = $qr->first_row();
                $cid = $row->contest_id;

                $qtime   = "SELECT contest_start, contest_end FROM pc_contest WHERE contest_id=" . $cid;
                $qrtime  = $this->db->query($qtime);
                $rowtime = $qrtime->first_row();
                if ($rowtime->contest_start > $now || $rowtime->contest_end < $now) {

                    $newdata = array(
                        'username'      => $this->session->userdata('username'),
                        'sessionkey'    => $this->session->userdata('sessionkey'),
                        'participantid' => -1,
                    );
                    $this->session->set_userdata($newdata);
                    $this->session->set_flashdata('contesterror', 'Not in Contest Time');
                    return false;
                } else {
                    $updatepar = array(
                        'participant_lastactive' => now(),
                    );
                    $this->db->where('participant_id', $participant);
                    $this->db->update('pc_participant', $updatepar);
                    return true;
                }

            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

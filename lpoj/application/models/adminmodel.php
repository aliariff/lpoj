<?php

class Adminmodel extends CI_Model
{

    public function checkSession()
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
        if ($row->user_lastip == $ip && $row->user_sessionkey == $key && $row->user_status == 1) {
            return true;
        } else {
            //$this->session->sess_destroy();
            return false;
        }
    }

    public function getAllContest()
    {
        $q  = 'SELECT * FROM pc_contest order by contest_id desc';
        $qr = $this->db->query($q);
        return $qr->result();
    }

    public function deleteContest()
    {
        $q  = 'SELECT contest_id, contest_name FROM pc_contest order by contest_id desc';
        $qr = $this->db->query($q);

        if ($qr->num_rows() > 0) {
            $quest1 = rand(1, 10);
            $quest2 = rand(1, 10);
            $answer = $quest1 + $quest2;

            echo "<form method='post' action='" . site_url() . "/admin/deleteContest'>";
            echo "<select name='contest'>";
            foreach ($qr->result() as $row) {
                echo "<option value='" . $row->contest_id . "'>" . $row->contest_id . " - " . character_limiter($row->contest_name, 25) . "</option>";
            }
            echo "</select><br />";
            echo "<input type=\"hidden\" name=\"probans\" value='$answer' />";
            echo "Answer to delete contest : $quest1 + $quest2 = <input type=\"text\" name=\"deleteans\" />";
            echo "<br/>";
            echo "<input type='submit' value='Delete This Contest' name='contestselect' />";
            echo "</form>";
            echo "<br />";
        } else {
            echo "Cannot Load Contest";
        }
    }

    public function comboAllContest()
    {
        $q  = 'SELECT contest_id, contest_name FROM pc_contest order by contest_id desc';
        $qr = $this->db->query($q);

        if ($qr->num_rows() > 0) {
            echo "<form method='post' action='" . site_url() . "/contest'>";
            echo "<select name='contest'>";
            foreach ($qr->result() as $row) {
                echo "<option value='" . $row->contest_id . "'>" . $row->contest_id . " - " . character_limiter($row->contest_name, 25) . "</option>";
            }
            echo "</select><br />";
            echo "<input type='submit' value='Manage This Contest' name='contestselect' />";
            echo "</form>";
            echo "<br />";
        } else {
            echo "Cannot Load Contest";
        }
    }

    public function comboAllProblem()
    {
        $q  = 'SELECT problem_id, problem_title FROM pc_problem order by problem_id desc';
        $qr = $this->db->query($q);

        if ($qr->num_rows() > 0) {
            echo "<form method='post' action='" . site_url() . "/admin/detailProblem'>";
            echo "<select name='problem'>";
            foreach ($qr->result() as $row) {
                echo "<option value='" . $row->problem_id . "'>" . $row->problem_id . " - " . character_limiter($row->problem_title, 25) . "</option>";
            }
            echo "</select><br />";
            echo "<input type='submit' value='Edit This Problem' name='contestselect' />";
            echo "</form>";
            echo "<br />";
        } else {
            echo "Cannot Load Problem";
        }
    }

    public function addProblem()
    {
        $ceksess = $this->Adminmodel->checkSession();

        if ($ceksess == false) {
            redirect(site_url() . '/admin');
        } else {
            $data = array(
                'problem_title'   => 'New Problem',
                'problem_content' => 'New Problem Content',
                'problem_creator' => 'PCLP',
                'problem_runtime' => '1',
                'problem_memory'  => '16777216',
                'user_name'       => $this->session->userdata('username'),
            );

            $this->db->insert('pc_problem', $data);
            $newid = $this->db->insert_id();

            $myFile = COMPILER_FOLDER . "limiter/limit" . $newid;
            $fh     = fopen($myFile, 'w');
            fwrite($fh, "1");
            fclose($fh);

            $myFile = COMPILER_FOLDER . "memory/memory" . $newid;
            $fh     = fopen($myFile, 'w');
            fwrite($fh, "16777216");
            fclose($fh);

            redirect('admin/problem/' . $newid);
        }
    }

    public function viewParticipantInContest($contestid)
    {
        $q  = "select participant_id, user_name from pc_participant where contest_id='" . $contestid . "' ";
        $qr = $this->db->query($q);
        $no = 1;
        echo "<table border='1' width='25%'>";
        echo "<tr align='center' bgcolor='#F77A0C'><td>No</td><td>Participant ID</td><td>Username</td></tr>";
        foreach ($qr->result() as $row) {
            echo "<tr><td>" . $no . "</td><td>" . $row->participant_id . "</td><td>" . $row->user_name . "</td></tr>";
            $no++;
        }
        echo "</table>";
    }

    public function getAllUser()
    {
        $q  = 'SELECT user_name FROM pc_user';
        $qr = $this->db->query($q);
        return $qr->result();
    }

}

<?php

class Contestmodel extends CI_Model
{

    public function getAll()
    {
        $q = $this->db->get("pc_contest");
        return $q->result();
    }

    public function checkContestSession()
    {
        $id = $this->session->userdata('contestid');
        if (!$id) {
            return false;
        }

        return true;
    }

    public function getContestName()
    {
        $id = $this->session->userdata('contestid');
        $q  = "SELECT contest_name FROM pc_contest WHERE contest_id=" . $id;
        $qr = $this->db->query($q);
        return $qr->first_row()->contest_name;
    }

    public function getContestDescription()
    {
        $id = $this->session->userdata('contestid');
        $q  = "SELECT contest_description FROM pc_contest WHERE contest_id=" . $id;
        $qr = $this->db->query($q);
        return $qr->first_row()->contest_description;
    }

    public function getContestStart()
    {
        $id = $this->session->userdata('contestid');
        $q  = "SELECT contest_start FROM pc_contest WHERE contest_id=" . $id;
        $qr = $this->db->query($q);
        return unix_to_human($qr->first_row()->contest_start);
    }

    public function getContestFreeze()
    {
        $id = $this->session->userdata('contestid');
        $q  = "SELECT contest_freeze FROM pc_contest WHERE contest_id=" . $id;
        $qr = $this->db->query($q);
        return unix_to_human($qr->first_row()->contest_freeze);
    }

    public function getContestFreezeId($id)
    {
        $q  = "SELECT contest_freeze FROM pc_contest WHERE contest_id='" . $id . "'";
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            return $qr->first_row()->contest_freeze;
        }
        return 0;
    }

    public function getContestEnd()
    {
        $id = $this->session->userdata('contestid');
        $q  = "SELECT contest_end FROM pc_contest WHERE contest_id=" . $id;
        $qr = $this->db->query($q);
        return unix_to_human($qr->first_row()->contest_end);
    }

    public function getContestPenalty()
    {
        $id = $this->session->userdata('contestid');
        $q  = "SELECT contest_penalty FROM pc_contest WHERE contest_id=" . $id;
        $qr = $this->db->query($q);
        return $qr->first_row()->contest_penalty;
    }

    public function updateContestDetail($cname, $cdesc, $cstart, $cfreeze, $cend, $cpenalty)
    {
        $id   = $this->session->userdata('contestid');
        $data = array(
            'contest_name'        => $cname,
            'contest_description' => $cdesc,
            'contest_start'       => $cstart,
            'contest_freeze'      => $cfreeze,
            'contest_end'         => $cend,
            'contest_penalty'     => $cpenalty,
        );
        $this->db->where('contest_id', $id);
        $this->db->update('pc_contest', $data);
    }

    public function writeContestDesc($cid)
    {
        $q = '
      SELECT pccon.contest_id, pccon.contest_name, pccon.contest_description
      FROM pc_contest pccon
      WHERE pccon.contest_id = ' . $cid . '
    ';
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row = $qr->first_row();
            echo $row->contest_description;
        } else {
            echo "Cannot Load Contest Description";
        }
    }

    public function getContestDetail($cid)
    {
        $q = '
      SELECT pccon.contest_id, pccon.contest_name, pccon.contest_start, pccon.contest_end, pccon.contest_freeze, pccon.contest_penalty
      FROM pc_contest pccon
      WHERE pccon.contest_id = ' . $cid . '
    ';

        $qr  = $this->db->query($q);
        $row = $qr->first_row();

        $limit = now();
        $user  = "SELECT count(*) as sum FROM pc_participant WHERE ($limit - participant_lastactive) <= 600 AND contest_id = " . $row->contest_id;
        $userr = $this->db->query($user);

        if ($qr->num_rows() > 0) {
            echo "<table>";
            echo "<tr><td colspan='2'>[" . $row->contest_id . "] " . character_limiter($row->contest_name, 15) . "</td></tr>";
            echo "<tr><td>Start</td><td>: " . unix_to_human($row->contest_start) . "</td></tr>";
            echo "<tr><td>Frz</td><td>: " . unix_to_human($row->contest_freeze) . "</td></tr>";
            echo "<tr><td>End</td><td>: " . unix_to_human($row->contest_end) . "</td></tr>";
            echo "<tr><td>Pty</td><td>: " . $row->contest_penalty . " s</td></tr>";
            echo "<tr><td>Active</td><td>: " . $userr->first_row()->sum . " users</td></tr>";
            echo "</table>";
        } else {
            echo "Cannot Load Contest Detail";
        }
    }

    public function checkContestPassword($contestid, $contestpass)
    {
        $q = '
      SELECT pcc.contest_id
      FROM pc_contest pcc
      WHERE contest_id     = ' . $contestid . '
      AND contest_password = ' . $this->db->escape(dohash($contestpass, 'sha1')) . '
    ';
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row  = $qr->first_row();
            $data = array(
                'contestid' => $row->contest_id,
            );
            $this->session->set_userdata($data);
        } else {
            $this->session->sess_destroy();
        }
        redirect(site_url() . '/contest');
    }

    public function comboAvailableContest()
    {
        $now = now();
        $q   = "SELECT contest_id, contest_name FROM pc_contest WHERE contest_start < " . $now .
            " AND contest_end > " . $now;
        $qr = $this->db->query($q);

        if ($qr->num_rows() > 0) {
            echo "<form method='post' action='" . site_url() . "/contest_select'>";
            echo "<select name='contest'>";
            foreach ($qr->result() as $row) {
                echo "<option value='" . $row->contest_id . "'>" . $row->contest_id . " - " . character_limiter($row->contest_name, 30) . "</option>";
            }
            echo "</select><br />";
            echo "<input type='submit' value='Select Contest' name='contestselect' />";
            echo "</form>";
            echo "<br />";
        } else {
            echo "No Contest Available Now";
        }
    }

    public function comboAllProblem()
    {
        $q  = 'SELECT problem_id, problem_title FROM pc_problem order by problem_id desc';
        $qr = $this->db->query($q);

        if ($qr->num_rows() > 0) {
            echo "<form method='post' action='" . site_url() . "/contest/addProblem'>";
            echo "<select name='problem'>";
            foreach ($qr->result() as $row) {
                echo "<option value='" . $row->problem_id . "'>" . $row->problem_id . " - " . character_limiter($row->problem_title, 25) . "</option>";
            }
            echo "</select><br />";
            echo "<input type='submit' value='Add This Problem To Contest' name='problemselect' />";
            echo "</form>";
            echo "<br />";
        } else {
            echo "Cannot Load All Problem";
        }

        $contesterr = $this->session->flashdata('contesterror');
        if ($contesterr) {
            echo "<table width='50%' bgcolor='#ff7777'><tr><td align='center'>" . $contesterr . "</td></tr></table>";
        }
    }

    public function getParticipantNumber()
    {
        $CI = &get_instance();
        $CI->load->model('Participantmodel');
        $contestid = $CI->Participantmodel->getMyContestId();
        $q         = "SELECT participant_id FROM pc_participant WHERE contest_id=" . $contestid;
        $qr        = $this->db->query($q);
        return $qr->num_rows();
    }

    public function getParticipantNumberContest($id)
    {
        $q  = "SELECT participant_id FROM pc_participant WHERE contest_id=" . $id;
        $qr = $this->db->query($q);
        return $qr->num_rows();
    }

    public function isThisMyProblem($problemid)
    {
        $user = $this->session->userdata('username');
        $q    = "select problem_id from pc_problem where user_name = '" . $user . "' and problem_id='" . $problemid . "' ";
        $qr   = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            return true;
        }

        return false;
    }

    public function showRank($useFreeze = true, $contestid = null)
    {
        if (!$contestid) {
            $contestid = $this->session->userdata('contestid');
        }
        $contestid = str_replace("'", '', $contestid);
        if ($useFreeze) {
            $freeze_time = $this->getContestFreezeId($contestid);
        }
        $q  = "select participant_id, user_name from pc_participant where contest_id = '" . $contestid . "'";
        $qr = $this->db->query($q);

        $q1  = "select problem_id from pc_detcon where contest_id = '" . $contestid . "' order by problem_id asc";
        $qr1 = $this->db->query($q1);

        $data  = array();
        $data2 = array();
        foreach ($qr->result() as $row) {
            $data[$row->participant_id] = array("user_name" => $row->user_name);

            foreach ($qr1->result() as $row1) {
                $q2       = "select submit_id, submit_time, score from pc_submit where participant_id = '" . $row->participant_id . "' and problem_id = '" . $row1->problem_id . "'";
                $first_ac = "select submit_id, submit_time, score from pc_submit where participant_id = '" . $row->participant_id . "' and problem_id = '" . $row1->problem_id . "' and status_id = 7";
                if ($useFreeze) {
                    $q2 .= " and submit_time <= " . $freeze_time;
                    $first_ac .= " and submit_time <= " . $freeze_time;
                }
                $first_ac .= " order by submit_id asc";
                $first_ac_id = $this->db->query($first_ac);
                if ($first_ac_id->num_rows() > 0) {
                    $first_ac_id = $first_ac_id->first_row()->submit_id;
                } else {
                    $first_ac_id = 0;
                }
                $qr2        = $this->db->query($q2);
                $max        = 0;
                $submittime = 0;
                $submitid   = 0;
                $counter    = 0;
                foreach ($qr2->result() as $row2) {
                    if ($row2->submit_id <= $first_ac_id) {
                        $counter++;
                    }
                    if ($row2->score > $max) {
                        $max        = $row2->score;
                        $submitid   = $row2->submit_id;
                        $submittime = $row2->submit_time;
                    } else if ($row2->score == $max) {
                        if ($submittime > $row2->submit_time || $submittime == 0) {

                            $submitid   = $row2->submit_id;
                            $submittime = $row2->submit_time;
                        }
                    }
                }
                if ($counter == 0) {
                    $counter = $qr2->num_rows();
                }

                $newdata = array(
                    "counter"  => $counter,
                    "time"     => $submittime,
                    "score"    => $max,
                    "submitid" => $submitid,
                );
                array_push($data[$row->participant_id], $newdata);
            }
        }

        $ctr  = 0;
        $rank = array();
        foreach ($qr->result() as $row) {
            $totalscore = 0;
            $totaltime  = 0;
            for ($x = 0; $x < $qr1->num_rows(); $x++) {
                $totalscore += $data[$row->participant_id][$x]['score'];
                $totaltime += $data[$row->participant_id][$x]['time'];
            }
            $data2[$row->participant_id] = array("totalscore" => $totalscore, "totaltime" => $totaltime);
            $rank[$ctr]                  = $row->participant_id;
            $ctr++;
        }

        $array = $data2;

        for ($i = 0; $i < $ctr; $i++) {
            for ($j = 0; $j < $ctr; $j++) {
                if ($array[$rank[$i]]['totalscore'] < $array[$rank[$j]]['totalscore']) {
                    $temp     = $rank[$i];
                    $rank[$i] = $rank[$j];
                    $rank[$j] = $temp;
                }
                if ($array[$rank[$i]]['totalscore'] == $array[$rank[$j]]['totalscore']) {
                    if ($array[$rank[$i]]['totaltime'] > $array[$rank[$j]]['totaltime']) {
                        $temp     = $rank[$i];
                        $rank[$i] = $rank[$j];
                        $rank[$j] = $temp;
                    }
                }
            }
        }

        for ($i = 0; $i < $ctr; $i++) {
            for ($j = 0; $j < $ctr; $j++) {
                if ($array[$rank[$j]]['totalscore'] == 0 && $array[$rank[$j]]['totaltime'] == 0 && $array[$rank[$i]]['totalscore'] == 0 && $array[$rank[$i]]['totaltime'] == 0) {
                    if ($rank[$j] < $rank[$i]) {
                        $temp     = $rank[$i];
                        $rank[$i] = $rank[$j];
                        $rank[$j] = $temp;
                    }
                }
            }
        }

        $rank2 = $rank;
        $z     = 0;
        for ($i = $ctr - 1; $i >= 0; $i--) {
            if ($array[$rank2[$i]]['totaltime'] != 0) {
                $rank[$z] = $rank2[$i];
                $z++;
            }
        }
        for ($i = $ctr - 1; $i >= 0; $i--) {
            if ($array[$rank2[$i]]['totalscore'] == 0 && $array[$rank2[$i]]['totaltime'] == 0) {
                $rank[$z] = $rank2[$i];
                $z++;
            }
        }

        echo "<table border='1' width='100%'>";
        echo "<tr align='center' bgcolor='#F77A0C'><td>Rank</td><td>Username</td>";
        $this->Participantmodel->getParticipantProblem($contestid);
        echo "<td NOWRAP>Time</td>";
        echo "</tr>";

        for ($i = 0; $i < $ctr; $i++) {
            $temp = $i + 1;
            echo "<tr><td>" . $temp . "</td><td>" . $data[$rank[$i]]['user_name'] . "</td>";

            for ($x = 0; $x < $qr1->num_rows(); $x++) {
                $color = '';
                if ($data[$rank[$i]][$x]['time'] == 0) {
                    $wkt = 0;
                } else {
                    $wkt = unix_to_human($data[$rank[$i]][$x]['time']);
                }
                if ($data[$rank[$i]][$x]['counter'] > 0 && $data[$rank[$i]][$x]['score'] == 100) {
                    $color = '#77ff77';
                } else if ($data[$rank[$i]][$x]['counter'] > 0) {
                    $color = '#ff7777';
                }

                // echo "<td bgcolor='" . $color . "'>" . $data[$rank[$i]][$x]['counter'] . "/" . $data[$rank[$i]][$x]['time'] . "/" . $data[$rank[$i]][$x]['score'] . "</td>";
                echo "<td bgcolor='" . $color . "'>" . $data[$rank[$i]][$x]['counter'] . "/" . $wkt . "</td>";
            }
            // echo "<td>" . $data2[$rank[$i]]['totalscore'] . "/" . $data2[$rank[$i]]['totaltime'] . "</td>";
            echo "<td>" . $data2[$rank[$i]]['totaltime'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    public function getProbsetStatus()
    {
        $user      = $this->session->userdata('username');
        $contestid = $this->session->userdata('contestid');
        $q         = "select PROBSET_STATUS from pc_probset where USER_NAME = '$user' and CONTEST_ID = $contestid";
        $qr        = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row = $qr->first_row();
            return $row->PROBSET_STATUS;
        } else {
            return 1;
        }
    }

    public function getProbsetId()
    {
        $user      = $this->session->userdata('username');
        $contestid = $this->session->userdata('contestid');
        $q         = "select PROBSET_ID from pc_probset where USER_NAME = '$user' and CONTEST_ID = $contestid";
        $probsetid = $this->db->query($q);
        return $probsetid;
    }

    public function viewProblemSetterInContest($contestid)
    {
        $q  = "select probset_id, user_name from pc_probset where contest_id='" . $contestid . "' ";
        $qr = $this->db->query($q);
        $no = 1;
        echo "<table border='1' width='25%'>";
        echo "<tr align='center' bgcolor='#F77A0C'><td>No</td><td>Probset ID</td><td>Username</td></tr>";
        foreach ($qr->result() as $row) {
            echo "<tr><td>" . $no . "</td><td>" . $row->probset_id . "</td><td>" . $row->user_name . "</td></tr>";
            $no++;
        }
        echo "</table>";
    }

}

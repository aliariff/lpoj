<?php

class Participantmodel extends CI_Model
{

    public function getProblemNumber($contestid)
    {
        $q = '
            SELECT *
            FROM pc_problem pcprob, pc_detcon pcd
            WHERE pcd.contest_id = ' . $contestid . '
            and pcprob.problem_id = pcd.problem_id
        ';
        $qr = $this->db->query($q);
        return $qr->num_rows();
    }

    public function getParticipantProblem($contestid)
    {
        $q = "
            SELECT pcprob.problem_id
            FROM pc_problem pcprob, pc_detcon pcd
            WHERE pcd.contest_id = '" . $contestid . "'
            and pcprob.problem_id = pcd.problem_id
            ORDER BY pcprob.problem_id
        ";
        $qr = $this->db->query($q);
        foreach ($qr->result() as $row) {
            echo "<td NOWRAP>Problem asd#" . $row->problem_id . "</td>";
        }
    }

    public function getMyContestId()
    {
        $uname = $this->session->userdata('participantid');
        $q     = "SELECT participant_id, user_name, contest_id FROM pc_participant WHERE participant_id= '" . $uname . "'";
        $qr    = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row = $qr->first_row();
            return $row->contest_id;
        } else {
            return -1;
        }
    }

    public function checkIsParticipant($contestid)
    {
        $uname = $this->session->userdata('username');
        $q     = "SELECT participant_id, user_name, contest_id FROM pc_participant WHERE contest_id=" . $contestid . " AND user_name = '" . $uname . "'";
        $qr    = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row = $qr->first_row();
            return $row->participant_id;
        } else {
            return -1;
        }
    }

    public function getContestDetail()
    {
        $participantid = $this->session->userdata('participantid');
        $q             = "SELECT pcc.contest_id, pcc.contest_name, pcc.contest_start, pcc.contest_freeze, pcc.contest_end, pcp.participant_id, pcc.contest_penalty " .
            "FROM pc_contest pcc, pc_participant pcp WHERE pcc.contest_id = pcp.contest_id AND " .
            "pcp.participant_id = " . $participantid;
        $qr  = $this->db->query($q);
        $row = $qr->first_row();

        $limit = now();
        $user  = "SELECT count(*) as sum FROM pc_participant WHERE ($limit - participant_lastactive) <= 600 AND contest_id = " . $row->contest_id;
        $userr = $this->db->query($user);

        if ($qr->num_rows() > 0) {
            echo "<table>";
            echo "<tr><td colspan='2'>[" . $row->contest_id . "] " . character_limiter($row->contest_name, 15) . "</td></tr>";
            echo "<tr><td colspan='2'>Participant ID : " . $row->participant_id . "</td></tr>";
            echo "<tr><td>Start</td><td>: " . unix_to_human($row->contest_start) . "</td></tr>";
            echo "<tr><td>Frz</td><td>: " . unix_to_human($row->contest_freeze) . "</td></tr>";
            echo "<tr><td>End</td><td>: " . unix_to_human($row->contest_end) . "</td></tr>";
            // echo "<tr><td>Pty</td><td>: " . $row->contest_penalty . " s</td></tr>";
            echo "<tr><td>Active</td><td>: " . $userr->first_row()->sum . " users</td></tr>";
            echo "</table>";
        } else {
            echo "Cannot Load Contest Detail";
        }
    }

}

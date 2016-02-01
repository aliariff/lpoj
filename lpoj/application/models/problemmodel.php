<?php

class Problemmodel extends CI_Model
{

    public function getProblemContestId($problemid)
    {
        $q  = "SELECT contest_id FROM pc_detcon WHERE problem_id=" . $problemid;
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row = $qr->first_row();
            return $row->contest_id;
        } else {
            return -1;
        }
    }

    public function getProblemInContest($pid)
    {
        $participant = $this->session->userdata('participantid');
        $q           = 'select contest_id from pc_participant where participant_id = ' . $participant . '';
        $qr          = $this->db->query($q);
        $contestid   = $qr->first_row()->contest_id;

        $q  = 'select contest_id from pc_detcon where contest_id = ' . $contestid . ' and problem_id = ' . $pid . ' ';
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function getProblemTitle($problemid)
    {
        $q  = "SELECT problem_id, problem_title FROM pc_problem WHERE problem_id=" . $problemid;
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row = $qr->first_row();
            return $row->problem_title;
        } else {
            return "Error cannot load Problem....";
        }
    }

    public function getProblemContent($problemid)
    {
        $q  = "SELECT problem_content, problem_creator, IFNULL(problem_runtime,0) as problem_runtime, IFNULL(problem_memory,0) as problem_memory FROM pc_problem WHERE problem_id=" . $problemid;
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $row = $qr->first_row();
            return "Created by : " . $row->problem_creator .
            "<br /><br />" . $row->problem_content .
            "<br /><hr />" .
            "<h4>Problem Requirement</h4>" .
            "Runtime Limit : " . $row->problem_runtime . " seconds <br />" .
            "Memory Limit : " . $row->problem_memory . " bytes";
        } else {
            return "Error cannot load Problem....";
        }
    }

    public function getProblem($problemid)
    {
        $q   = "SELECT problem_title, problem_content, problem_creator, PROBLEM_OUTPUCASE, PROBLEM_INPUTCASE, problem_runtime, problem_memory FROM pc_problem WHERE problem_id=" . $problemid;
        $qr  = $this->db->query($q);
        $row = $qr->first_row();
        return $row;
    }

    public function getProblemList()
    {
        $participantid = $this->session->userdata('participantid');
        $q             = "SELECT pcprob.problem_id, pcprob.problem_title FROM pc_participant pcp, pc_detcon pcc, pc_problem pcprob  " .
            "WHERE pcp.participant_id=" . $participantid . " AND " .
            "pcp.contest_id = pcc.contest_id AND pcc.problem_id = pcprob.problem_id order by pcprob.problem_id";
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            echo "<ul class=\"sb_menu\">";
            foreach ($qr->result() as $row) {
                echo "<li><a href='" . site_url() . "/problem/detail/" . $row->problem_id . "'>" . $row->problem_title . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "Cannot Load Problem...";
        }
    }
    public function getProblemByContestId($id)
    {
        $this->db->where("CONTEST_ID", $id);
        $query = $this->db->get("pc_problem");
        return $query->result();
    }
    public function getProblemContest($cid)
    {
        $q = "SELECT pcprob.problem_id, pcprob.problem_title FROM pc_detcon pcc, pc_problem pcprob WHERE  " .
            "pcc.contest_id = " . $cid . " AND " . "pcc.problem_id = pcprob.problem_id order by pcprob.problem_id";
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            echo "<ul class=\"sb_menu\">";
            foreach ($qr->result() as $row) {
                echo "<li><a href='" . site_url() . "/contest/problem/" . $row->problem_id . "'>" . $row->problem_title . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "Cannot Load Problem...";
        }
    }

    public function getNonAcceptedProblem()
    {
        $participantid = $this->session->userdata('participantid');
        $q             = '
            SELECT pcprob.problem_id, pcprob.problem_title
            FROM pc_problem pcprob, pc_participant pcp, pc_detcon pcd
            WHERE pcp.contest_id = pcd.contest_id
            AND pcp.participant_id = ' . $participantid . '
            AND pcd.problem_id = pcprob.problem_id
        ';
        $qr = $this->db->query($q);
        echo "<select name='submitproblem' size='1'>";
        foreach ($qr->result() as $row) {
            echo "<option value='" . $row->problem_id . "'>" . $row->problem_title . "</option>";
        }
        echo "</select>";
    }

}

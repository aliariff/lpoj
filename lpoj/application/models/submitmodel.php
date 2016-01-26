<?php

class Submitmodel extends CI_Model
{

    public function saveToDb($time, $problem, $user, $filename, $hashcode)
    {
        $data = array(
            'submit_filename' => $filename,
            'problem_id'      => $problem,
            'status_id'       => 99,
            'submit_time'     => $time,
            'participant_id'  => $user,
            'submit_hash'     => $hashcode,
        );

        $this->db->insert('pc_submit', $data);
        return $this->db->insert_id();
    }

    public function getMySolution()
    {
        $participant = $this->session->userdata('participantid');
        $q           = '
            SELECT pcpar.user_name, pcs.submit_hash, pcs.problem_id, pcs.submit_id, pcprob.problem_title, pcs.submit_filename, pcs.submit_time, pcs.score, pcst.status_id, pcst.status_name
            FROM pc_submit pcs, pc_problem pcprob, pc_status pcst,pc_participant pcpar
            WHERE pcs.participant_id = ' . $participant . '
            AND pcpar.participant_id = pcs.participant_id
            AND pcprob.problem_id = pcs.problem_id
            AND pcs.status_id = pcst.status_id
            ORDER BY pcs.submit_time DESC
        ';
        $qr = $this->db->query($q);
        echo "<table border='1' width='100%'><tr align='center' bgcolor='#F77A0C'><td style=\"color:#000\">ID #</td><td style=\"color:#000\">Submit Time</td><td style=\"color:#000\">Problem</td><td style=\"color:#000\">Verdict</td><td style=\"color:#000\"></td></tr>";

        //CAMIN
        $ctr = 0;
        foreach ($qr->result() as $row) {

            echo "<tr align='center'>";

            //CAMIN
            $myFile = $row->submit_time . "_-_" . $row->submit_hash . "_-_" . $row->problem_id . "_-_" . $row->user_name . "_-_" . $row->submit_filename;
            echo "<tr align='center'>";
            $probid = $row->problem_id;
            //CAMIN
            $submitid = $row->submit_id;
            $test     = "/showcode/readCode/" . $myFile . "/" . $probid . "/" . $submitid . "/";

            echo "<form target=\"_blank\" id=\"form" . $ctr . "\" name=\"form1\" method=\"post\" action=\"" . site_url($test) . "\">";
            echo "<input type=\"hidden\" name=\"filename\" value=\"" . $myFile . "\">";
            echo "<td>" . $row->submit_id . "</td>";
            echo "</form>";
            echo "<td>" . unix_to_human($row->submit_time) . "</td>";
            echo "<td>" . $row->problem_title . "</td>";
            //NPC2014
            /*if($row->status_id==7)
            {
            echo "<td>".$row->score."</td>";
            }
            else
            {
            echo "<td>".$row->status_name."</td>";
            }*/
            echo "<td id=status" . $ctr . ">" . $row->status_name . "</td>";

            echo "<td><a href=\"#\" onclick=\"document.getElementById('form" . $ctr . "').submit();\"><img src= " . base_url() . "/images/lup.png></img></a></td>";
            echo "</tr>";

            //AJAX refresh user_solution
            if ($row->status_id == 99) {
                echo "<span class=\"ajax_solution\" style=\"display:none\">" . "status" . $ctr . " " . $row->submit_id . "</span>";
            }
            $ctr++;
        }
        echo "</table>";
    }
    //MODEL AJAX refresh user_solution
    public function getSolutionVerdictById($id)
    {
        $query = $this->db->query("SELECT pcstat.status_name FROM pc_submit pcs, pc_status pcstat
                    WHERE pcs.SUBMIT_ID=$id AND pcstat.status_id=pcs.status_id");
        $res = $query->result();
        return $res[0]->status_name;
    }
    public function getSolutionContentById($id)
    {
        $query = $this->db->query("select Source from pc_submit where SUBMIT_ID=$id");
        $res   = $query->result();
        return $res[0]->Source;
    }
    public function aa($myFile)
    {
        echo "asd";
        $this->showcode->detail($myFile);
    }
    public function getAllSolution()
    {
        $cid = $this->session->userdata('contestid');
        $q   = '
            SELECT pcs.submit_id, pcprob.problem_title, pcs.submit_filename, pcs.submit_time, pcstat.status_name, pcu.user_name, pcs.submit_hash, pcs.problem_id, pcs.score, pcstat.status_id
            FROM pc_submit pcs, pc_status pcstat, pc_problem pcprob, pc_participant pcpar, pc_user pcu
            WHERE pcs.participant_id IN
            (SELECT participant_id FROM pc_participant WHERE contest_id=' . $cid . ')
            AND pcprob.problem_id = pcs.problem_id
            AND pcpar.participant_id = pcs.participant_id
            AND pcstat.status_id = pcs.status_id
            AND pcpar.user_name = pcu.user_name
            ORDER BY pcs.submit_id DESC
        ';
        $qr = $this->db->query($q);
        echo "<table border='1' width='100%'><tr align='center' bgcolor='#F77A0C'><td>ID #</td><td>Username</td><td>Problem</td><td>Filename</td><td>Submit Time</td><td>Score</td></tr>";

        $pending = 0;
        $all     = $qr->num_rows();

        //foreach ($qr->result() as $row)
        //{if ($row->status_name == "Pending") $pending++;}

        echo "Total : $all Solution <br /><br />";

        $ctr = 0;
        foreach ($qr->result() as $row) {

            $myFile = $row->submit_time . "_-_" . $row->submit_hash . "_-_" . $row->problem_id . "_-_" . $row->user_name . "_-_" . $row->submit_filename;
            echo "<tr align='center'>";
            $probid = $row->problem_id;
            //CAMIN
            $submitid = $row->submit_id;
            $test     = "/showcode/readCode/" . $myFile . "/" . $probid . "/" . $submitid . "/";

            /*printing contest submit list table*/
            echo "<form id=\"form" . $ctr . "\" name=\"form1\" method=\"post\" action=\"" . site_url($test) . "\">";
            echo "<input type=\"hidden\" name=\"filename\" value=\"" . $myFile . "\">";
            echo "<td><a  href=\"#\" onclick=\"document.getElementById('form" . $ctr . "').submit();\">" . $row->submit_id . "</a></td>";
            $ctr++;
            echo "</form>";

            echo "<td>" . $row->user_name . "</td>";
            echo "<td>" . $row->problem_title . "</td>";
            echo "<td>" . $row->submit_filename . "</td>";
            echo "<td>" . unix_to_human($row->submit_time) . "</td>";
            //if($row->status_id==7)echo "<td>".$row->score."</td>";
            //else echo "<td>".$row->status_name."</td>";
            echo "<td>" . $row->status_name . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    //CAMIN
    public function getSubmitLog($submitid)
    {
        $query = $this->db->query("select submit_log from pc_submit where SUBMIT_ID=$submitid");
        $log   = $query->result();
        return explode(" ", $log[0]->submit_log);
    }

    public function getAllSolutionAC($probid)
    {
        $cid = $this->session->userdata('contestid');
        $q   = '
            SELECT pcs.submit_id, pcprob.problem_title, pcs.submit_filename, pcs.submit_time, pcstat.status_name, pcu.user_name, pcs.submit_hash, pcs.problem_id, pcs.score, pcstat.status_id
            FROM pc_submit pcs, pc_status pcstat, pc_problem pcprob, pc_participant pcpar, pc_user pcu
            WHERE pcs.participant_id IN
            (SELECT participant_id FROM pc_participant WHERE contest_id=' . $cid . ')
            AND pcprob.problem_id = pcs.problem_id
            AND pcpar.participant_id = pcs.participant_id
            AND pcstat.status_id = pcs.status_id
            AND pcpar.user_name = pcu.user_name
            AND pcprob.problem_id=' . $probid . '
            AND pcstat.status_id = 7
            ORDER BY pcs.submit_id DESC
        ';
        $qr      = $this->db->query($q);
        $zip     = new ZipArchive;
        $pathzip = COMPILER_FOLDER . 'zip_temp/' . $cid . '-' . $probid . '.zip';
        exec('rm -f ' . COMPILER_FOLDER . 'zip_temp/*.zip');
        $res = $zip->open($pathzip, ZipArchive::CREATE);
        if ($res === true) {
            foreach ($qr->result() as $row) {

                $myFile   = $row->submit_time . "_-_" . $row->submit_hash . "_-_" . $row->problem_id . "_-_" . $row->user_name . "_-_" . $row->submit_filename;
                $submitid = $row->submit_id;
                $path     = COMPILER_FOLDER . 'backup/' . $probid . '/' . $myFile;
                $zip->addFile($path, $row->user_name . '-' . $submitid . '-' . $row->submit_filename);
                //echo "<td>".unix_to_human($row->submit_time)."</td>";
            }
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

}

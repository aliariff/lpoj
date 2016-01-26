<?php

class Testcasemodel extends CI_Model
{

    public function printAllTestcase($problemid)
    {
        $q  = 'SELECT persentase,inputcase,outputcase FROM pc_testcase WHERE problem_id = "' . $problemid . '" ';
        $qr = $this->db->query($q);
        if ($qr->num_rows() > 0) {
            $i = 1;
            echo "<tr><td><div id=\"input\">";
            foreach ($qr->result() as $row) {
                echo "<div id=\"in" . $i . "\" class=\"row\">"
                . $i . ": <input type=\"file\" name=\"picase" . $i . "\">
            </br>" . $row->inputcase . "
            </div>";
                $i++;
            }
            echo "</div>
          </td>
          <td>
            <div id=\"output\">";
            $i = 1;
            foreach ($qr->result() as $row) {
                echo "<div id=\"out" . $i . "\" class=\"row\">"
                . $i . ": <input type=\"file\" name=\"pocase" . $i . "\">
            </br>" . $row->outputcase . "
            </div>";
                $i++;
            }
            echo "</div>
            </div>
          </td>
          <td>
            <div id=\"persentase\">";
            $i = 1;
            foreach ($qr->result() as $row) {
                echo "<div id=\"persen" . $i . "\" class=\"row\">
            <input type=\"text\" onchange=\"Calculate()\" name=\"pros" . $i . "\" value=\"" . $row->persentase . "\">
            </br></br>
            </div>";
                $i++;
            }
            echo "</div>
          </td>
          </tr>

          <tr>
            <td></td>
            <td></td>
            <td><div id=\"total\">";
            $q     = "select persentase from pc_testcase where problem_id = '" . $problemid . "'";
            $qr    = $this->db->query($q);
            $total = 0;
            foreach ($qr->result() as $row) {
                $total += $row->persentase;
            }
            echo "Total = " . $total . " %";
            echo "</div></td>
          </tr>";
        } else {
            echo "<tr>
          <td>
            <div id=\"input\">
            <div id=\"in1\" class=\"row\">
            1: <input type=\"file\" name=\"picase1\">
            </div>
            </div>
          </td>
          <td>
            <div id=\"output\">
            <div id=\"out1\" class=\"row\">
            1: <input type=\"file\" name=\"pocase1\">
            </div>
            </div>
          </td>
          <td>
            <div id=\"persentase\">
            <div id=\"persen1\" class=\"row\">
            <input type=\"text\" onchange=\"Calculate()\" name=\"pros1\" value=\"0\">
            </div>
            </div>
          </td>
          </tr>

          <tr>
            <td></td>
            <td></td>
            <td><div id=\"total\"></div></td>
          </tr>";
        }
    }
}

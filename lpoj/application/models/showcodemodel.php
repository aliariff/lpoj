<?php

class Showcodemodel extends CI_Model
{

    public function showVerdictDetail($submitid)
    {

        $arr  = $this->Submitmodel->getSubmitLog($submitid);
        $buff = "\n";
        $i    = 1;
        foreach ($arr as $a) {
            if ($a == "") {
                break;
            } else if ($a == "1") {
                $buff .= "MALICIOUS CODE\n";
                break;
            } else if ($a == "2") {
                $buff .= "COMPILATION ERROR\n";
                break;
            } else if ($a == "3") {
                $ver = "MEMORY LIMIT EXCEEDED";
            } else if ($a == "5") {
                $ver = "TIME LIMIT EXCEEDED";
            } else if ($a == "6") {
                $ver = "RUN TIME ERROR";
            } else if ($a == "7") {
                $ver = "ACCEPTED";
            } else if ($a == "8") {
                $ver = "PRESENTATION ERROR";
            } else if ($a == "9") {
                $ver = "WRONG ANSWER";
            }

            $buff .= "Test {$i} --> Status : {$ver}\n";
            $i++;
        }
        print $buff; //nl2br($buff, $is_xhtml = null);
    }

    public function showSubmitedCode($path)
    {
        if (!file_exists($path)) {
            echo "File Tidak Ditemukan";
            return;
        }
        $handle = fopen($path, "r");
        if ($handle) {
            $code = "\n";
            $temp = fread($handle, filesize($path));
            $code .= $temp;
            print $code;
        }
        fclose($handle);
    }

}

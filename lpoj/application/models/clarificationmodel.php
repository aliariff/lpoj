<?php

class Clarificationmodel extends CI_Model
{

    public function saveToDb($pid, $ctitle, $ccontent)
    {
        $data = array(
            'participant_id'         => $pid,
            'clarification_title'    => $ctitle,
            'clarification_content'  => $ccontent,
            'clarification_response' => 'Not Responsed Yet',
            'clarification_time'     => now(),
        );

        $this->db->insert('pc_clarification', $data);
    }

    public function getAllClarification()
    {
        $parid = $this->session->userdata('participantid');
        $q     = '
			SELECT pcu.user_name,
			  pcclar.clarification_time,
			  pcclar.clarification_title,
			  pcclar.clarification_content,
			  pcclar.clarification_response
			FROM pc_clarification pcclar,
			  pc_user pcu,
			  pc_participant pcp
			WHERE pcclar.participant_id = ' . $parid . '
			AND pcclar.participant_id = pcp.participant_id
			AND pcp.user_name         = pcu.user_name
			ORDER BY pcclar.clarification_time DESC
		';
        $qr = $this->db->query($q);

        foreach ($qr->result() as $row) {
            echo "<table border='1' width='100%'>";
            echo "<tr>";
            echo "<td width='75%'>By : " . $row->user_name . "</td>";
            echo "<td>" . unix_to_human($row->clarification_time) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'><strong>" . htmlentities($row->clarification_title) . "</strong></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'>" . htmlentities($row->clarification_content) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'><i>" . htmlentities($row->clarification_response) . "</i></td>";
            echo "</tr>";
            echo "</table>";
            echo "<br />";
        }
    }

    public function getAllClarificationComplete($conid)
    {
        $parid = $this->session->userdata('participantid');
        $q     = '
			SELECT pcu.user_name,
			  pcclar.clarification_time,
			  pcclar.clarification_title,
			  pcclar.clarification_content,
			  pcclar.clarification_response
			FROM pc_clarification pcclar,
			  pc_user pcu,
			  pc_participant pcp
			WHERE pcclar.participant_id = pcp.participant_id
			AND pcp.user_name         = pcu.user_name
			AND pcclar.participant_id IN (select participant_id FROM pc_participant WHERE contest_id = ' . $conid . ')
			ORDER BY pcclar.clarification_time DESC
		';
        $qr = $this->db->query($q);

        foreach ($qr->result() as $row) {
            echo "<table border='1' width='100%'>";
            echo "<tr>";
            echo "<td width='75%'>By : " . $row->user_name . "</td>";
            echo "<td>" . unix_to_human($row->clarification_time) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'><strong>" . htmlentities($row->clarification_title) . "</strong></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'>" . htmlentities($row->clarification_content) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'><i>" . htmlentities($row->clarification_response) . "</i></td>";
            echo "</tr>";
            echo "</table>";
            echo "<br />";
        }
    }

    public function answer($clarification, $ans)
    {
        $data = array(
            'clarification_response' => $ans,
        );

        $this->db->where('clarification_id', $clarification);
        $this->db->update('pc_clarification', $data);
    }

    public function getAllClarificationContest($contestid)
    {
        $q = '
			SELECT pcu.user_name,
			  pcclar.clarification_id,
			  pcclar.clarification_time,
			  pcclar.clarification_title,
			  pcclar.clarification_content,
			  pcclar.clarification_response
			FROM pc_clarification pcclar,
			  pc_user pcu,
			  pc_participant pcp
			WHERE pcclar.participant_id IN
			  ( SELECT participant_id FROM pc_participant WHERE contest_id = ' . $contestid . '
			  )
			AND pcclar.participant_id = pcp.participant_id
			AND pcp.user_name         = pcu.user_name
			ORDER BY pcclar.clarification_time DESC
		';
        $qr = $this->db->query($q);

        foreach ($qr->result() as $row) {
            $color = "#FFFFFF";
            if ($row->clarification_response == "Not Responsed Yet") {
                $color = "#FF7777";
            }

            echo "<table border='1' width='100%' bgcolor='$color'>";
            echo "<tr>";
            echo "<td width='75%'>By : " . $row->user_name . "</td>";
            echo "<td>" . unix_to_human($row->clarification_time) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'><strong>" . htmlentities($row->clarification_title) . "</strong></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'>" . htmlentities($row->clarification_content) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'><i>" . htmlentities($row->clarification_response) . "</i></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='2'>";
            ?>
				<form action="" method="post">
					<input type="hidden" name="clid" value="<?php echo $row->clarification_id; ?>" />
					<input type="text" name="answer" size="50" />
					<input type="submit" value="Update Answer" />
				</form>
				<?php
echo "</td>";
            echo "</tr>";
            echo "<tr>";
            ?>
				<table>
					<tr>
						<td>Quick Answer : </td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="clid" value="<?php echo $row->clarification_id; ?>" />
								<input type="hidden" name="answer" value="Ya" />
								<input type="submit" value="Ya" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="clid" value="<?php echo $row->clarification_id; ?>" />
								<input type="hidden" name="answer" value="Tidak" />
								<input type="submit" value="Tidak" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="clid" value="<?php echo $row->clarification_id; ?>" />
								<input type="hidden" name="answer" value="Tidak Ada Komentar" />
								<input type="submit" value="Tidak Ada Komentar" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="clid" value="<?php echo $row->clarification_id; ?>" />
								<input type="hidden" name="answer" value="Baca Kembali Soal" />
								<input type="submit" value="Baca Kembali Soal" />
							</form>
						</td>
					</tr>
				</table>
				<?php
echo "</tr>";
            echo "</table>";
            echo "<br />";
        }
    }

}

?>

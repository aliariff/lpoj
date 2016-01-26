<?php

class Probsetmodel extends CI_Model {

	function getAllMyContest()
	{
		$user = $this->session->userdata('username');
		$q = 'SELECT * FROM pc_contest WHERE user_name = "'.$user.'" order by contest_id desc';
		$qr = $this->db->query($q);
		return $qr->result();
	}
	
	function comboMyContest()
	{
		$user = $this->session->userdata('username');
		$q = 'SELECT pc_contest.contest_id, pc_contest.contest_name FROM pc_contest, pc_probset WHERE pc_probset.user_name = "'.$user.'" and pc_contest.contest_id = pc_probset.contest_id order by contest_id desc';
		$qr = $this->db->query($q);
		
		if ($qr->num_rows() > 0)
		{			
			echo "<form method='post' action='".site_url()."/contest'>";
			echo "<select name='contest'>";
			foreach ($qr->result() as $row)
			{
				echo "<option value='".$row->contest_id."'>".$row->contest_id." - ".character_limiter($row->contest_name,25)."</option>";
			}
			echo "</select><br />";
			echo "<input type='submit' value='Manage My Contest' name='contestselect' />";
			echo "</form>";
			echo "<br />";
		}
		else
		{
			echo "You Have No Contest";
		}
	}
	
	function comboMyProblem()
	{
		$user = $this->session->userdata('username');
		$q = 'SELECT problem_id, problem_title FROM pc_problem WHERE user_name = "'.$user.'" order by problem_id desc';
		$qr = $this->db->query($q);
		
		if ($qr->num_rows() > 0)
		{			
			echo "<form method='post' action='".site_url()."/probset/detailProblem'>";
			echo "<select name='problem'>";
			foreach ($qr->result() as $row)
			{
				echo "<option value='".$row->problem_id."'>".$row->problem_id." - ".character_limiter($row->problem_title,25)."</option>";
			}
			echo "</select><br />";
			echo "<input type='submit' value='Edit My Problem' name='contestselect' />";
			echo "</form>";
			echo "<br />";
		}
		else
		{
			echo "You Have No Problem";
		}
	}
	
	function addProblem()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		
		if ($ceksess == FALSE){
			redirect(site_url().'/probset');
		}
		else{			
			$data = array(
				'problem_title' => 'New Problem',
				'problem_content' => 'New Problem Content',
				'problem_creator' => 'PCLP',
				'problem_runtime' => '1',
				'problem_memory' => '16777216',
				'user_name' => $this->session->userdata('username')
			);
			
			$this->db->insert('pc_problem', $data);
			$newid = $this->db->insert_id();
			
			$myFile = "/root/pclp/limiter/limit" . $newid;
			$fh = fopen($myFile, 'w');
			fwrite($fh, "1");
			fclose($fh);
			
			$myFile = "/root/pclp/memory/memory" . $newid;
			$fh = fopen($myFile, 'w');
			fwrite($fh, "16777216");
			fclose($fh);
			
			redirect('probset/problem/'.$newid);
		}		
	}
	
	function isAtProbset()
	{
		$query = $_SERVER['PHP_SELF'];
		$path = pathinfo( $query );
		$what_you_want = $path['dirname'];
		
		if($what_you_want=="/LPOJ/index.php/probset")
		{
			return true;
		}
		return false;
	}
	
	function isAtContest()
	{
		$query = $_SERVER['PHP_SELF'];
		$path = pathinfo( $query );
		$what_you_want = $path['dirname'];
		
		if (strpos($what_you_want,'contest') !== false) {
			return true;
		}
		return false;
	}
	
	function viewParticipantInContest($contestid)
	{
		$q = "select participant_id, user_name from pc_participant where contest_id='".$contestid."' ";
		$qr = $this->db->query($q);
		$no = 1;
		echo "<table border='1' width='25%'>";
		echo "<tr align='center' bgcolor='#F77A0C'><td>No</td><td>Participant ID</td><td>Username</td></tr>";
		foreach ($qr->result() as $row)
		{
			echo "<tr><td>".$no."</td><td>".$row->participant_id."</td><td>".$row->user_name."</td></tr>";
			$no++;
		}
		echo "</table>";
	}
}
?>
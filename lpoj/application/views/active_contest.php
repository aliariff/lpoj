<?php
	$participantid = $this->session->userdata('participantid');
	$contestid = $this->session->userdata('contestid');
	
	if ($participantid==-1 && $contestid)
	{
		$this->Contestmodel->getContestDetail($contestid);
	}
	else if ($participantid != -1)
	{
		$this->Participantmodel->getContestDetail();
	}
	else
	{
		echo "No Active Contest";
	}
?>
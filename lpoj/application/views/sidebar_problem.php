<?php  
	$pid = $this->session->userdata('participantid'); 
	$cid = $this->session->userdata('contestid');
	
	
	if ($pid==-1 && $cid && $this->Probsetmodel->isAtContest())
	{
		?>
			<div id="gadget">
				<h2>Problem List</h2>
				<?php $this->Problemmodel->getProblemContest($cid); ?>
			</div>
		<?php
	}
	else if ($pid == -1){}
	else
	{
		?>
		<div id="gadget">
				<h2>Problem List</h2>
				<?php $this->Problemmodel->getProblemList(); ?>
		</div>    
		<?php 
	} 
?>
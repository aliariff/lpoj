<?php

class Rejudge extends CI_Controller
{
	function index()
	{
		 $probid = $this->input->post('probid');
			exec("python /root/pclp/compilerDaemonMk4b/rejudge.py " . $probid);
			redirect('contest/problem/'.$probid);		
	}	
	
}
?>

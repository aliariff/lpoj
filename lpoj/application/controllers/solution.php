<?php

class Solution extends CI_Controller {

	function index()
	{
		$ceksess = $this->Usermodel->checkSession() &&  $this->Usermodel->checkContestSession();
		
		if ($ceksess == FALSE){
			redirect(site_url('/home'));
		}
		else{
			$this->load->view('user_solution');
		}
	}
	function viewSolution($idSubmit)
	{
		$ceksess = $this->Usermodel->checkPrev($idSubmit);
		if($ceksess)
		{
			echo "<pre>".$this->Submitmodel->getSolutionContentById($idSubmit)."</pre>";
		}
		else
		{
			echo "ooh tidak isa";
		}
		
	}
	function refreshVerdict($idSubmit){
		/*$ceksess = $this->Usermodel->checkPrev($idSubmit);
		if($ceksess)
		{*/
			echo $this->Submitmodel->getSolutionVerdictById($idSubmit);
		/*}
		else
		{
			echo "refresh";
		}*/
	}
}

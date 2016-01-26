<?php

class Clarification extends CI_Controller {
	
	function index()
	{
		$ceksess = $this->Usermodel->checkSession() &&  $this->Usermodel->checkContestSession();
		
		if ($ceksess == FALSE){
			redirect(site_url('/home'));
		}
		else{
			$this->load->view('user_clarification');
		}
	}
	
	function all()
	{
		$ceksess = $this->Usermodel->checkSession() &&  $this->Usermodel->checkContestSession();
		
		
		
		if ($ceksess == FALSE){
			redirect(site_url('/home'));
		}
		else{
			$conid = $this->Participantmodel->getMyContestId();
			
			$data = array(
				'conid' => $conid
			);
			
			$this->load->view('user_clarification_all', $data);
		}
	}
}
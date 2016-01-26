<?php

class Submit extends CI_Controller {

	function index()
	{
		$ceksess = $this->Usermodel->checkSession() &&  $this->Usermodel->checkContestSession();
		
		if ($ceksess == FALSE){
			redirect(site_url('/home'));
		}
		else{
			$this->load->view('user_submit');
		}
	}
}
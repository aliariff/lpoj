<?php

class Password extends CI_Controller {

	function index()
	{
		$ceksess = $this->Usermodel->checkSession();
		
		if ($ceksess == FALSE){
			redirect(site_url().'/login');
		}
		else{
			$this->load->view('user_password');
		}
	}
}

?>
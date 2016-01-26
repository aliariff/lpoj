<?php

class Home extends CI_Controller {

	function index()
	{
		//checking user session
		$ceksess = $this->Usermodel->checkSession();
		
		if ($ceksess == FALSE){
			redirect(site_url().'/login');
		}
		else{
			$this->load->view('user_home');
		}
	}
}

?>

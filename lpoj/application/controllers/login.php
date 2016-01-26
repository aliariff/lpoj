<?php

class Login extends CI_Controller {

  	function index()
	{
		$stat = $this->Usermodel->checkSession();
		$ceksess = $this->Adminmodel->checkSession();
		$ceksess2 = $this->Usermodel->checkSessionProbset();
		if ($stat)
		{
			redirect(site_url().'/home');
		}
		else if($ceksess2)
		{
			redirect(site_url().'/probset');
		}
		else if($ceksess)
		{
			redirect(site_url().'/admin');
		}
		else
		{
			$this->load->view('login_form');
		}
	}
}

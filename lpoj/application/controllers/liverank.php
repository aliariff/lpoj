<?php

class Liverank extends CI_Controller {

	function index()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{			
			$this->load->view('live_view');
		}

	}
} 
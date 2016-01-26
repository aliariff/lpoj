<?php

class Contest extends CI_Controller {

	function index()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		if ($ceksess == false && $ceksess2 == false){
			redirect(site_url().'/login');
		}
		else{
			$user = $this->session->userdata('username');
			$contestid = $this->input->post('contest');
			if($contestid)
			{
				$data = array(
				'contestid' => $contestid
				);
				$this->session->set_userdata($data);
			}
			redirect(site_url().'/contest/dashboard');
		}
	}
	
	function addProblem()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{			
			$problemid = $this->input->post('problem');
			if($problemid)
			{
				$q = 'SELECT * FROM pc_detcon where contest_id= '.$this->session->userdata('contestid').' and problem_id = '.$problemid.'';
				$qr = $this->db->query($q);
		
				if ($qr->num_rows() > 0)
				{		
					$this->session->set_flashdata('contesterror','Problem Already In Contest');
					redirect(site_url('contest/addProblem'));
				}
				else
				{
					$data = array(
					'contest_id' => $this->session->userdata('contestid'),
					'problem_id' => $problemid
					);
					$this->db->insert('pc_detcon', $data);
					$this->load->view('contest_addproblem');
				}
			}
			else
			{
				$this->load->view('contest_addproblem');
			}
		}		
	}
	
	function getAddProbset()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else
		{
			$ceksess = $this->Usermodel->checkSessionProbset();
			if ($ceksess == FALSE){
				redirect(site_url().'/login');
			}
			else
			{
				if($this->input->post("view"))
				{
					redirect(site_url().'/contest/viewProblemSetterInContest/'.$this->session->userdata('contestid'));
				}
				else
				{
					$users = $this->input->post("user_names");
					$mode = $this->input->post("mode");
					$users = explode("\n",$users);
					$contest_id = $this->session->userdata('contestid');

					if($mode==1)
					{
						$participant = array();
						$this->db->trans_start();
						foreach($users as $i)
						{
							if($i==NULL||$i=="") continue;
							$i = str_replace("\r",'', $i);
							$q = "select * from pc_probset where user_name='".$i."' and contest_id='".$contest_id."'";
							$qr = $this->db->query($q);
							if ($qr->num_rows() > 0)continue;
							$q = "select user_status from pc_user where user_name='".$i."'";
							$qr = $this->db->query($q);
							if ($qr->row()->user_status!=2)continue;
							$p = array("USER_NAME"=>$i,"CONTEST_ID"=>$contest_id, "PROBSET_STATUS"=>2);
							$this->db->insert("pc_probset",$p);
							array_push($participant,$p);
						}
						$this->db->trans_complete();
						redirect(site_url().'/contest/editProbset');
					}
					else if($mode==2)
					{
						foreach($users as $i)
						{
							if($i==NULL||$i=="") continue;
							$i = str_replace("\r",'', $i);
							$q = "delete from pc_probset where user_name='".$i."' and contest_id='".$contest_id."'";
							$this->db->query($q);
						}
						redirect(site_url().'/contest/editProbset');
					}
				}
			}
		}
	}

	function viewProblemSetterInContest($contestid)
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		if ($ceksess == FALSE){
			redirect(site_url().'/login');
		}
		else
		{
			$q = "select * from pc_probset where contest_id = '".$contestid."'";
			$qr = $this->db->query($q);
			if ($qr->num_rows() > 0)
			{
				$this->Contestmodel->viewProblemSetterInContest($contestid);
			}
			else
			{
				redirect(site_url().'/probset/addParticipant');
			}
		}
	}

	function editProbset()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else
		{
			$data['probsetstatus'] = $this->Contestmodel->getProbsetStatus();
			$this->load->view('contest_probset', $data);
		}
	}

	function editProblem()
	{
		
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else
		{			
			$pid = $this->input->post('pid');
			$ptitle = $this->input->post('ptitle');
			$pcreator = $this->input->post('pcreator');
			$pcontent = $this->input->post('pcontent');
			
			if ($_FILES["picase"]["error"] > 0)
			{
				if (file_exists("/root/pclp/inputcase/testCase" . $pid))
				{
					echo $_FILES["file"]["name"] . " already exists. ";
				}
				else 
				{
					$myFile = "/root/pclp/inputcase/testCase" . $pid;
					$fh = fopen($myFile, 'w');
					fwrite($fh, "");
					fclose($fh);
					exec("fromdos /root/pclp/inputcase/testCase" . $pid);
				}
			}		
			else
			{
				move_uploaded_file($_FILES["picase"]["tmp_name"],
				"/root/pclp/inputcase/testCase" . $pid );      
				exec("fromdos /root/pclp/inputcase/testCase" . $pid);
			}
    
			if ($_FILES["pocase"]["error"] > 0)
			{
				if (file_exists("/root/pclp/outputcase/hasil" . $pid))
				{
					echo $_FILES["file"]["name"] . " already exists. ";
				}
				else 
				{
					$myFile = "/root/pclp/outputcase/hasil" . $pid;
					$fh = fopen($myFile, 'w');
					fwrite($fh, "");
					fclose($fh);
					exec("fromdos /root/pclp/outputcase/hasil" . $pid);      
				}
  			 		
			}
			else
			{
				move_uploaded_file($_FILES["pocase"]["tmp_name"],
				"/root/pclp/outputcase/hasil" . $pid);
				exec("fromdos /root/pclp/outputcase/hasil" . $pid);
			}
			
			$picase = "testCase" . $pid;         
			$pocase = "hasil" . $pid;   
                
			$prunning = $this->input->post('prunning');
			$pmemory = $this->input->post('pmemory');
			
			$myFile = "/root/pclp/limiter/limit" . $pid;
			$fh = fopen($myFile, 'w');
			fwrite($fh, $prunning);
			fclose($fh);
			
			$myFile = "/root/pclp/memory/memory" . $pid;
			$fh = fopen($myFile, 'w');
			fwrite($fh, $pmemory);
			fclose($fh);
			
			$myFile = "/root/pclp/tollerance/toll" . $pid;
			$fh = fopen($myFile, 'w');
			fwrite($fh, "0");
			fclose($fh);
			
			$update = array(
				'problem_title' => $ptitle,
				'problem_creator' => $pcreator,
				'problem_content' => $pcontent,
				'PROBLEM_INPUTCASE' => $picase,
				'PROBLEM_OUTPUCASE' => $pocase,
				'problem_runtime' => $prunning,
				'problem_memory' => $pmemory
			);
			$this->db->where('problem_id', $pid);
			$this->db->update('pc_problem', $update);
			redirect('contest/problem/'.$pid);
		}		
	}
	
	function deleteProblem()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{			
			
			$probid = $this->input->post('probid');
			$probans = $this->input->post('probans');
			$deleteans = $this->input->post('deleteans');
			
			if ($deleteans == $probans)
			{
				$q = "select submit_id from pc_submit pcs, pc_participant pcp where pcs.problem_id='".$probid."' and pcp.participant_id=pcs.participant_id and pcp.contest_id='".$cekcontest."'";
				$qr = $this->db->query($q);
				foreach($qr->result() as $row)
				{
					$q = "delete from pc_submit where submit_id='".$row->submit_id."'";
					$this->db->query($q);
				}
				
				$q = "delete from pc_detcon where contest_id='".$cekcontest."' and problem_id='".$probid."'";
				$this->db->query($q);
				
				redirect('contest/dashboard');
			}
			else
			{
				redirect('contest/problem/'.$probid);
			}			
			
		}		
	}
	
	function rejudgeProblem()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{			
			$probid = $this->input->post('probid');
			$myFile = "/root/pclp/backup/rejudge." . $probid ;
			$fh = fopen($myFile, 'w');
			fclose($fh);
			redirect('contest/problem/'.$probid);		
		}		
	}
	
	function updatedetail()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else
		{
			$cname = $this->input->post('conname');
			$cdesc = $this->input->post('condesc');
			$cstart = human_to_unix($this->input->post('constart'))+3600;
			$cfreeze = human_to_unix($this->input->post('confreeze'))+3600;
			$cend = human_to_unix($this->input->post('conend'))+3600;
			$cpenalty = $this->input->post('conpenalty');
			
			$this->Contestmodel->updateContestDetail($cname, $cdesc, $cstart, $cfreeze, $cend, $cpenalty);
			
			redirect(site_url().'/contest/dashboard');
		}		
	}
	
	function dashboard()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{			
			$this->load->view('contest_dashboard');
		}
	}
	
	function solution()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{
			$this->load->view('contest_solution');
		}
	}
	
	function problem($pid)
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{
		
			$data = array('problemid' => $pid);
			$this->load->view('contest_problem', $data);
		}		
	}
	
	function rank()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{					
			$this->load->view('contest_rank');
		}
	}
	
	function clarification()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{
			$clid = $this->input->post('clid');
			if ($clid)
			{
				$answer = $this->input->post('answer');
				$this->Clarificationmodel->answer($clid, $answer);
			}
			$this->load->view('contest_clarification');
		}
	}
	function solutionAC()
	{
		$ceksess = $this->Usermodel->checkSessionProbset();
		$ceksess2 = $this->Adminmodel->checkSession();
		$cekcontest = $this->session->userdata('contestid');
		if (($ceksess == FALSE && $ceksess2 == FALSE) || !$cekcontest){
			redirect(site_url().'/login');
		}
		else{ 
			$probid = $this->input->post('probid');
			$data = array('probid' => $probid);
			$zip = $this->Submitmodel->getAllSolutionAC($probid);
			if($zip == TRUE){
				redirect(base_url().'../pclp/zip_temp/'.$cekcontest.'-'.$probid.'.zip');
			}
			else{
				$this->load->view('contest_solutionAC', $data);
			}
		}
	}
}

<script type="text/javascript">
	
	var jam = <?php echo exec("date +%I"); ?>;
	var menit = <?php echo date("i"); ?>;
	var detik = <?php echo date("s"); ?>;
	var type = "<?php echo date("A"); ?>";
	var date = "<?php echo date("Y-m-d"); ?>";
	
	function tick()
	{
		detik += 1;
		if(detik == 60)
		{
			menit += 1;
			detik = detik%60;
			if(menit == 60)
			{
				jam += 1;
				menit = menit%60;
				if(jam == 24)
				{
					jam = 1;
				}
			}
		}		
		
		var sjam = jam;
		if (jam < 10) sjam = "0"+jam;
		
		var smenit = menit;
		if (menit < 10) smenit = "0"+menit;
		
		var sdetik = detik;
		if (detik < 10) sdetik = "0"+detik;
		
		/*
		var sdate = date;
		if (date < 10) sdate = "0"+date;
		
		var smonth = month;
		if (month < 10) smonth = "0"+month;
		
		var syear = year;
		if (year < 10) syear = "0"+year;
		*/
		
		document.getElementById("serverdate").innerHTML = date;
		document.getElementById("servertime").innerHTML = sjam+":"+smenit+":"+sdetik+" "+type;
	}
	setInterval(tick,1000);
</script>

		<div class="gadget">
          <h2 class="star">Server Time</h2>
          <ul class="sb_menu">
            <li>
			Date : <span id="serverdate">refreshing...</span>
			</li>
            <li>
			Time : <span id="servertime">refreshing...</span>
			</li>
			<?php
				if ($this->session->userdata('participantid')!=-1 || $this->Probsetmodel->isAtContest())
				echo "<h2 class=\"star\">My Contest</h2>";
			?>
				<?php 
					if ($this->session->userdata('participantid')!=-1 || $this->Probsetmodel->isAtContest())
					$this->load->view('active_contest'); 
				?>
				<?php 
					if ($this->session->userdata('participantid') && $this->session->userdata('userstatus')==3)
					{
						$this->load->view('available_contest'); 	
					}
				?>
			
          </ul>
        </div>

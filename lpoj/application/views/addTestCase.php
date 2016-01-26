<html>
<head>
	<title>Upload TestCase PC.LP</title>
 
	<!-- Linked files. -->
	<script src="<?php echo base_url(); ?>js/jquery-1.10.2.min.js"></script>
	<script src="<?php echo base_url(); ?>js/dynamic_file_upload.js"></script>
	<script type="text/javascript">
	
	$(window).bind("load", function() {
		var flag = <?php
			$q = "select persentase from pc_testcase where problem_id = '".$problemid."'";
			$qr = $this->db->query($q);
			$total = 0;
			foreach($qr->result() as $row)
			{
				$total += $row->persentase;
			}
			if($total!=100)echo "0";
			else echo "1";
		?>;
		if(flag==0)
		{
			window.alert("Total Persentase Harus 100 %");
		}
	});
	
	function Calculate()
	{
		var jFilesContainer = $( "#persentase" );
		var intNewFileCount = (jFilesContainer.find( "div.row" ).length + 1);
		var total = 0;
		for(var i=1;i<intNewFileCount;i++)
		{
			var textBox = document.getElementsByName('pros'+i)[0].value;
			total += parseInt(textBox);
		}
		document.getElementById('total').innerHTML="Total = "+total+" %";
	}
	
	function validateForm()
	{
		//CAMIN
		if($("#zip").val()!=""){
			document.getElementsByName('pid')[0].value = "<?php echo $problemid; ?>";
		
			return true;
		}
		
		Calculate();
		var jFilesContainer = $( "#persentase" );
		var intNewFileCount = (jFilesContainer.find( "div.row" ).length + 1);
		var total = 0;
		var flag = false;
		for(var i=1;i<intNewFileCount;i++)
		{
			var textBox = document.getElementsByName('pros'+i)[0].value;
			if(textBox<=0)flag=true;
			total += parseInt(textBox);
		}
		
		if(flag)
		{
			window.alert("Persentase Tidak Valid");
			return false;
		}
		
		else if(total=="100")
		{
			document.getElementsByName('size')[0].value = intNewFileCount-1;
			document.getElementsByName('pid')[0].value = "<?php echo $problemid; ?>";
			return true;
		}
		else
		{
			window.alert("Total Persentase Harus 100%");
			return false;
		}
	}
	
	function deleteElement()
	{
		var jFilesContainer = $( "#persentase" );
		divNum = (jFilesContainer.find( "div.row" ).length);
		if(divNum==1)
		{
			window.alert("Minimal Harus Ada 1 TestCase");
			return;
		}
		var d = document.getElementById('input');
		var olddiv = document.getElementById('in'+divNum);
		d.removeChild(olddiv);
		var d = document.getElementById('output');
		var olddiv = document.getElementById('out'+divNum);
		d.removeChild(olddiv);
		var d = document.getElementById('persentase');
		var olddiv = document.getElementById('persen'+divNum);
		d.removeChild(olddiv);
		
		my_form=document.createElement('FORM');
		my_form.name='myForm';
		my_form.method='POST';
		my_form.action='<?php echo site_url('uploadtestcase/deletetestcase'); ?>';
		
		my_tb=document.createElement('INPUT');
		my_tb.type='HIDDEN';
		my_tb.name='hidden1';
		my_tb.value='testCase<?php echo $problemid; ?>_'+divNum;
		my_form.appendChild(my_tb);
		document.body.appendChild(my_form);
		my_tb=document.createElement('INPUT');
		my_tb.type='HIDDEN';
		my_tb.name='hidden2';
		my_tb.value='<?php echo $problemid; ?>';
		my_form.appendChild(my_tb);
		document.body.appendChild(my_form);
		my_form.submit();
	}
	</script>
	
</head>
<body>
 
	<h1>
		Add Test Case <?php echo $this->Problemmodel->getProblemTitle($problemid) ?>
	</h1>
	<h3 style="color:red;">
		PERHATIAN! TOTAL PERSENTASE HARUS 100% JIKA TIDAK SISTEM TIDAK AKAN MENGCOMPILE JAWABAN SOAL
	</h3>
 
	<form method="post" enctype="multipart/form-data" action="<?php echo site_url('uploadtestcase/upload'); ?>" onsubmit="return validateForm()">
		
		<table>
			<tr>
				<td>INPUT FILE</td>
				<td>OUTPUT FILE</td>
				<td>PERSENTASE (NILAI AKHIR HARUS 100%)</td>
			</tr>
			
			<?php
				echo $this->Testcasemodel->printAllTestcase($problemid);
			?>
			
		</table>
		
 
		<p>
			<a id="add-file-upload">Add File Upload</a>
			&nbsp;&nbsp;&nbsp;
			<a href="javascript:;" onclick="deleteElement();">Hapus</a>
		</p>
		<p>
			<a href="<?php echo base_url(); ?>">Back</a>
		</p>
 
		<input type="hidden" name="size" />
		<input type="hidden" name="pid" />
		<!-- CAMIN-->
		<h4 style="color:red;">
		Format isi ZIP file : <br/>
		1.in 1.out 2.in 2.out 3.in 3.out ... dan score.txt (nama file harus 1.in 1.out 2.in 2.out . . . dst, dan score.txt)<br/> 
		isi score.txt adalah presentase nilai -> 25 25 .. dst (sesuai jumlah soal dan total harus 100 !)
		</h4>		
		<a>ZIP FILE : </a>&nbsp;&nbsp;&nbsp;
		<input type="file" name="zip" id="zip">
		<br><br>




		<input type="submit" value="Submit">
		
		<!--- DOM templates. --->
		<div id="element-templates" style="display: none ;">
 
			<div id="::FIELD1::" class="row">
				::FIELD2::: <input type="file" name="::FIELD3::">
			</div>
 
		</div>
		<div id="element-templates1" style="display: none ;">
 
			<div id="::FIELD1::" class="row">
				::FIELD2::: <input type="text" onchange="Calculate()" name="::FIELD3::" value="0">
			</div>
 
		</div>
 
	</form>
 
</body>
</html>

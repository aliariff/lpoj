<div id="sidebar">
<table>
	<tr>
		<td><h2>Available Contest</h2></td>
	</tr>
	<tr>
		<td>
			<?php
				$contesterr = $this->session->flashdata('contesterror');
				if ($contesterr)
				{
					echo "<table width='100%' bgcolor='#ff7777'><tr><td align='center'>".$contesterr."</td></tr></table>";
				}
			?>
		</td>
	</tr>
	<tr>
		<td align='left'>
			<?php
				$this->Contestmodel->comboAvailableContest();
			?>
		</td>
	</tr>
</table>
</div>
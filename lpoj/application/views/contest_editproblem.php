							<h3>Edit Problem</h3>
							<table border="1" width="100%"><tr><td>
							<?php $pdet = $this->Problemmodel->getProblem($problemid); ?>
							<form method="post" action="<?php echo site_url('contest/editProblem'); ?>" enctype="multipart/form-data">
								<table>
									<tr>
										<td>Problem Id</td>
										<td>: <?php echo $problemid; ?><input name="pid" type="hidden" value="<?php echo $problemid; ?>" /></td>
									</tr>
									<tr>
										<td>Problem Title</td>
										<td>: <input size="60" name="ptitle" type="text" value="<?php echo $pdet->problem_title; ?>" /> </td>
									</tr>
									<tr>
										<td>Problem Creator</td>
										<td>: <input size="60" name="pcreator" type="text" value="<?php echo $pdet->problem_creator; ?>" /> </td>
									</tr>
									<tr>
										<td>Problem Content</td>
										<td><textarea name="pcontent" rows="20" cols="50" class="mce"><?php echo $pdet->problem_content; ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td><a href="<?php echo site_url('uploadtestcase/prob/'.$problemid); ?>"> Upload Test Case</a></td>
									</tr>
									<tr>
										<td>Running Time Limit</td>
										<td>: <input name="prunning" type="text" value="<?php echo $pdet->problem_runtime; ?>" /> second</td>
									</tr>
									<tr>
										<td>Memory Limit</td>
										<td>: <input name="pmemory" type="text" value="<?php echo $pdet->problem_memory; ?>" /> bytes</td>
									</tr>
									<tr>
										<td colspan="2"><input type="submit" value="Update Problem" /></td>
									</tr>
								</table>
							</form>
							</td></tr>
							</table>
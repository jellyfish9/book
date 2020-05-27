<?php
	$arr_result=$this->model;
	if(!empty($arr_result)){
		$header=array_keys($arr_result);
?>
		<div>
			<table class="table table-striped">
				<tbody>
					<?php
						foreach($header as $h){
							$title=ucwords(str_replace("_"," ",$h));
							?>
							<tr>
								<th><?php echo $title; ?></th>
								<td><?php echo $arr_result[$h]; ?></td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
<?php 
	}
	else{
		?>
			<h2 class="text-center text-danger">No Record !!!</h2>
		<?php
	}
?>
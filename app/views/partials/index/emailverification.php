<?php
	$data=$this->view_data;
	$user_email = $data["user_email"];
	$status = $data["status"];
?>
<div class="container">
<div class="card card-body my-3">
	<?php 
		if($status==true){
			if(!empty($_GET['resend'])){
				?>
				<h4 class="text-info bold animated bounce">vradicon[email]vradicon [html-lang-0110]</h4>
				<?php
			}
			else{
				?>
				<h4 class="text-info bold">vradicon[email]vradicon [html-lang-0111]</h4>
				<?php
			}
		?>
			<div class="text-muted">[html-lang-0112]</div>
			<hr />
			<div>
				<a href="<?php print_link("index/send_verify_email_link/$user_email?resend=true") ?>" class="btn btn-primary">vradicon[email]vradicon [html-lang-0113]</a>
			</div>
			<?php
		}
		else{
			?>
			<div>vradicon[email]vradicon [html-lang-0112]</div>
			<hr />
			<div>
				<a href="<?php print_link("index/send_verify_email_link/$user_email?resend=true") ?>" class="btn btn-primary">vradicon[email]vradicon [html-lang-0113]</a>
			</div>
			<?php
		}
	?>
</div>
</div>



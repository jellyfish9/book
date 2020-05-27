<div class="container">
	<div>
		<h3>密码重置管理器</h3>
		<small class="text-muted">
			请提供您用于注册的有效电子邮件地址
		</small>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-8">
			<?php 
				$this :: display_page_errors(); 
			?>
			<form method="post" action="<?php print_link("passwordmanager/postresetlink"); ?>">
				<div class="row">
					<div class="col-9">
						<input value="<?php echo get_form_field_value('email'); ?>" placeholder="Enter Your Email Address" required="required" class="form-control default" name="email" type="email" />
					</div>
					<div class="col-3">
						<button class="btn btn-success" type="submit"> 发送 <i class="material-icons">email</i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<br />
	<div class="text-info">
		系统会向您的电子邮件发送一个链接，其中包含您输入密码所需的信息
	</div>
</div>





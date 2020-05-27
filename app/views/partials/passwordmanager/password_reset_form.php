<div class="container">
	<h3>密码重置管理器</h3>
	<hr />
	<div class="row">
		<div class="col-sm-6">
			<h4>提供新密码</h4>
			<hr />
			<form method="post" action="<?php print_link(get_current_url()); ?>">
				<?php 
					$this :: display_page_errors();			
				?>
				<div class="form-group">
					<label>新密码</label>
					<input placeholder="Your New Password" required="required" value="" class="form-control default" name="password" id="txtpass" type="password" />
					<strong class="help-block">提示：不少于6个字符 </strong>
				</div>
				<div class="form-group">
					<label>确认新密码</label>
					<input placeholder="Confirm Password" required="required" class="form-control default" name="cpassword" id="txtcpass" type="password" />
				</div>
				<div class="mt-2 "><button  class="btn btn-success" type="submit">更改密码</button></div>
			</form>
		</div>
	</div>
</div>

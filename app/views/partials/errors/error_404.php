<style>
	.info-404 h1{
		font-size:172px;
		font-weight:bold;
		color:red;
	}
</style>
<div class="container-fluid">
	<div class="info-404 text-center">
		<h1 class="my-3">404</h1>
		<h2 class="text-muted">Page Not Found</h2>
		<div class="text-muted my-3"><small><?php echo $this->view_data; ?></small></div>
		<div class="text-center">
			<a href="<?php print_link(DEFAULT_PAGE); ?>" class="btn btn-primary"><i class="material-icons">home</i> Go to Home Page</a>
		</div>
	</div>
</div>
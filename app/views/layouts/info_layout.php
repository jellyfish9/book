<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="shortcut icon" href="<?php print_link(SITE_FAVICON); ?>" />
		<?php 
			Html ::  page_title(SITE_NAME);
			Html ::  page_meta('theme-color',META_THEME_COLOR);
			Html ::  page_meta('author',META_AUTHOR); 
			Html ::  page_meta('keyword',META_KEYWORDS); 
			Html ::  page_meta('description',META_DESCRIPTION); 
			Html ::  page_meta('viewport',META_VIEWPORT);
			Html ::  page_css('material-icons.css');
			Html ::  page_css('animate.css');
		?>
				<?php 
			Html ::  page_css('bootstrap-default.css');
			Html ::  page_css('bootstrap-theme-skeeblu.css');
			Html ::  page_css('custom-style.css');
		?>
		
		<style>
			#main-content{
				padding:0;
				min-height:500px;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
			<a class="navbar-brand" href="<?php print_link('') ?>">
				<img class="img-responsive" src="<?php print_link(SITE_LOGO); ?>" /> 
				<?php echo SITE_NAME ?>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link('') ?>">Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link('info/about') ?>">About</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link('info/help') ?>">Help &amp; FAQ</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link('info/contact') ?>">Contact</a>
					</li>
					
				</ul>
			</div>
		</nav>
		<div style="height:70px;"></div>
		
		<div id="main-content">
			<?php $this->render_body();?>
		</div>
		
		<?php $this->load_view("components/appfooter.php"); ?>
	</body>
</html>
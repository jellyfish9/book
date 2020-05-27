<?php 
	
	$navbartopleft=array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => ''
		),
		
		array(
			'path' => 'book', 
			'label' => 'Book', 
			'icon' => ''
		),
		
		array(
			'path' => 'user', 
			'label' => 'User', 
			'icon' => ''
		),
		
		array(
			'path' => 'book/show', 
			'label' => 'Show', 
			'icon' => ''
		)
	);

	$navbarsideleft=array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => ''
		),
		
		array(
			'path' => 'book', 
			'label' => 'Book', 
			'icon' => ''
		),
		
		array(
			'path' => 'user', 
			'label' => 'User', 
			'icon' => ''
		),
		
		array(
			'path' => 'book/show', 
			'label' => 'Show', 
			'icon' => ''
		)
	);

		
	
?>
<template id="AppHeader">
	<b-navbar ref="navbar" toggleable="md" fixed="top" type="dark" variant="dark">
	<b-navbar-brand href="<?php print_link(''); ?>">
		<img class="img-responsive" src="<?php print_link(SITE_LOGO); ?>" /> 
		<?php echo SITE_NAME ?>
	</b-navbar-brand>
	<b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
	<?php
			if(user_login_status() == true ){
		?>
	<b-collapse is-nav id="nav_collapse">
		<b-navbar-nav>
			<?php render_menu($navbartopleft  , 'left'); ?>
		</b-navbar-nav>

		<!-- Right aligned nav items -->
		<b-navbar-nav class="ml-auto">
			
			
				<b-nav-item-dropdown right>
					<template slot="button-content">
						<span class="avatar-icon"><i class="material-icons">account_box</i></span>
						<span>Hi <?php echo ucwords(USER_NAME); ?> !</span>
					</template>
					<b-dropdown-item to="/account"><i class="material-icons">account_box</i> My Account</b-dropdown-item>
					<b-dropdown-item href="<?php print_link('index/logout?csrf_token='.Csrf::$token) ?>"><i class="material-icons">exit_to_app</i> 登出</b-dropdown-item>
				</b-nav-item-dropdown>

		</b-navbar-nav>
	</b-collapse>
	<?php
		}
	?>
</b-navbar>
</template>

<script>
	var AppHeader = Vue.component('AppHeader', {
		template:'#AppHeader',
		mounted:function(){
			//let height = this.$el.offsetHeight;
			if(this.$refs.navbar){
				var height = this.$refs.navbar.offsetHeight;
				document.body.style.paddingTop = height + 'px';
				
				if(this.$refs.sidebar){
					this.$refs.sidebar.style.top = height + 'px';
				}
			}
		}
	})
</script>

<?php
	/**
	 * Build Menu List From Array
	 * Support Multi Level Dropdown Menu Tree
	 * Set Active Menu Base on The Current Page || url
	 * @return  HTML
	 */
	function render_menu($arrMenu,$slot="left"){
		if(!empty($arrMenu)){
			foreach($arrMenu as $menuobj){
				$path = trim($menuobj['path'],"/");
				
				if(PageAccessManager::GetPageAccess($path)=='AUTHORIZED'){

					if(empty($menuobj['submenu'])){
						?>
						<b-nav-item to="/<?php echo ($path); ?>">
							<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?> 
							<?php echo $menuobj['label']; ?>
						</b-nav-item>
						<?php
					}
					else{
						$smenu=$menuobj['submenu'];
						?>
						<b-nav-item-dropdown right>
							<template slot="button-content">
								<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?> 
								<?php echo $menuobj['label']; ?>
								<?php if(!empty($smenu)){ ?><i class="caret"></i><?php } ?>
							</template>
							<?php
								if(!empty($smenu)){
									 render_submenu($smenu);
								}
							?>
						</b-nav-item-dropdown>
						<?php 
					}
				}
			}
		
		}
	}
	
	/**
	 * Render Multi Level Dropdown menu 
	 * Recursive Function
	 * @return  HTML
	 */
	function render_submenu($arrMenu){
		if(!empty($arrMenu)){
			foreach($arrMenu as $key=>$menuobj){
				$path =  trim($menuobj['path'],"/");
				if(PageAccessManager::GetPageAccess($path)=='AUTHORIZED'){
					?>
					<b-dropdown-item to="/<?php echo($path); ?>">
						<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?> 
						<?php echo $menuobj['label']; ?>
						<?php
							if(!empty($menuobj['submenu'])){
								render_menu($menuobj['submenu']); 
							}
						?>
					</b-dropdown-item>
					<?php
				}
			}
		}
	}
?>
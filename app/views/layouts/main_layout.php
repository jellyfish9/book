<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="<?php echo PAGE_CHARSET ?>">
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
			Html ::  page_css('bootstrap-vue.min.css');
			Html ::  page_css('vue-form-wizard.css');
			
			

		?>
				<?php 
			Html ::  page_css('bootstrap-default.css');
			Html ::  page_css('bootstrap-theme-skeeblu.css');
			Html ::  page_css('custom-style.css');
		?>
	</head>
	
	<?php
		$page_id = "IndexPage";

		if(user_login_status() == true){
			$page_id = "HomePage";
		}
	?>

	<body id="<?php echo $page_id ?>">

		<div id="app" v-cloak>
			<appheader></appheader>
			<div id="main-content">
				<div class="container">
					
					<b-alert class="my-3 fixed-alert top-center animated bounce" variant="danger" :show="showPageError" @dismissed="showPageError=0" dismissible>
						<h4 class="bold"><i class="material-icons">error</i> {{ pageErrorStatus }}</h4>
						<div><span v-html="pageErrorMsg"></span></div>
					</b-alert>
					
					<b-alert class="fixed-alert bottom-left animated bounce" :show="showFlash" @dismissed="showFlash=0" variant="success" dismissible>
						<i class="material-icons">check_circle</i> {{flashMsg}}
					</b-alert>
					
					<div class="page-modal">
						<b-modal v-model="showModalView" size="lg">
							<span slot="modal-header"></span>
							<component :is="modalComponentName" v-bind="modalComponentProps"></component>
							<div slot="modal-footer"></div>
						</b-modal>
					</div>
				</div>
				<div id="app-body">
					<keep-alive>
						<router-view></router-view>
					</keep-alive>
				</div>
				<?php $this->load_view("components/appfooter.php"); ?>
			</div>
			
			
			
			<!-- for Record Export -->
			<form method="post" action="<?php print_link('report') ?>" target="_blank" id="exportform">
				<input type="hidden" name="data" id="exportformdata" />
				<input type="hidden" name="title" id="exportformtitle" />
			</form>
			<!-- Image / Gallery Preview  -->
			<nicecarousel></nicecarousel>
		</div>
		
		<script>
			var ActiveUser = <?php echo json_encode(get_active_user()); ?>;
			var apiUrl = '<?php SITE_ADDR; ?>';
			var defaultPageLimit = <?php echo MAX_RECORD_COUNT; ?>;
			
			
			String.prototype.trimLeft = function(charlist) {
				if (charlist === undefined)
					charlist = "\s";

				  return this.replace(new RegExp("^[" + charlist + "]+"), "");
				};
				
			String.prototype.trimRight = function(charlist) {
			  if (charlist === undefined)
				charlist = "\s";

			  return this.replace(new RegExp("[" + charlist + "]+$"), "");
			};
			
			function valToArray(val) {
				if(val){
					if(Array.isArray(val)){
						return val;
					}
					else{
						return val.split(",");
					}
				}
				else{
					return [];
				}
			};
			
			function debounce(fn, delay) {
			  var timer = null;
			  return function () {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
				  fn.apply(context, args);
				}, delay);
			  };
			}
			
			function extend(obj, src) {
				for (var key in src) {
					if (src.hasOwnProperty(key)) obj[key] = src[key];
				}
				return obj;
			}
			
			function setApiUrl(path , queryObj){
				var url =   path.trimLeft('/');
				if(queryObj){
					var str = [];
					for(var k in queryObj){
						var v = queryObj[k]
						if (queryObj.hasOwnProperty(k) && v !== '') {
							str.push(encodeURIComponent(k) + "=" + encodeURIComponent(v));
						} 
					}
					var qs = str.join("&");
					if(path.indexOf('?') > 0){
						url = path + '&' + qs;  
					}
					else{
						url = path + '?' + qs;  
					}
				}
				
				return apiUrl + url;
			}
			
			function randomColor() {
				var letters = '0123456789ABCDEF';
				var color = '#';
				for (var i = 0; i < 6; i++) {
					color += letters[Math.floor(Math.random() * 16)];
				}
				return color;
			}
		</script>
		
		<?php 
			Html ::  page_js('vue-2.5.17.js');
			Html ::  page_js('vue-pages.js');
			$this->load_view("components/appheader.php"); //include header component
			
			$this->load_view("home/index.php");
	
			// list of all page components
			$components = array(
				'index/index.php',
				'index/register.php',
				'book/list.php',
				'book/view.php',
				'book/add.php',
				'book/edit.php',
				'book/show.php',
				'user/list.php',
				'user/view.php',
				'account/edit.php',
				'account/view.php',
				'user/add.php',
				'user/edit.php'
			);
			foreach($components as $comp){
				$this->load_view($comp);
			}
			$this->load_view("components/componentnotfound.php");
			$this->load_view("components/pagecomponents.php");
			Html ::  page_js('chartjs-2.3.0.js');
			
			
			Html ::  page_js('polyfill.min.js'); //load polyfill script to support older browser like IE 9 and old safari
			Html ::  page_js('bootstrap-vue.min.js');
			
			Html ::  page_js('vue-bundle.js'); //minified page  plugins used (vue-resource, vee-validate, vue-mugen-scroll,  vue-spinner, vue-upload-component, vue-form-wizard)
			Html ::  page_js('page-components.js');
			
			Html ::  page_js('locale/vee-validate/zh_CN.js');
			Html ::  page_js('vue-script.js');
		?>
	</body>
</html>
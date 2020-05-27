<?php
/**
 * Html Helper Class
 * Use To Display Customisable Html Page Component
 * @category  View Helper
 */
class Html{
	/**
     * Display Html Head Title
     * Set Title From Url If Present
     * @return Html
     */
	public static function page_title($title=null){
		//if title is passed to the url parameters then use it. if not used the titleset on the PageLayout View
		if(!empty($_GET['title'])){
			$title=$_GET['title'];
		}
		?>
		<title><?php echo $title; ?></title>
		<?php
	}

	/**
     * Display Html Head Meta Tag
     * @return Html
     */
	public static function page_meta($name,$val=null){
		?>
		<meta name="<?php echo $name; ?>" content="<?php echo $val ?>" />
		<?php
	}

	/**
     * Link To Css File From Css Dir
     * NB -- Pass only The Css File Nam-- (eg. style.css) 
     * @return Html
     */
	public static function page_css($arg){
		?>
		<link rel="stylesheet" href="<?php print_link(CSS_DIR.$arg); ?>" />
		<?php
	}

	/**
     * Link To Js File From JS Dir
     * NB -- Pass only The Js File Name-- (eg. script.js) 
     * @return Html
     */
	public static function page_js($arg){
		?>
		<script type="text/javascript" src="<?php print_link(JS_DIR.$arg); ?>"></script>
		<?php
	}
	
	public static function display_form_errors($formerror){
		if(!empty($formerror)){
			if(!is_array($formerror)){
				?>
					<div class="alert alert-danger animated shake">
						<?php echo $formerror; ?>
					</div>
				<?php
			}
			else{
				?>
				<script>
					$(document).ready(function(){
						<?php 
							foreach($formerror as $key=>$value){
								echo "$('[name=$key]').parent().addClass('has-error').append('<span class=\"help-block\">$value</span>');";
							}
						?>
					});
				</script>
				<?php
			}
		}
	}
}
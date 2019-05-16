<?php
/**
 * Html Helper Class
 * Use To Display Customisable Html Page Component
 * @category  View Helper
 */
class Html{
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


	/**
     * Display Page Main Header Components
     * @return Html
     */
	public static function page_header($arg=null){
		?>
		

<div id="topbar" class="navbar navbar-expand-md fixed-top navbar-dark bg-primary">
	<div class="container-fluid">
		
	<?php $home_link = (user_login_status() == true ? HOME_PAGE : ''); //navigate to home page if user is logged in ?>
	<a class="navbar-brand" href="<?php print_link($home_link) ?>">
		<img class="img-responsive" src="<?php print_link(SITE_LOGO); ?>" /> <?php echo SITE_NAME ?>
	</a>

		<?php 
			if(user_login_status() == true ){ 
		?>

		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div id="sidebar" class="navbar-dark bg-primary navbar-fixed-left navbar-collapse flex-column align-self-start collapse navbar-responsive-collapse">
			
		<ul class="nav navbar-nav w-100 flex-column align-self-start">
			<li class="menu-profile nav-item">
				<a class="avatar" href="<?php print_link('account') ?>">
					<span class="avatar-icon"><i class="fa fa-user"></i></span>
				</a>
				<h5 class="user-name">Hi <?php echo ucwords(USER_NAME); ?></h5>
				<?php 
					if(defined('USER_ROLE')){
					?>
						<small class="text-muted"><?php echo USER_ROLE; ?> </small>
					<?php
					}
				?>
				
				<div class="dropdown menu-dropdown">
					<button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-user"></i>
					</button>
					<ul class="dropdown-menu">
						<a class="dropdown-item" href="<?php print_link('account') ?>"><i class="fa fa-user"></i> My Account</a>
						<a class="dropdown-item" href="<?php print_link('index/logout?csrf_token='.Csrf::$token) ?>"><i class="fa fa-sign-out"></i> Logout</a>
					</ul>
				</div>
			</li>
		</ul>
		

			<?php Html :: render_menu(Menu :: $navbarsideleft  , 'nav navbar-nav w-100 flex-column align-self-start'); ?>
		</div>

		<div class="navbar-collapse collapse navbar-responsive-collapse">
			<?php Html :: render_menu(Menu :: $navbartopleft  , 'navbar-nav mr-auto'); ?>
			
			
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
						<span class="avatar-icon"><i class="fa fa-user"></i></span> 
						<span>Hi <?php echo ucwords(USER_NAME); ?> !</span>
					</a>
					<ul class="dropdown-menu">
						<a class="dropdown-item" href="<?php print_link('account') ?>"><i class="fa fa-user"></i> My Account</a>
						<a class="dropdown-item" href="<?php print_link('index/logout?csrf_token='.Csrf::$token) ?>"><i class="fa fa-sign-out"></i> Logout</a>
					</ul>
				</li>
			</ul>

		</div>

		

		<?php 
		} 
	?>

	</div>
</div>

		<?php
	}
	
	/**
     * Display Page Main Footer Components
     * @return Html
     */
	public static function page_footer($args=null){
		?>
		<footer class="footer bg-light">
			<div  class="container-fluid text-center">
				<div class="row">
					<div  class="col-sm-3">
						<div class="copyright">All Rights Reserved | &copy; <?php echo SITE_NAME ?> - <?php echo date('Y') ?></div>
					</div>
					<div  class="col">
						<div class="footer-links">
							<a href="<?php print_link('info/about'); ?>">About us</a> | 
							<a href="<?php print_link('info/help'); ?>">Help and FAQ</a> |
							<a href="<?php print_link('info/contact'); ?>">Contact us</a>  |
							<a href="<?php print_link('info/privacy_policy'); ?>">Privacy Policy</a> |
							<a href="<?php print_link('info/terms_and_conditions'); ?>">Terms and Conditions</a>
						</div>
					</div>
					
				</div>
			</div>
		</footer>
		<?php
	}
	
	/**
	 * Build Menu List From Array
	 * Support Multi Level Dropdown Menu Tree
	 * Set Active Menu Base on The Current Page || url
	 * @return  HTML
	 */
	public static function render_menu($arrMenu,$menu_class='nav navbar-nav',$submenu_class='dropdown-menu'){
		$page_name=Router::$page_name;
		$page_url=Router::$page_url;
		if(!empty($arrMenu)){
			?>
			<ul class="<?php echo $menu_class; ?>">
				<?php
					foreach($arrMenu as $menuobj){
						$path = $menuobj['path'];
						if(PageAccessManager::GetPageAccess($path)=='AUTHORIZED'){
							$active_class=null;
							
							$menu_url = parse_url($path , PHP_URL_PATH);
							
							if($page_name == $menu_url || urldecode($page_url) == $menu_url){
								$active_class="active";
							}
							if(empty($menuobj['submenu'])){
								?>
								<li class="nav-item">
									<a class="nav-link <?php echo ($active_class) ?>" href="<?php print_link($path); ?>">
										<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?> 
										<?php echo $menuobj['label']; ?>
									</a>
								</li>
								<?php
							}
							else{
							?>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
										<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?> 
										<?php echo $menuobj['label']; ?>
									</a>
									<?php self :: render_submenu($menuobj['submenu'] , $submenu_class);?>
								</li>
							<?php 
							}
						}
					}
				?>
			</ul>
			<?php
		}
	}
	
	/**
	 * Render Multi Level Dropdown menu 
	 * Recursive Function
	 * @return  HTML
	 */
	public static function render_submenu($arrMenu,$menu_class="dropdown-menu"){
		$page_name=Router::$page_name;
		$page_url=Router::$page_url;
		if(!empty($arrMenu)){
			?>
			<ul class="<?php echo $menu_class ?>">
				<?php
					foreach($arrMenu as $key=>$menuobj){
						$path=$menuobj['path'];
						if(PageAccessManager::GetPageAccess($path)=='AUTHORIZED'){
							$active_class=null;
							$menu_url=parse_url($path,PHP_URL_PATH);
							if($page_url==$menu_url){
								$active_class="active";
							}
							$li_class="";
							if(!empty($menuobj['submenu'])){
								$li_class="dropdown-submenu";
							}
							?>
							<a class="dropdown-item <?php echo ($active_class) ?>" href="<?php print_link($path); ?>">
								<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?> 
								<?php echo $menuobj['label']; ?>
							</a>
							<?php
							if(!empty($menuobj['submenu'])){
								self :: render_submenu($menuobj['submenu'],$menu_class); 
							}
						}
					}
				?>
			</ul>
			<?php
		}
	}

	
	/**
     * Display Html Image Tag
     * Can be Use to Display Multiple Images Separated By Comma
     * Also Can Be Use To Resize Image Via Url
     * @return Html
     */
	public static function page_img($imgsrc,$resizewidth=null,$resizeheight=null,$link=null,$class=null,$attrs=null){
		if(!empty($imgsrc)){
			$arrsrc=explode(",",$imgsrc);
			foreach($arrsrc as $src){
				$imgpath="helpers/timthumb.php?src=$src";
				$imgpath.=($resizeheight!=null ? "&h=$resizeheight" : null);
				$imgpath.=($resizewidth!=null ? "&w=$resizewidth" : null);

				$previewlink=$link;
				$previewattr=null;
				if($link==null){
					$previewlink="helpers/timthumb.php?src=$src&w=760&h=520";
					$previewattr="data-gallery";
				}
				?>
				<a <?php echo $previewattr; ?> href="<?php print_link($previewlink) ?>">
					<img <?php echo ($class!=null ? 'class="'.$class.'"' : null) ?> src="<?php print_link($imgpath); ?>" />
				</a>
				<?php
			}
		}
	}
	
	/**
     * display multiple file link (files can be separated by comma)
     * @return Html
     */
	public static function page_link_file($src,$btntext="View File",$btnclass="btn btn-info btn-sm",$target="_blank"){
		if(!empty($src)){
			$arrpath=explode(",",$src);
			foreach($arrpath as $path){
				if(!empty($path)){
					?>
					<a class="<?php echo $btnclass ?>" target="<?php echo $target ?>" href="<?php print_link($path); ?>">
						<i class="material-icons">attachment</i>
						<?php echo $btntext ?>
					</a>
					<?php
				}
			}
		}
	}
	
	/**
     * Display html Hyper Link Tag
     * If User is Allowed to Assess That Particular Resource Or link
     * @return Html
     */
	public static function secured_page_link($path,$label="",$class=null,$attrs=null){
		$acl=new ResourceAccessManager();
		$access_condition=$acl->GetPathAccessCondition($path);
		if($access_condition=='AUTHORIZED'){
			?>
			<a href="<?php print_link($path); ?>" class="<?php echo($class) ?>" <?php echo $attrs; ?>><?php echo($label) ?></a>
			<?php	
		}
	}
	
	/**
     * Display html Hyper Link Tag
     * @return Html
     */
	public static function page_link($path,$label="",$classes=null,$attrs=null){
		?>
		<a href="<?php print_link($path); ?>" class="<?php echo($classes) ?>" <?php echo $attrs; ?>><?php echo($label) ?></a>
		<?php	
	}
	
	/**
     * Display import data form
     * @return Html
     */
	public static function import_form($form_path , $button_text="", $format_text="csv, json"){
		?>
		<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#-import-data">
		<i class="fa fa-file"></i> <?php echo $button_text; ?>
		</button>	
		
		<form method="post" action="<?php print_link($form_path) ?>" enctype="multipart/form-data" id="-import-data" class="modal fade" role="dialog" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-dialog-centered modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Import Data</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<label>Select a file to import <input required="required" class="form-control form-control-sm" type="file" name="file" /> </label>
						<small class="text-muted">Supported file types(csv , json)</small>
						
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Import Data</button>
					</div>
				</div>
			</div>
		</form>
		<?php	
	}
	


	/**
     * Convinient Function For Diisplaying Field Order By
     * Uses The Current Page URL and Modify Only The orderby and ordertype query string Parameter
     * @return Html
     */
	public static function get_field_order_link($fieldname,$fieldlabel){
		$currentordertype=strtoupper((array_key_exists("ordertype", $_GET) ? $_GET['ordertype'] : "ASC"));
		$newordertype=($currentordertype=='ASC' ? 'DESC' : 'ASC');
		$orderlink=set_current_page_link(array("orderby"=>$fieldname,"ordertype"=>$newordertype));
		$linkbtnclass=(get_query_str_value('orderby')==$fieldname ? 'btn-success' : 'btn-default');
		?>
		<a class="btn btn-xs <?php echo $linkbtnclass; ?>" href="<?php print_link($orderlink); ?>">
			<?php 
				echo $fieldlabel;
				if($currentordertype=='DESC' && get_query_str_value('orderby')==$fieldname){
					?>
					<i class="fa fa-arrow-up"></i>
					<?php
				}
				else{
					?>
					<i class="fa fa-arrow-down"></i>
					<?php
				}
			?>
		</a>
		<?php
	}
	
	
	/**
     * Convinient Function For Diisplaying Field Order By
     * Uses The Current Page URL and Modify Only The orderby and ordertype query string Parameter
     * @return Html
     */
	public static function uploaded_files_list($files, $inputid){
		?>
		<div class="uploaded-file-holder clearfix">
			<?php	
				if(!empty($files)){
					$arrsrc=explode(",",$files);
					$i=0;
					foreach($arrsrc as $src){
						$i++;
						?>
						<div class="d-inline-block p-1 bg-secondary m-1" id="file-holder-<?php echo $i; ?>">
							<a class="btn btn-sm btn-light" target="_blank" href="<?php print_link($src) ?>">
							 	<?php echo basename($src); ?>
							</a>
							<button data-input="<?php echo $inputid; ?>" type="button" data-file="<?php echo $src ?>" data-file-num="<?php echo $i; ?>" class="btn btn-sm btn-danger removeEditUploadFile">
								&#10005;
							</button>
						</div>
						<?php
					}
				}
				
			?>
		</div>
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
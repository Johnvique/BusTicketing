<?php
	// Set url Variable From Router Class
	$page_name = Router :: get_page_name();
	$page_action = Router :: get_page_action();
	$page_id = Router :: get_page_id();

	$this->render_body();
?>





<?php 
	//Html ::  page_js('script.js');
?>
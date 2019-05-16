<?php
	$data=$this->view_data;
	$user_email = $data["user_email"];
	$status = $data["status"];
?>
<div class="container">
	<?php 
		if($status==true){
			if(!empty($_GET['resend'])){
				?>
				<h4 class="text-info bold animated bounce"><i class="fa fa-envelope"></i> Email verification has been resent</h4>
				<?php
			}
			else{
				?>
				<h4 class="text-info bold"><i class="fa fa-envelope"></i> Email verification link sent</h4>
				<?php
			}
		?>
			<div class="text-muted">Please verify your email address by following the link in your mailbox</div>
			<hr />
			<div>
				<a href="<?php print_link("index/send_verify_email_link/$user_email?resend=true") ?>" class="btn btn-primary"><i class="fa fa-envelope"></i> Resend Email</a>
			</div>
			<?php
		}
		else{
			?>
			<div><i class="fa fa-envelope"></i> Please verify your email address by following the link in your mailbox</div>
			<hr />
			<div>
				<a href="<?php print_link("index/send_verify_email_link/$user_email?resend=true") ?>" class="btn btn-primary"><i class="fa fa-envelope"></i> Resend Email</a>
			</div>
			<?php
		}
	?>
</div>



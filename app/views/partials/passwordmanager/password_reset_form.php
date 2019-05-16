<div class="container">
	<h3>Password Reset </h3>
	<hr />
	<div class="row">
		<div class="col-sm-6">
			<h4>Provide new password</h4>
			<hr />
			<form method="post" action="<?php print_link(get_current_url()); ?>">
				<?php 
					$this :: display_page_errors();			
				?>
				<div class="form-group">
					<label>New Password</label>
					<input placeholder="Your New Password" required="required" value="" class="form-control default" name="password" id="txtpass" type="password" />
					<strong class="help-block">Hints : Not Less Than 6 Characters </strong>
				</div>
				<div class="form-group">
					<label>Confirm new password</label>
					<input placeholder="Confirm Password" required="required" class="form-control default" name="cpassword" id="txtcpass" type="password" />
				</div>
				<div class="mt-2 "><button  class="btn btn-success" type="submit">Change Password</button></div>
			</form>
		</div>
	</div>
</div>

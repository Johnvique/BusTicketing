<div class="container">
	<h4>Change Email Address</h4>
	<hr />
	<div class="row">
		<div class="col-sm-8">
			<form name="loginForm" action="<?php print_link('account/change_email?csrf_token=' . Csrf :: $token); ?>" method="post">
				<?php 
					$errors=(!empty($this->form_error) ? $this->form_error : null); 
					Html :: display_form_errors($errors); 
				?>
				<div class="row">
					<div  class="col-9">
						<input placeholder="Enter Your New Email Address" value="<?php  echo get_form_field_value('email'); ?>" name="email"  required="required" class="form-control" type="text"  />
					</div>
					<div class="col-3">
						<button class="btn btn-primary btn-block" type="submit">Continue</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
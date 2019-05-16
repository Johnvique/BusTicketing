
<?php
	$comp_model = new SharedController;

	$show_header = $this->show_header;
	$view_title = $this->view_title;
	$redirect_to = $this->redirect_to;

?>

	<section class="page">
		
<?php
	if( $show_header == true ){
?>

		<div  class="bg-light p-3 mb-3">
			<div class="container">
				
				<div class="row ">
					
		<div class="col-sm-6 comp-grid">
			<h3 class="record-title">User registration</h3>

		</div>

		<div class="col-sm-6 comp-grid">
			<div class="">
	<div class="text-center">
		Already have an account?  <a class="btn btn-primary" href="<?php print_link('') ?>"> Login</a>
	</div>
</div>
		</div>

				</div>
			</div>
		</div>

<?php
	}
?>

		<div  class="">
			<div class="container">
				
				<div class="row ">
					
		<div class="col-md-7 comp-grid">
			
	<?php $this :: display_page_errors(); ?>
	
	<div  class="card animated fadeIn">
		<form id="customers-userregister-form" role="form" enctype="multipart/form-data" class="form form-horizontal needs-validation" novalidate action="<?php print_link("index/register") ?>" method="post">
		<div class="card-body">
		
								
								<div class="form-group ">
									<div class="row">
										<div class="col-sm-4">
											<label class="control-label" for="name">Name <span class="text-danger">*</span></label>
										</div>
										<div class="col-sm-8">
											<div class="">
												<input  id="name" value="<?php  echo $this->set_field_value('name',''); ?>" type="text" placeholder="Enter Name"  required="" name="name" class="form-control " />
									 
 
												
											</div>
											 
											
										</div>
									</div>
								</div>
				
				

								
								<div class="form-group ">
									<div class="row">
										<div class="col-sm-4">
											<label class="control-label" for="phone">Phone <span class="text-danger">*</span></label>
										</div>
										<div class="col-sm-8">
											<div class="">
												<input  id="phone" value="<?php  echo $this->set_field_value('phone',''); ?>" type="text" placeholder="Enter Phone"  required="" name="phone" class="form-control " />
									 
 
												
											</div>
											 
											
										</div>
									</div>
								</div>
				
				

								
								<div class="form-group ">
									<div class="row">
										<div class="col-sm-4">
											<label class="control-label" for="email">Email <span class="text-danger">*</span></label>
										</div>
										<div class="col-sm-8">
											<div class="">
												<input  id="email" value="<?php  echo $this->set_field_value('email',''); ?>" type="email" placeholder="Enter Email"  required="" name="email" class="form-control " />
									 
 
												
											</div>
											 
											
										</div>
									</div>
								</div>
				
				

								
								<div class="form-group ">
									<div class="row">
										<div class="col-sm-4">
											<label class="control-label" for="password">Password <span class="text-danger">*</span></label>
										</div>
										<div class="col-sm-8">
											<div class="">
												<input  id="password" value="<?php  echo $this->set_field_value('password',''); ?>" type="password" placeholder="Enter Password"  required="" name="password" class="form-control " />
									 
 
												
											</div>
											 
											
										</div>
									</div>
								</div>
				
				
								
								<div class="form-group ">
									<div class="row">
										<div class="col-sm-4">
											<label class="control-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
										</div>
										<div class="col-sm-8">
											<div class="">
												
<input class="form-control " type="password" name="confirm_password" placeholder="Confirm Password" />
 
												
											</div>
											 
											
										</div>
									</div>
								</div>
				
				

								
								<div class="form-group ">
									<div class="row">
										<div class="col-sm-4">
											<label class="control-label" for="role">Role <span class="text-danger">*</span></label>
										</div>
										<div class="col-sm-8">
											<div class="">
												<select required=""  name="role" placeholder="Select a value ..."    class="form-control">
								<option value="">Select a value ...</option>
		
										<option <?php echo $this->set_field_selected('role','user') ?> value="user">User</option>
										<option <?php echo $this->set_field_selected('role','admin') ?> value="admin">Admin</option>			
								</select> 
												
											</div>
											 
											
										</div>
									</div>
								</div>
				
				


		</div>
		<div class="form-group form-submit-btn-holder text-center">
			<button class="btn btn-primary" type="submit">
				Submit
				<i class="fa fa-send"></i>
			</button>
		</div>
	</form>
	</div>

		</div>

				</div>
			</div>
		</div>

	</section>

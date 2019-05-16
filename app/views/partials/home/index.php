
		<?php 
			$comp_model = new SharedController;
		?>
		<div>
			
		<div  class="bg-light p-3 mb-3">
			<div class="container-fluid">
				
				<div class="row ">
					
		<div class="col-md-12 comp-grid">
			<h3 >Niaje Msafiri</h3>

		</div>

		<div class="col-md-6 comp-grid">
			
	
	<button data-toggle="modal" data-target="#Modal-1-Page1" class="btn btn-primary"><i class='fa fa-plus-circle fa-2x'></i>  New employee</button>
	<div data-backdrop="true" class="modal fade" id="Modal-1-Page1" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle"><i class='fa fa-plus-circle fa-2x'></i>  Modal Contents</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

				<div class="modal-body reset-grids">
					
	<div class="text-left">
		<h4>WELCOME TO YOUR BUSS TICKETING SYSTEM</h4>
		<p class="text-muted"></p>
	</div>
	<div class="smartwizard" data-theme="dots" SUBMIT-STEP-FORM>
		<ul>
			
					<li>
						<a href="#FormWizard-1-Page1">
							<i class="fa fa-smile-o fa-2x"></i> Step 1
							<br /><small>This is description</small>
						</a>
					</li>

					<li>
						<a href="#FormWizard-1-Page2">
							<i class="fa fa-toggle-right fa-2x"></i> Adding
							<br /><small>This is description</small>
						</a>
					</li>

					<li>
						<a href="#FormWizard-1-Page3">
							<i class="fa fa-terminal fa-2x"></i> view
							<br /><small>This is description</small>
						</a>
					</li>

		</ul>
		<div>
		
	<div class="card formtab" id="FormWizard-1-Page1" data-next-page="FormWizard-1-Page2" data-submit-action="MOVE-NEXT">
		<div class="">
<div class="text-center">
	<div class="p-3">
		<p><i class="material-icons mi-xlg animated bounceIn text-info">account_box</i></p>
		<h3>Welcome To Form Wizard</h3>
		<hr />
		<p class="text-muted">You can drag components onto the form wizard steps</p>
	</div>
</div>
</div>
		
	<div class="text-center p-3">
		
		<button class="btn btn-success sw-btn-next">Getting Started</button>
	</div>

	</div>

	<div class="card formtab" id="FormWizard-1-Page2" data-next-page="FormWizard-1-Page3" data-submit-action="SUBMIT-STEP-FORM">
		
	<div class="card reset-grids">
		<?php  
			$this->redirect_to='#FormWizard-1-Page3';
			$this->render_page("employees/add"); 
		?>
	</div>

		
	<div class="text-center p-3">
		
		<button class="btn btn-success sw-btn-next">next</button>
	</div>

	</div>

	<div class="card formtab" id="FormWizard-1-Page3" data-next-page="FormWizard-1-Page4" data-submit-action="SUBMIT-STEP-FORM">
		
	<div class="card ">
		<?php  
			$this->redirect_to='#FormWizard-1-Page4';
			$this->render_page("employees/list?limit_count=20"); 
		?>
	</div>

		
	<div class="text-center p-3">
		
		<button class="btn btn-success sw-btn-next">finished</button>
	</div>

	</div>

		</div>
	</div>

				</div>
				
			</div>
		</div>
	</div>


		</div>

		<div class="col-md-4 comp-grid">
			
		</div>

		<div class="col-md-4 comp-grid">
			
		</div>

				</div>
			</div>
		</div>

		<div  class="">
			<div class="container-fluid">
				
				<div class="row ">
					
		<div class="col-md-4 comp-grid">
			<div class="card ">
		<div class="card-header p-0 pt-2 px-2">
	<ul class="nav  nav-tabs   ">
		
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#TabPage-1-Page1" role="tab" aria-selected="true">
							 Recent complains
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link " data-toggle="tab" href="#TabPage-1-Page2" role="tab" aria-selected="true">
							 Recent reservations
						</a>
					</li>

	</ul>
</div>
		<div class="card-body">
	<div class="tab-content">
		
					<div class="tab-pane show active fade" id="TabPage-1-Page1" role="tabpanel">
						
				<div class=" position-relative mb-2">
					
					<div  class="card mb-3" >
						
						<?php 
							$arr_menu = array();
							$menus = $comp_model->complainsbus_no_list(); // Get menu items from database
							if(!empty($menus)){
								//build menu items into arrays
								foreach($menus as $menu){
									$arr_menu[] = array(
										"path"=>"complains/list/bus_no/$menu[bus_no]", 
										"label"=>"$menu[bus_no] <span class='badge badge-primary float-right'>$menu[num]</span>", 
										"icon"=>'<i class="fa fa-frown-o fa-2x"></i>'
									);
								}
								//call menu render helper.
								Html :: render_menu($arr_menu , "nav nav-tabs flex-column");
							}
						?>
					</div>
				</div>
				
					</div>

					<div class="tab-pane  fade" id="TabPage-1-Page2" role="tabpanel">
						
				<div class=" position-relative mb-2">
					
					<div  class="card mb-3" >
						
						<?php 
							$arr_menu = array();
							$menus = $comp_model->reservationsyour_name_list(); // Get menu items from database
							if(!empty($menus)){
								//build menu items into arrays
								foreach($menus as $menu){
									$arr_menu[] = array(
										"path"=>"reservations/list/your_name/$menu[your_name]", 
										"label"=>"$menu[your_name] <span class='badge badge-primary float-right'>$menu[num]</span>", 
										"icon"=>'<i class="fa fa-pencil fa-2x"></i>'
									);
								}
								//call menu render helper.
								Html :: render_menu($arr_menu , "nav nav-tabs flex-column");
							}
						?>
					</div>
				</div>
				
					</div>

	</div>
</div>
</div>
		</div>

		<div class="col-md-4 comp-grid">
			
					<?php $rec_count = $comp_model->getcount_buses();  ?>
					<a class="animated zoomIn record-count card bg-dark text-white"  href="<?php print_link("buses/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-bus fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Buses</div>
									
									<small class="">Add buses</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
					<?php $rec_count = $comp_model->getcount_routes();  ?>
					<a class="animated zoomIn record-count alert alert-danger"  href="<?php print_link("routes/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-road fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Routes</div>
									
									<small class="">Add routes</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
					<?php $rec_count = $comp_model->getcount_schedule();  ?>
					<a class="animated zoomIn record-count card bg-danger text-white"  href="<?php print_link("schedule/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-clock-o fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Schedule</div>
									
									<small class="">Make a shedule for the buses</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
		</div>

		<div class="col-md-4 comp-grid">
			
					<?php $rec_count = $comp_model->getcount_employees();  ?>
					<a class="animated zoomIn record-count alert alert-success"  href="<?php print_link("employees/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-user-plus fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Employees</div>
									
									<small class="">Add</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
		</div>

		<div class="col-md-4 comp-grid">
			
					<?php $rec_count = $comp_model->getcount_customers();  ?>
					<a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("customers/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-users fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Customers</div>
									
									<small class="">Customer tab</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
					<?php $rec_count = $comp_model->getcount_complains();  ?>
					<a class="animated record-count alert alert-primary"  href="<?php print_link("complains/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-frown-o fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Complaints</div>
									
				<div class="progress mt-2">
					<?php 
						$perc = ($rec_count / 100) * 100 ;
					?>
					<div class="progress-bar bg-light text-dark" role="progressbar" aria-valuenow="<?php echo $rec_count; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $perc ?>%">
						<span class="progress-label"><?php echo round($perc,2); ?>%</span>
					</div>
				</div>
		
									<small class="small desc">Complaints tab</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
					</a>
			
					<?php $rec_count = $comp_model->getcount_payments();  ?>
					<a class="animated zoomIn record-count alert alert-info"  href="<?php print_link("payments/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-money fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Payments</div>
									
									<small class="">Payments</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
					<?php $rec_count = $comp_model->getcount_reservations();  ?>
					<a class="animated zoomIn record-count alert alert-dark"  href="<?php print_link("reservations/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-pencil-square-o fa-2x"></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Reservations</div>
									
									<small class="">Reservations tab</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
		</div>

		<div class="col-md-4 comp-grid">
			
	<div class="card card-body">
		<?php 
			$chartdata = $comp_model->doughnutchart_payments();
		?>
		<div>
			<h4>payments</h4>
			<small class="text-muted"></small>
		</div>
		<hr />
		<canvas id="doughnutchart_payments"></canvas>
		<script>
			$(function (){
			var chartData = {
				labels : <?php echo json_encode($chartdata['labels']); ?>,
				datasets : [
					{
					label: 'Dataset 1',
					
					backgroundColor:'<?php echo random_color(0.9); ?>',
					borderWidth:2,
					data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
				}
				]
			}
			var ctx = document.getElementById('doughnutchart_payments');
			var chart = new Chart(ctx, {
				type:'doughnut',
				data: chartData,
				
	options: {
		responsive: true,
		scales: {
			yAxes: [{
				ticks:{display: false},
				gridLines:{display: false},
				scaleLabel: {
					display: true,
					labelString: ""
				}
			}],
			xAxes: [{
				ticks:{display: false},
				gridLines:{display: false},
				scaleLabel: {
					display: true,
					labelString: ""
				}
			}],
		},
	}
,
			})});
		</script>
	</div>

		</div>

		<div class="col-md-4 comp-grid">
			
	<div class="card reset-grids">
		<?php  
			
			$this->render_page("buses/add"); 
		?>
	</div>

		</div>

				</div>
			</div>
		</div>

		<div  class="">
			<div class="container-fluid">
				
				<div class="row ">
					
		<div class="col-md-12 comp-grid">
			<h3 >recent payments</h3>

	<div class="card reset-grids">
		<?php  
			
			$this->render_page("payments/list?orderby=date&ordertype=DESC&limit_count=3" , array( 'show_header' => false,'show_footer' => false,'show_pagination' => false )); 
		?>
	</div>

		</div>

				</div>
			</div>
		</div>

		</div>
	
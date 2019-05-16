
		<?php 
			$comp_model = new SharedController;
		?>
		<div>
			
		<div  class="bg-light p-3 mb-3">
			<div class="container-fluid">
				
				<div class="row ">
					
		<div class="col-md-12 comp-grid">
			<h3 >The Dashboard</h3>

		</div>

				</div>
			</div>
		</div>

		<div  class="">
			<div class="container-fluid">
				
				<div class="row ">
					
		<div class="col-md-12 comp-grid">
			
		</div>

		<div class="col-md-6 comp-grid">
			<div class="card ">
		<div class="card-header p-0 pt-2 px-2">
	<ul class="nav  nav-tabs   ">
		
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#TabPage-1-Page1" role="tab" aria-selected="true">
							 Schedule
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link " data-toggle="tab" href="#TabPage-1-Page2" role="tab" aria-selected="true">
							 Buses
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
							$menus = $comp_model->scheduleFrom_To_list(); // Get menu items from database
							if(!empty($menus)){
								//build menu items into arrays
								foreach($menus as $menu){
									$arr_menu[] = array(
										"path"=>"schedule/list/From_To/$menu[From_To]", 
										"label"=>"$menu[From_To] <span class='badge badge-primary float-right'>$menu[num]</span>", 
										"icon"=>' '
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
							$menus = $comp_model->busesbus_no_list(); // Get menu items from database
							if(!empty($menus)){
								//build menu items into arrays
								foreach($menus as $menu){
									$arr_menu[] = array(
										"path"=>"buses/list/bus_no/$menu[bus_no]", 
										"label"=>"$menu[bus_no] <span class='badge badge-primary float-right'>$menu[num]</span>", 
										"icon"=>' '
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

				</div>
			</div>
		</div>

		<div  class="">
			<div class="container-fluid">
				
				<div class="row ">
					
		<div class="col-md-12 comp-grid">
			
		</div>

		<div class="col-md-3 col-sm-4 comp-grid">
			
					<?php $rec_count = $comp_model->getcount_complains();  ?>
					<a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("complains/") ?>">
						<div class="row">
							<div class="col-2">
								<i class="fa fa-wechat "></i>
							</div>
							<div class="col-10">
								<div class="flex-column justify-content align-center">
									<div class="title">Complaints</div>
									
									<small class="">complaints</small>
								</div>
							</div>
							<h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
						</div>
						
					</a>
			
		</div>

				</div>
			</div>
		</div>

		</div>
	
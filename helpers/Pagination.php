<?php
	/**
	 * Public Functions Specific for this Framework
	 *
	 * @category  View Helper
	 */

	class Pagination{
		/**
	     The Current Page or table name for reference purpose
	     * @var int
	     */
		public $page_name;
		
		/**
	     Total Record In The Database Table
	     * @var int
	     */
		public $total_records;

		/**
	     * Total Record For The Current Page
	     * @var int
	     */
		public $current_record_count;

		/**
	     * Max Item to Retrieve Per Request
	     * @var int
	     */
		public $limit_count=MAX_RECORD_COUNT;

		/**
	     * Number of Link List Number
	     * @var int
	     */
		public $pager_link_range=4;

		/**
	     * Display Page Count Control
	     * @var boolean
	     */
		public $show_page_count=true;


		/**
	     * Show Control for the Total Number of Page Record And Database Table Record Count
	     * @var boolean
	     */
		public $show_record_count=true;

		/**
	     * Show Control For Limiting Number of Record Per Page
	     * @var boolean
	     */
		public $show_page_limit=true;


		/**
	     * Show Control For Pagination Link List Number
	     * @var boolean
	     */
		public $show_page_number_list=true;
		

		/**
	     * Initialize the Class
	     * @param string $total_records (Total Record In The Current Database Table)
	     * @param string $current_record_count (Current Page Total Record)
	     * @return null
	     */
		function __construct($total_records, $current_record_count){
			$this->total_records=$total_records;
			$this->current_record_count=$current_record_count;
		}
		
		/**
	     * Set Query String Parameters for the pagination such as $limit_start , $page_name
	     * @return link
	     */
		function set_link($limit_start=null){
			$qs=array();
			if($limit_start!==null){
				$qs["limit_start"]=$limit_start;
			}
			
			return print_link(set_current_page_link($qs));
		}
		


		/**
	     * Display The Pagination Component On The Page View
	     * @return HTML
	     */
		public function render(){
			$form_id=random_str();

			$page_pagination="";
			$limit_count=(!empty($_GET['limit_count']) ? $_GET['limit_count'] : $this->limit_count);
			$page_num = 1;
			
			if(!empty($_GET['limit_start'])){ 
				$page_num = $_GET['limit_start']; 
			}
			$numofpages = ceil($this->total_records/$limit_count); 
			$self ="";
			
			$record_position=min(($page_num * $limit_count),$this->total_records);
			
			//if ($numofpages > 1 ) {
				
				$range_min = ($this->pager_link_range % 2 == 0) ? ($this->pager_link_range / 2) - 1 : ($this->pager_link_range - 1) / 2; 
				$range_max = ($this->pager_link_range % 2 == 0) ? $range_min + 1 : $range_min; 
				$page_min = $page_num- $range_min; 
				$page_max = $page_num+ $range_max; 

				$page_min = ($page_min < 1) ? 1 : $page_min; 
				$page_max = ($page_max < ($page_min + $this->pager_link_range - 1)) ? $page_min + $this->pager_link_range - 1 : $page_max;
				
				if ($page_max > $numofpages) { 
					$page_min = ($page_min > 1) ? $numofpages - $this->pager_link_range + 1 : 1; 
					$page_max = $numofpages; 
				}
				$page_min = ($page_min < 1) ? 1 : $page_min; 
				
				$list_page_class="col-md-5";
				$detail_page_class="col";
				?>
				<form id="form<?php echo $form_id ?>" action="<?php echo ($this->set_link()); ?>" method="get">
					<div class="row justify-content-center">
						<?php 
							if($this->show_record_count==true ||  $this->show_page_limit==true){
								if($numofpages > 1){
									$detail_page_class="col";
									$list_page_class="col-md-5";
								}
						?>
						<div class="<?php echo $detail_page_class; ?>">
							<?php 
								if($this->show_record_count==true){
							?>
									<small class="text-muted"> Records  : <?php echo $record_position; ?> of  <?php echo $this->total_records; ?></small>
									
							<?php 
								}
							
								if($this->show_page_count==true){
							?>
									| <small class="text-muted">Page : 
										<select style="display:inline-block;width:70px" id="formselect<?php echo $form_id ?>" onchange="$('#form<?php echo $form_id ?>').submit()" name="limit_start" class="custom form-control form-control-sm">
											<?php
												for($i=1; $i<=$numofpages; $i++){
													?>
													<option <?php echo ($i == $page_num ? "selected" : null); ?>><?php echo $i; ?></option>
													<?php
												}
											?>
										</select> 
										of <?php echo $numofpages; ?>
									</small>
							<?php 
								}
						
								if($this->show_page_limit==true){
							?> |
							<small class="text-muted">
								 Limit
								<input style="display:inline-block;width:60px" onchange="$('#formselect<?php echo $form_id ?>').val(0);$('#form<?php echo $form_id ?>').submit()" type="number" step="1" min="1" value="<?php echo $limit_count; ?>" name="limit_count" class="form-control form-control-sm" />
							</small>
							<?php 
								}
							?>
						</div>
						
						<hr class="d-none d-block-sm" />
						<?php 
							}
				
							if ($numofpages > 1 ) {
						?>
						<div class="<?php echo $list_page_class ?>">
							<ul class="pagination pagination-sm">
								<?php
								
								if ($page_num != 1) {
									?>
									<li class="page-item">
										<a class="page-link" title="Go to First Page" href="<?php $this->set_link(1); ?>">
											<i class="fa fa-angle-double-left"></i>
										</a>
									</li>
									<?php
								}
								else{
									?>
									<li class="page-item">
										<a class="page-link" title="First Page"><i class="fa fa-angle-double-left"></i></a>
									</li>
									<?php
								}
								
								if ($page_num != 1) { 
									?>
									<li class="page-item">
										<a class="page-link" title="Go to Previous Page" href="<?php $this->set_link($page_num-1); ?>">
											<i class="fa fa-angle-left"></i>
										</a>
									</li>
									<?php
								}
								else{
									?>
									<li class="page-item">
										<a class="page-link" title="Previous Page"><i class="fa fa-angle-left"></i></a>
									</li>
									<?php
								}
								
								if($this->show_page_number_list==true){
									for ($i = $page_min;$i <= $page_max;$i++) {
										if ($i == $page_num){
											//Current Page Number
											// So Display No Link And Set in Active State
											?>
											<li class="page-item active">
												<a class="page-link" title="Page <?php echo $i; ?>"><?php echo $i; ?></a>
											</li>
											<?php
										}
										else{
											?>
											<li class="page-item">
												<a class="page-link" title="Go to Page <?php echo $i; ?>" href="<?php $this->set_link($i); ?>">
													<?php echo $i; ?>
												</a>
											</li>
											<?php
										}
									}
								}
								
								//next button
								if ($page_num < $numofpages) { 
									?>
									<li class="page-item">
										<a class="page-link" title="Go to Next Page" href="<?php $this->set_link($page_num + 1); ?>">
											<i class="fa fa-angle-right"></i>
										</a>
									</li>
									
									<?php
								}
								else{
									?>
									<li class="page-item">
										<a class="page-link" title="Next Page"><i class="fa fa-angle-right"></i></a>
									</li>
									<?php
								}
								//last button
								if ($page_num >= 1 && $numofpages > 1 && $numofpages!=$page_num) { 
									?>
										<li class="page-item">
											<a class="page-link" title="Go to Last Page" href="<?php $this->set_link($numofpages); ?>">
												<i class="fa fa-angle-double-right"></i>
											</a>
										</li>
									<?php
								}
								else{
									?>
										<li class="page-item">
											<a class="page-link" title="Last Page" ><i class="fa fa-angle-double-right"></i></a>
										</li>
									<?php
								}
								?>
							</ul>
						</div>
						<?php 
							}
						?>
					</div>
				</form>
			
				<?php
			//}
		}
		
	}
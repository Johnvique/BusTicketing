
<?php 
$can_add = PageAccessManager::is_allowed('buses/add');
$can_edit = PageAccessManager::is_allowed('buses/edit');
$can_view = PageAccessManager::is_allowed('buses/view');
$can_delete = PageAccessManager::is_allowed('buses/delete');
?>

<?php
$comp_model = new SharedController;

//Page Data From Controller
$view_data = $this->view_data;

$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = Router :: $field_name;
$field_value = Router :: $field_value;

$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;

?>

<section class="page">
    
    <?php
    if( $show_header == true ){
    ?>
    
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            
            <div class="row ">
                
                <div class="col-sm-4 comp-grid">
                    <h3 class="record-title">Buses</h3>
                    
                </div>
                
                <div class="col-sm-3 comp-grid">
                    
                    <?php 
                    if($can_add){
                    ?>
                    
                    <a  class="btn btn btn-primary btn-block" href="<?php print_link("buses/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Buses 
                    </a>
                    
                    <?php 
                    }
                    ?>
                    
                </div>
                
                <div class="col-sm-5 comp-grid">
                    
                    <form  class="search" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_query_str_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                    
                    <div class="col-md-12 comp-grid">
                        <div class="">
                            <?php
                            if(!empty($field_name) || !empty($field_name)){
                            ?>
                            <hr class="sm d-block d-sm-none" />
                            <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                                <ul class="breadcrumb m-0 p-1">
                                    <?php
                                    if(!empty($field_name)){
                                    ?>
                                    <li class="breadcrumb-item"><a class="text-capitalize" href="<?php print_link('buses') ?>"><?php echo $field_name ?></a></li>
                                    <li  class="breadcrumb-item active text-capitalize"><?php echo urldecode($field_value) ?></li>
                                    <?php 
                                    }   
                                    ?>
                                    <?php
                                    if(!empty($_GET['search'])){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-capitalize" href="<?php print_link('buses') ?>">Search</a>
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize"> <strong><?php echo get_value('search'); ?></strong></li>
                                    <?php
                                    }
                                    ?>
                                    
                                </ul>
                            </nav>  
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <?php
        }
        ?>
        
        <div  class="">
            <div class="container-fluid">
                
                <div class="row ">
                    
                    <div class="col-md-12 comp-grid">
                        
                        <?php $this :: display_page_errors(); ?>
                        
                        <div  class="card animated fadeIn">
                            <div id="buses-list-records">
                                
                                <?php
                                if(!empty($records)){
                                ?>
                                <div class="page-records">
                                    <div class="row">
                                        
                                        <?php
                                        $counter = 0;
                                        foreach($records as $data){
                                        $counter++;
                                        ?>
                                        <div class="col-sm-4">
                                            <div class="card p-2 mb-4">
                                                
                                                <div>
                                                    <a href="<?php print_link("buses/view/$data[id]") ?>"><?php echo $data['id']; ?></a>
                                                </div>
                                                
                                                <div>
                                                    <strong>Bus No</strong> :  <?php echo $data['bus_no']; ?> 
                                                </div>
                                                
                                                <div>
                                                    <strong>Seats No</strong> :  <?php echo $data['seats_no']; ?> 
                                                </div>
                                                
                                                <div>
                                                    <strong>Bus Type</strong> :  <?php echo $data['bus_type']; ?> 
                                                </div>
                                                
                                                <div>
                                                    <strong>Driver</strong> :  <?php echo $data['driver']; ?> 
                                                </div>
                                                
                                                <div>
                                                    <strong>Status</strong> :  <?php echo $data['status']; ?> 
                                                </div>
                                                
                                                
                                                <div>
                                                    
                                                    
                                                    <?php 
                                                    if($can_view){
                                                    ?>
                                                    
                                                    <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link('buses/view/'.$data['id']); ?>">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                    
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                    
                                                    <?php 
                                                    if($can_edit){
                                                    ?>
                                                    
                                                    <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link('buses/edit/'.$data['id']); ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                    
                                                    <?php 
                                                    if($can_delete){
                                                    ?>
                                                    
                                                    <a class="btn btn-sm btn-danger recordDeletePromptAction has-tooltip" title="Delete this record" href="<?php print_link("buses/delete/$data[id]"); ?>" data-prompt-msg="">
                                                        <i class="fa fa-times"></i>
                                                        Delete
                                                    </a>
                                                    
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                    
                                                    
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                        <?php 
                                        }
                                        ?>
                                        
                                    </div>
                                </div>
                                <?php
                                if( $show_footer == true ){
                                ?>
                                <div class="card-footer">
                                    <div class="row">   
                                        <div class="col-sm-2">  
                                            
                                            <?php Html :: import_form('buses/import_data' , "Import Data", 'CSV , JSON'); ?>
                                            
                                        </div>
                                        <div class="col">   
                                            
                                            <?php
                                            if( $show_pagination == true ){
                                            $pager = new Pagination($total_records,$record_count);
                                            $pager->page_name='buses';
                                            $pager->show_page_count=true;
                                            $pager->show_record_count=true;
                                            $pager->show_page_limit=true;
                                            $pager->show_page_number_list=true;
                                            $pager->pager_link_range=5;
                                            
                                            $pager->render();
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                }
                                else{
                                ?>
                                <div class="text-muted ">
                                    <h4><i class="fa fa-ban"></i> Record not found</h4>
                                </div>
                                <?php
                                }
                                ?>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        
    </section>
    
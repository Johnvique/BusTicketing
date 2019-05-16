
<?php 
$can_add = PageAccessManager::is_allowed('payments/add');
$can_edit = PageAccessManager::is_allowed('payments/edit');
$can_view = PageAccessManager::is_allowed('payments/view');
$can_delete = PageAccessManager::is_allowed('payments/delete');
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
                    <h3 class="record-title">Payments</h3>
                    
                </div>
                
                <div class="col-sm-3 comp-grid">
                    
                    <?php 
                    if($can_add){
                    ?>
                    
                    <a  class="btn btn btn-primary btn-block" href="<?php print_link("payments/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Payments 
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
                                    <li class="breadcrumb-item"><a class="text-capitalize" href="<?php print_link('payments') ?>"><?php echo $field_name ?></a></li>
                                    <li  class="breadcrumb-item active text-capitalize"><?php echo urldecode($field_value) ?></li>
                                    <?php 
                                    }   
                                    ?>
                                    <?php
                                    if(!empty($_GET['search'])){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-capitalize" href="<?php print_link('payments') ?>">Search</a>
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
                            <div id="payments-list-records">
                                
                                <?php
                                if(!empty($records)){
                                ?>
                                <div class="page-records table-responsive">
                                    <table class="table  table-striped table-sm">
                                        <thead class="table-header bg-light">
                                            <tr>
                                                <th class="td-sno td-checkbox"><input class="toggle-check-all" type="checkbox" /></th>
                                                
                                                <th class="td-sno">#</th>
                                                <th > Id</th>
                                                <th > Boking Id</th>
                                                <th > Date</th>
                                                <th > Transaction No</th>
                                                <th > Status</th>
                                                
                                                <th class="td-btn"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                            $counter = 0;
                                            foreach($records as $data){
                                            $counter++;
                                            ?>
                                            <tr>
                                                
                                                <th class=" td-checkbox">
                                                    <label>
                                                        <input class="optioncheck" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                                                        </label>
                                                    </th>
                                                    
                                                    <th class="td-sno"><?php echo $counter; ?></th>
                                                    <td><a href="<?php print_link("payments/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
                                                    <td> <?php echo $data['boking_id']; ?> </td>
                                                    <td> <?php echo $data['date']; ?> </td>
                                                    <td> <?php echo $data['transaction_no']; ?> </td>
                                                    <td> <?php echo $data['status']; ?> </td>
                                                    
                                                    
                                                    <td class="page-list-action">
                                                        
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                
                                                                <?php 
                                                                if($can_view){
                                                                ?>
                                                                
                                                                <a class="dropdown-item" href="<?php print_link("payments/view/$data[id]"); ?>">
                                                                    <i class="fa fa-eye"></i> View 
                                                                </a>
                                                                
                                                                <?php 
                                                                }
                                                                ?>
                                                                
                                                                
                                                                <?php 
                                                                if($can_edit){
                                                                ?>
                                                                
                                                                <a class="dropdown-item" href="<?php print_link("payments/edit/$data[id]"); ?>">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                                
                                                                <?php 
                                                                }
                                                                ?>
                                                                
                                                                
                                                                <?php 
                                                                if($can_delete){
                                                                ?>
                                                                
                                                                <a  class="recordDeletePromptAction dropdown-item" href="<?php print_link("payments/delete/$data[id]"); ?>" data-prompt-msg="">
                                                                    <i class="fa fa-times"></i> Delete 
                                                                </a>
                                                                
                                                                <?php 
                                                                }
                                                                ?>
                                                                
                                                            </ul>
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                                <?php 
                                                }
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                    if( $show_footer == true ){
                                    ?>
                                    <div class="card-footer">
                                        <div class="row">   
                                            <div class="col-sm-3">  
                                                
                                                <button data-prompt-msg="Are you sure you want to delete these records" data-url="<?php print_link("payments/delete/{sel_ids}"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                    <i class="material-icons">clear</i> Delete Selected
                                                </button>
                                                
                                                
                                                <button class="btn btn-sm btn-primary export-btn"><i class="fa fa-save"></i> Export</button>
                                                
                                                
                                                <?php Html :: import_form('payments/import_data' , "Import Data", 'CSV , JSON'); ?>
                                                
                                            </div>
                                            <div class="col">   
                                                
                                                <?php
                                                if( $show_pagination == true ){
                                                $pager = new Pagination($total_records,$record_count);
                                                $pager->page_name='payments';
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
                                    <div class="text-muted animated bounce">
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
        
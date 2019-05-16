
<?php 
$can_add = PageAccessManager::is_allowed('routes/add');
$can_edit = PageAccessManager::is_allowed('routes/edit');
$can_view = PageAccessManager::is_allowed('routes/view');
$can_delete = PageAccessManager::is_allowed('routes/delete');
?>

<?php
$comp_model = new SharedController;

//Page Data Information from Controller
$data = $this->view_data;

//$rec_id = $data['__tableprimarykey'];
$page_id = Router::$page_id; //Page id from url

$view_title = $this->view_title;

$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;

?>

<section class="page">
    
    <?php
    if( $show_header == true ){
    ?>
    
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            
            <div class="row ">
                
                <div class="col-12 comp-grid">
                    <h3 class="record-title">View  Routes</h3>
                    
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
                
                <div class="col-md-12 comp-grid">
                    
                    <?php $this :: display_page_errors(); ?>
                    
                    <div  class="card animated fadeIn">
                        <?php
                        if(!empty($data)){
                        ?>
                        <div class="page-records ">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody>
                                    
                                    <tr>
                                        <th class="title"> Id :</th>
                                        <td class="value"> <?php echo $data['id']; ?> </td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <th class="title"> Route :</th>
                                        <td class="value"> <?php echo $data['route']; ?> </td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <th class="title"> Day :</th>
                                        <td class="value"> <?php echo $data['day']; ?> </td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <th class="title"> Time :</th>
                                        <td class="value"> <?php echo $data['time']; ?> </td>
                                    </tr>
                                    
                                    
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3">
                            
                            
                            <?php 
                            if($can_edit){
                            ?>
                            
                            <a class="btn btn-sm btn-info"  href="<?php print_link("routes/edit/$data[id]"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            
                            <?php 
                            }
                            ?>
                            
                            
                            <?php 
                            if($can_delete){
                            ?>
                            
                            <a class="btn btn-sm btn-danger recordDeletePromptAction"  href="<?php print_link("routes/delete/$data[id]"); ?>" data-prompt-msg=""="">
                                <i class="fa fa-times"></i> Delete
                            </a>
                            
                            <?php 
                            }
                            ?>
                            
                            
                            <button class="btn btn-sm btn-primary export-btn">
                                <i class="fa fa-save"></i> Export
                            </button>
                            
                            
                        </div>
                        <?php
                        }
                        else{
                        ?>
                        <!-- Empty Record Message -->
                        <div class="text-muted panel-body">
                            <h3><i class="fa fa-ban"></i> No Record Found</h3>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
    
</section>

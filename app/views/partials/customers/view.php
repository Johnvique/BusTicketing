
<?php 
$can_add = PageAccessManager::is_allowed('customers/add');
$can_edit = PageAccessManager::is_allowed('customers/edit');
$can_view = PageAccessManager::is_allowed('customers/view');
$can_delete = PageAccessManager::is_allowed('customers/delete');
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
                    <h3 class="record-title">View  Customers</h3>
                    
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
                        <div class="profile-bg mb-2">
                            <div class="profile">
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="avatar"><img src="<?php print_link("assets/images/avatar.png") ?>" /> </div>
                                        <h2 class="title"><?php echo $data['name']; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <table class="table table-hover table-borderless table-striped">
                                    <tbody>
                                        
                                        <tr>
                                            <th class="title"> Id :</th>
                                            <td class="value"> <?php echo $data['id']; ?> </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th class="title"> Name :</th>
                                            <td class="value"> <?php echo $data['name']; ?> </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th class="title"> Phone :</th>
                                            <td class="value"> <?php echo $data['phone']; ?> </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th class="title"> Email :</th>
                                            <td class="value"> <?php echo $data['email']; ?> </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th class="title"> Role :</th>
                                            <td class="value"> <?php echo $data['role']; ?> </td>
                                        </tr>
                                        
                                        
                                    </tbody>    
                                </table>    
                            </div>  
                            <div class="mt-2">
                                
                                <?php 
                                if($can_edit){
                                ?>
                                
                                <a class="btn btn-sm btn-info"  href="<?php print_link("customers/edit/$data[id]"); ?>">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                
                                <?php 
                                }
                                ?>
                                
                                
                                <?php 
                                if($can_delete){
                                ?>
                                
                                <a class="btn btn-sm btn-danger recordDeletePromptAction"  href="<?php print_link("customers/delete/$data[id]"); ?>" data-prompt-msg=""="">
                                    <i class="fa fa-times"></i> Delete
                                </a>
                                
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
    
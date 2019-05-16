
<?php 
$can_add = PageAccessManager::is_allowed('account/add');
$can_edit = PageAccessManager::is_allowed('account/edit');
$can_view = PageAccessManager::is_allowed('account/view');
$can_delete = PageAccessManager::is_allowed('account/delete');
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
                    <h3 class="record-title">My Account</h3>
                    
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
                                <div class="avatar"><img src="<?php print_link("assets/images/avatar.png") ?>" /> </div>
                                    <h1 class="title mt-4"><?php echo $data['name']; ?></h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3 card p-2">
                                        <ul class="nav nav-pills flex-column text-left">
                                            <li class="nav-item"><a data-toggle="tab" href="#AccountPageView" class="nav-link active"><i class="fa fa-user"></i> Account Detail</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#AccountPageEdit" class="nav-link"><i class="fa fa-edit"></i> Edit Account</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#AccountPageChangeEmail" class="nav-link"><i class="fa fa-user"></i> Change Email</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#AccountPageChangePassword" class="nav-link"><i class="fa fa-key"></i> Reset Password</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="mb-3">
                                        <div class="tab-content">
                                            <div class="tab-pane show active fade" id="AccountPageView" role="tabpanel">
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
                                            <div class="tab-pane fade" id="AccountPageEdit" role="tabpanel">
                                                <div class=" reset-grids">
                                                    <?php  $this->render_page("account/edit"); ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane  fade" id="AccountPageChangeEmail" role="tabpanel">
                                                <div class=" reset-grids">
                                                    <?php  $this->render_page("account/change_email"); ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="AccountPageChangePassword" role="tabpanel">
                                                <div class=" reset-grids">
                                                    <?php  $this->render_page("passwordmanager"); ?>
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
        </div>
        
    </section>
    
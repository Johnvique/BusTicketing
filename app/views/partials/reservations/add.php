
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
                
                <div class="col-12 comp-grid">
                    <h3 class="record-title">Add New Reservations</h3>
                    
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
                        <form id="reservations-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal needs-validation"  novalidate action="<?php print_link("reservations/add") ?>" method="post">
                            <div class="card-body">
                                
                                
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="bus">Bus <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select required=""  name="bus" placeholder="Select a value ..."    class="form-control">
                                                    <option value="">Select a value ...</option>
                                                    
                                                    <?php 
                                                    $bus_options = $comp_model -> reservations_bus_option_list();
                                                    
                                                    if(!empty($bus_options)){
                                                    foreach($bus_options as $arr){
                                                    $val=array_values($arr);
                                                    ?>
                                                    <option <?php echo $this->set_field_selected('bus',$val[0]) ?> value="<?php echo $val[0]; ?>">
                                                        <?php echo (!empty($val[1]) ? $val[1] : $val[0]); ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    }
                                                    ?>
                                                    
                                                </select> 
                                                
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="level">Level <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="level" value="<?php  echo $this->set_field_value('level',''); ?>" type="text" placeholder="Enter Level"  required="" name="level" class="form-control " />
                                                    
                                                    
                                                    
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="status">Status <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <select required=""  name="status" placeholder="Select a value ..."    class="form-control">
                                                        <option value="">Select a value ...</option>
                                                        
                                                        <option <?php echo $this->set_field_selected('status','paid') ?> value="paid">Paid</option>
                                                        <option <?php echo $this->set_field_selected('status','pending') ?> value="pending">Pending</option>
                                                        <option <?php echo $this->set_field_selected('status','cancled') ?> value="cancled">Cancled</option>            
                                                    </select> 
                                                    
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="your_name">Your Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input  id="your_name" value="<?php  echo $this->set_field_value('your_name',''); ?>" type="text" placeholder="Enter Your Name"  required="" name="your_name" class="form-control " />
                                                        
                                                        
                                                        
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
        
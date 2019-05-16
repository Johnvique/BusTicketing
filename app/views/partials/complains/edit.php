
<?php
$comp_model = new SharedController;
$data = $this->view_data;

//$rec_id = $data['__tableprimarykey'];
$page_id = Router :: $page_id;

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
                    <h3 class="record-title">Edit  Complains</h3>
                    
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
                        <form role="form" enctype="multipart/form-data"  class="form form-horizontal needs-validation" novalidate action="<?php print_link("complains/edit/$page_id"); ?>" method="post">
                            <div class="card-body">
                                
                                
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="name">Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="name" value="<?php  echo $data['name']; ?>" type="text" placeholder="Enter Name"  required="" name="name" class="form-control " />
                                                    
                                                    
                                                    
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="booking_id">Booking Id <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input  id="booking_id" value="<?php  echo $data['booking_id']; ?>" type="text" placeholder="Enter Booking Id" list="booking_id_list"  required="" name="booking_id" class="form-control " />
                                                        
                                                        <datalist id="booking_id_list">
                                                            
                                                            <?php 
                                                            $booking_id_options = $comp_model -> complains_booking_id_option_list();
                                                            if(!empty($booking_id_options)){
                                                            foreach($booking_id_options as $arr){
                                                            $val = array_values($arr);
                                                            ?>
                                                            <option><?php echo (!empty($val[1]) ? $val[1] : $val[0]); ?></option>
                                                            <?php
                                                            }
                                                            }
                                                            ?>
                                                        </datalist> 
                                                        
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="driver">Driver <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input  id="driver" value="<?php  echo $data['driver']; ?>" type="text" placeholder="Enter Driver's name" list="driver_list"  required="" name="driver" class="form-control " />
                                                            
                                                            <datalist id="driver_list">
                                                                
                                                                <?php 
                                                                $driver_options = $comp_model -> complains_driver_option_list();
                                                                if(!empty($driver_options)){
                                                                foreach($driver_options as $arr){
                                                                $val = array_values($arr);
                                                                ?>
                                                                <option><?php echo (!empty($val[1]) ? $val[1] : $val[0]); ?></option>
                                                                <?php
                                                                }
                                                                }
                                                                ?>
                                                            </datalist> 
                                                            
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="bus_no">Bus No <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input  id="bus_no" value="<?php  echo $data['bus_no']; ?>" type="text" placeholder="Enter Bus No" list="bus_no_list"  required="" name="bus_no" class="form-control " />
                                                                
                                                                <datalist id="bus_no_list">
                                                                    
                                                                    <?php 
                                                                    $bus_no_options = $comp_model -> complains_bus_no_option_list();
                                                                    if(!empty($bus_no_options)){
                                                                    foreach($bus_no_options as $arr){
                                                                    $val = array_values($arr);
                                                                    ?>
                                                                    <option><?php echo (!empty($val[1]) ? $val[1] : $val[0]); ?></option>
                                                                    <?php
                                                                    }
                                                                    }
                                                                    ?>
                                                                </datalist> 
                                                                
                                                                
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="compliaint">Compliaint <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <textarea placeholder="Enter your Compliaint" required="" rows="" name="compliaint" class=" form-control"><?php  echo $data['compliaint']; ?></textarea>
                                                                
                                                                
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                            </div>
                                            <div class="form-group text-center">
                                                <button class="btn btn-primary" type="submit">
                                                    Update
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
                
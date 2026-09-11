

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customers</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>
 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Edit Customers</h3>
            </div>
            <form role="form" action="<?php base_url('customers/edit') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="gender">Customer Type</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" id="male" value="1" <?php if($user_data['ctype'] == 1) {
                        echo "checked";
                      } ?>>
                      Private Customer
                    </label>
                    <label>
                      <input type="radio" name="gender" id="female" value="2" <?php if($user_data['ctype'] == 2) {
                        echo "checked";
                      } ?>>
                      Government Office Customer
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label for="username">Employe Name</label>
                  <input type="text" class="form-control" id="username" name="username" value="<?php echo $user_data['username'] ?>" placeholder="Employe name" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="email">Employe Position</label>
                  <input type="text" class="form-control" id="email" name="epossition" value="<?php echo $user_data['epossition'] ?>" autocomplete="off">
                </div>

               

                <div class="form-group">
                  <label for="fname">Organization Name</label>
                  <input type="text" class="form-control" id="fname" name="oname" value="<?php echo $user_data['oname'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="lname">Organization Address</label>
                  <input type="text" class="form-control" id="lname" name="oaddress" value="<?php echo $user_data['oaddress'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $user_data['phone'] ?>" autocomplete="off">
                </div>

             

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('customers/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          </div>
         
        
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#groups").select2();

    $("#mainUserNav").addClass('active');
    $("#manageUserNav").addClass('active');
  });
</script>

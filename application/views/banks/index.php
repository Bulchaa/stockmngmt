<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Payment Accounts</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Payment Accounts</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

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

        <?php if(in_array('updateSetting', $user_permission)): ?>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addBankModal">Add Payment Account</button>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Payment Accounts</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Bank / Provider</th>
                <th>Account Holder</th>
                <th>Account Number</th>
                <th>Category</th>
                <th>Status</th>
                <?php if(in_array('updateSetting', $user_permission)): ?>
                  <th>Action</th>
                <?php endif; ?>
              </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
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

<?php if(in_array('updateSetting', $user_permission)): ?>
<!-- create bank modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addBankModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Payment Account</h4>
      </div>

      <form role="form" action="<?php echo base_url('banks/create') ?>" method="post" id="createBankForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="bank_name">Bank / Provider Name</label>
            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="e.g. Commercial Bank of Ethiopia / Telebirr" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="account_name">Account Holder Name</label>
            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="e.g. Qubeteck Software" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="account_number">Account Number</label>
            <input type="text" class="form-control" id="account_number" name="account_number" placeholder="e.g. 100013456789 or 0900123456" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="account_type">Account Type (optional)</label>
            <input type="text" class="form-control" id="account_type" name="account_type" placeholder="e.g. Saving / Current / Personal" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category">
              <option value="bank">Bank Transfer</option>
              <option value="telebirr">Telebirr</option>
            </select>
          </div>
          <div class="form-group">
            <label for="is_default">Default</label>
            <select class="form-control" id="is_default" name="is_default">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
          <div class="form-group">
            <label for="is_active">Status</label>
            <select class="form-control" id="is_active" name="is_active">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('updateSetting', $user_permission)): ?>
<!-- edit bank modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editBankModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Payment Account</h4>
      </div>

      <form role="form" action="<?php echo base_url('banks/update') ?>" method="post" id="updateBankForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="edit_bank_name">Bank / Provider Name</label>
            <input type="text" class="form-control" id="edit_bank_name" name="edit_bank_name" placeholder="e.g. Commercial Bank of Ethiopia / Telebirr" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_account_name">Account Holder Name</label>
            <input type="text" class="form-control" id="edit_account_name" name="edit_account_name" placeholder="e.g. Qubeteck Software" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_account_number">Account Number</label>
            <input type="text" class="form-control" id="edit_account_number" name="edit_account_number" placeholder="e.g. 100013456789 or 0900123456" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_account_type">Account Type (optional)</label>
            <input type="text" class="form-control" id="edit_account_type" name="edit_account_type" placeholder="e.g. Saving / Current / Personal" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_category">Category</label>
            <select class="form-control" id="edit_category" name="edit_category">
              <option value="bank">Bank Transfer</option>
              <option value="telebirr">Telebirr</option>
            </select>
          </div>
          <div class="form-group">
            <label for="edit_is_default">Default</label>
            <select class="form-control" id="edit_is_default" name="edit_is_default">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
          <div class="form-group">
            <label for="edit_is_active">Status</label>
            <select class="form-control" id="edit_is_active" name="edit_is_active">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('updateSetting', $user_permission)): ?>
<!-- remove bank modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeBankModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Payment Account</h4>
      </div>

      <form role="form" action="<?php echo base_url('banks/remove') ?>" method="post" id="removeBankForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>



<script type="text/javascript">
var manageTable;

$(document).ready(function() {

  $("#banksNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'fetchBankData',
    'order': []
  });

  // submit the create from 
  $("#createBankForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTable.ajax.reload(null, false); 

        if(response.success === true) {
          $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');


          // hide the modal
          $("#addBankModal").modal('hide');

          // reset the form
          $("#createBankForm")[0].reset();
          $("#createBankForm .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');
              
              id.after(value);

            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    }); 

    return false;
  });


});

function editBank(id)
{ 
  $.ajax({
    url: 'fetchBankDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

      $("#edit_bank_name").val(response.bank_name);
      $("#edit_account_name").val(response.account_name);
      $("#edit_account_number").val(response.account_number);
      $("#edit_account_type").val(response.account_type);
      $("#edit_category").val(response.category);
      $("#edit_is_default").val(response.is_default);
      $("#edit_is_active").val(response.is_active);

      // submit the edit from 
      $("#updateBankForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            manageTable.ajax.reload(null, false); 

            if(response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');


              // hide the modal
              $("#editBankModal").modal('hide');
              // reset the form 
              $("#updateBankForm .form-group").removeClass('has-error').removeClass('has-success');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  
                  id.after(value);

                });
              } else {
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 

        return false;
      });

    }
  });
}

function removeBank(id)
{
  if(id) {
    $("#removeBankForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { bank_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeBankModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}


</script>
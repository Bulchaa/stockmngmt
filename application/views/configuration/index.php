
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        System <small>Configuration</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">System Configuration</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>
          <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fa fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" role="tablist">
              <li class="active"><a href="#tab-company" data-toggle="tab"><i class="fa fa-building"></i> Company</a></li>
              <li><a href="#tab-banks" data-toggle="tab"><i class="fa fa-university"></i> Payment Accounts</a></li>
              <li><a href="#tab-printer" data-toggle="tab"><i class="fa fa-print"></i> Printer</a></li>
              <li><a href="#tab-paper" data-toggle="tab"><i class="fa fa-file-o"></i> Paper Size</a></li>
            </ul>

            <div class="tab-content">

              <div class="tab-pane <?php if($active_tab == 'company') echo 'active'; ?>" id="tab-company">
                <?php echo $company_partial; ?>
              </div>

              <div class="tab-pane <?php if($active_tab == 'banks') echo 'active'; ?>" id="tab-banks">
                <?php echo $banks_partial; ?>
              </div>

              <div class="tab-pane <?php if($active_tab == 'printer') echo 'active'; ?>" id="tab-printer">
                <?php echo $printer_partial; ?>
              </div>

              <div class="tab-pane <?php if($active_tab == 'paper') echo 'active'; ?>" id="tab-paper">
                <?php echo $paper_partial; ?>
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

<script>
(function(){
  $('#cfg_message').wysihtml5();

  $('#cfg_test_sms_btn').click(function(){
    $('#cfg_test_sms_fields').toggle();
    $('#cfg_test_sms_result').html('');
  });
  $('#cfg_send_test_sms_btn').click(function(){
    var phone = $.trim($('#cfg_test_phone').val());
    var msg   = $.trim($('#cfg_test_message').val());
    if(!phone){ alert('Enter test phone.'); return; }
    $('#cfg_test_sms_result').html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Sending...</span>');
    $.ajax({
      url: '<?php echo base_url("orders/send_test_sms") ?>',
      type: 'POST',
      data: {phone: phone, message: msg},
      success: function(resp){
        if(resp.success) $('#cfg_test_sms_result').html('<span class="text-success"><i class="fa fa-check"></i> Sent OK.</span>');
        else             $('#cfg_test_sms_result').html('<span class="text-danger"><i class="fa fa-times"></i> '+resp.error+'</span>');
      },
      error: function(){ $('#cfg_test_sms_result').html('<span class="text-danger">Request error.</span>'); }
    });
  });

  var cfg_manageTable = $('#cfg_manageTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '<?php echo base_url("banks/fetchBankData") ?>',
      type: 'POST'
    },
    columns: [
      { data: 0, visible: false },
      { data: 1 },
      { data: 2 },
      { data: 3 },
      { data: 4 },
      { data: 5 },
      { data: 6,
        render: function(d, type, row){
          var id = row[0];
          return '<button type="button" class="btn btn-warning btn-sm cfg_edit_bank" data-id="'+id+'"><i class="fa fa-pencil"></i></button> '
               + '<button type="button" class="btn btn-danger btn-sm cfg_remove_bank" data-id="'+id+'"><i class="fa fa-trash"></i></button>';
        }
      }
    ]
  });

  $(document).on('click', '.cfg_edit_bank', function(){
    var id = $(this).data('id');
    $.ajax({
      url: '<?php echo base_url("banks/fetchBankDataById") ?>',
      type: 'POST',
      data: {id: id},
      dataType: 'json',
      success: function(d){
        $('#cfg_edit_bank_name').val(d.bank_name);
        $('#cfg_edit_account_name').val(d.account_name);
        $('#cfg_edit_account_number').val(d.account_number);
        $('#cfg_edit_account_type').val(d.account_type);
        $('#cfg_edit_category').val(d.category);
        $('#cfg_edit_is_default').val(d.is_default);
        $('#cfg_edit_is_active').val(d.is_active);
        $('#cfg_editBankModal').modal('show');
      },
      error: function(){ alert('Failed to fetch bank data.'); }
    });
  });

  $(document).on('click', '.cfg_remove_bank', function(){
    $('#cfg_removeBankForm').find('input[name="id"]').remove();
    $('#cfg_removeBankForm').append('<input type="hidden" name="id" value="'+$(this).data('id')+'">');
    $('#cfg_removeBankModal').modal('show');
  });

  $('#cfg_createBankForm').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function(resp){
        if(resp.success){
          $('#cfg_bank_messages').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check"></i> '+resp.messages+'</div>');
          form.trigger('reset');
          $('#cfg_addBankModal').modal('hide');
          cfg_manageTable.ajax.reload();
        } else {
          $('#cfg_bank_messages').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-times"></i> '+resp.messages+'</div>');
        }
      },
      error: function(){ $('#cfg_bank_messages').html('<div class="alert alert-danger">Request error.</div>'); }
    });
  });

  $('#cfg_updateBankForm').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function(resp){
        if(resp.success){
          $('#cfg_bank_messages').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check"></i> '+resp.messages+'</div>');
          $('#cfg_editBankModal').modal('hide');
          cfg_manageTable.ajax.reload();
        } else {
          $('#cfg_bank_messages').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-times"></i> '+resp.messages+'</div>');
        }
      },
      error: function(){ $('#cfg_bank_messages').html('<div class="alert alert-danger">Request error.</div>'); }
    });
  });

  $('#cfg_removeBankForm').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function(resp){
        if(resp.success){
          $('#cfg_bank_messages').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check"></i> '+resp.messages+'</div>');
          $('#cfg_removeBankModal').modal('hide');
          cfg_manageTable.ajax.reload();
        } else {
          $('#cfg_bank_messages').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-times"></i> '+resp.messages+'</div>');
        }
      },
      error: function(){ $('#cfg_bank_messages').html('<div class="alert alert-danger">Request error.</div>'); }
    });
  });

  var cfg_paper_presets = {
    '80':  { label:'80mm',  w:80,  h:297 },
    '58':  { label:'58mm',  w:58,  h:210 },
    'a5':  { label:'A5',    w:148, h:210 },
    'a4':  { label:'A4',    w:210, h:297 }
  };
  $('#cfg_paper_preset').on('change', function(){
    var v = $(this).val();
    if(cfg_paper_presets[v]){
      var p = cfg_paper_presets[v];
      $('#cfg_paper_size_label').val(p.label);
      $('#cfg_paper_width').val(p.w);
      $('#cfg_paper_height').val(p.h);
    } else {
      $('#cfg_paper_size_label').val('');
      $('#cfg_paper_width').val('');
      $('#cfg_paper_height').val('');
    }
  });

})();
</script>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Company</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">company</li>
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
              <h3 class="box-title">Manage Company Information</h3>
            </div>
            <form role="form" action="<?php base_url('company/update') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="company_name">Company Name</label>
                  <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" value="<?php echo $company_data['company_name'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="service_charge_value">Charge Amount (%)</label>
                  <input type="text" class="form-control" id="service_charge_value" name="service_charge_value" placeholder="Enter charge amount %" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="vat_charge_value">Vat Charge (%)</label>
                  <input type="text" class="form-control" id="vat_charge_value" name="vat_charge_value" placeholder="Enter vat charge %" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php echo $company_data['address'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="<?php echo $company_data['phone'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" value="<?php echo $company_data['country'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="permission">Message</label>
                  <textarea class="form-control" id="message" name="message">
                     <?php echo $company_data['message'] ?>
                  </textarea>
                </div>
                  
                   <div class="col-md-12 col-xs-12">
                       <div class="row">
                     <div class="form-group col-md-4">
                  <label for="address"><i class="fa fa-globe fa-1x" style="color: #006a00;"></i> Website</label>
                  <input type="text" class="form-control" id="address" name="website" placeholder="Enter address" value="<?php echo $company_data['website'] ?>" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="phone"><i class="fa fa-facebook-square fa-1x" style="color: #000080;"></i> Facebook</label>
                  <input type="text" class="form-control" id="phone" name="facebook" placeholder="Enter phone" value="<?php echo $company_data['facebook'] ?>" autocomplete="off">
                </div>  
                <div class="form-group col-md-4">
                  <label for="country"><i class="fa fa-telegram fa-1x" style="color: #007fff;"></i> Telegram</label>
                  <input type="text" class="form-control" id="country" name="telegram" placeholder="Enter country" value="<?php echo $company_data['telegram'] ?>" autocomplete="off">
                </div>
              
                <div class="form-group col-md-4">
                  <label for="country"><i class="fa fa-tiktok fa-1x" style="color: #007fff;"></i> tiktok</label>
                  <input type="text" class="form-control" id="tiktok" name="tiktok" placeholder="Enter tiktok" value="<?php echo $company_data['tiktok'] ?>" autocomplete="off">
                </div>
              </div>
                   </div>
                  
                  
                  
                <div class="form-group">
                  <label for="currency">Currency</label>
                  <?php ?>
                  <select class="form-control" id="currency" name="currency">
                    <option value="">~~SELECT~~</option>

                    <?php foreach ($currency_symbols as $k => $v): ?>
                      <option value="<?php echo trim($k); ?>" <?php if($company_data['currency'] == $k) {
                        echo "selected";
                      } ?>><?php echo $k ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <hr />

                <h4>SMS Settings (GeeSMS)</h4>
                <p style="color: #888;">Get your API token at <a href="https://geezsms.com/#/api" target="_blank">geezsms.com/#/api</a>. SMS are sent to customers automatically when orders are created, status changes, or payments are received.</p>

                <div class="form-group">
                  <label for="sms_enabled">Enable SMS Notifications</label>
                  <select class="form-control" id="sms_enabled" name="sms_enabled">
                    <option value="0" <?php if(isset($company_data['sms_enabled']) && $company_data['sms_enabled'] == 0) echo "selected"; ?>>Disabled</option>
                    <option value="1" <?php if(isset($company_data['sms_enabled']) && $company_data['sms_enabled'] == 1) echo "selected"; ?>>Enabled</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="sms_token">GeeSMS API Token</label>
                  <input type="text" class="form-control" id="sms_token" name="sms_token" placeholder="Enter GeeSMS API token" value="<?php echo isset($company_data['sms_token']) ? $company_data['sms_token'] : '' ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="sms_shortcode">Shortcode ID (optional)</label>
                  <input type="text" class="form-control" id="sms_shortcode" name="sms_shortcode" placeholder="Enter shortcode id" value="<?php echo isset($company_data['sms_shortcode']) ? $company_data['sms_shortcode'] : '' ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="test_sms_btn">Send Test SMS</button>
                  <span id="test_sms_result"></span>
                </div>
                <div class="form-group" id="test_sms_fields" style="display:none;">
                  <label for="test_phone">Test Phone (0911XXXXXX)</label>
                  <input type="text" class="form-control" id="test_phone" name="test_phone" placeholder="0911223344" autocomplete="off">
                  <br />
                  <label for="test_message">Test Message</label>
                  <textarea class="form-control" id="test_message" name="test_message">Test SMS from Yeroo. This is a test message to verify the GeeSMS integration.</textarea>
                  <br />
                  <button type="button" class="btn btn-success" id="send_test_sms_btn">Send</button>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
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
    $("#companyNav").addClass('active');
    $("#message").wysihtml5();

    $("#test_sms_btn").click(function() {
      $("#test_sms_fields").toggle();
    });

    $("#send_test_sms_btn").click(function() {
      var phone = $("#test_phone").val();
      var message = $("#test_message").val();

      if(phone == '') {
        alert('Please enter a phone number.');
        return;
      }
      if(message == '') {
        alert('Please enter a message.');
        return;
      }

      $("#test_sms_result").html('<i class="fa fa-spinner fa-spin"></i> Sending...');

      $.ajax({
        url: '<?php echo base_url("orders/send_test_sms") ?>',
        type: 'post',
        data: {
          phone: phone,
          message: message,
          token: $("#sms_token").val(),
          shortcode: $("#sms_shortcode").val()
        },
        dataType: 'json',
        success:function(response) {
          if(response.success === true) {
            $("#test_sms_result").html('<span class="text-success">SMS sent successfully.</span>');
          } else {
            $("#test_sms_result").html('<span class="text-danger">' + response.message + '</span>');
          }
        }
      });
    });
  });
</script>


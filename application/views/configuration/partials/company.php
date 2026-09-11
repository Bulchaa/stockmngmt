<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-building"></i> Company Information</h3>
  </div>
  <form role="form" action="<?php echo base_url('configuration/update_company') ?>" method="post">
    <div class="box-body">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Company Name *</label>
            <input type="text" class="form-control" name="company_name" placeholder="Company name" value="<?php echo $company_data['company_name'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Charge Amount (%)</label>
            <input type="number" class="form-control" name="service_charge_value" placeholder="0" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label>VAT (%)</label>
            <input type="number" class="form-control" name="vat_charge_value" placeholder="0" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Address *</label>
            <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $company_data['address'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo $company_data['phone'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Country</label>
            <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo $company_data['country'] ?>" autocomplete="off">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Message *</label>
            <textarea class="form-control" id="cfg_message" name="message" rows="3"><?php echo $company_data['message'] ?></textarea>
          </div>
          <div class="form-group">
            <label><i class="fa fa-globe" style="color:#006a00;"></i> Website</label>
            <input type="text" class="form-control" name="website" placeholder="https://" value="<?php echo $company_data['website'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label><i class="fa fa-facebook-square" style="color:#3b5998;"></i> Facebook</label>
            <input type="text" class="form-control" name="facebook" placeholder="Facebook URL" value="<?php echo $company_data['facebook'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label><i class="fa fa-telegram" style="color:#0088cc;"></i> Telegram</label>
            <input type="text" class="form-control" name="telegram" placeholder="Telegram" value="<?php echo $company_data['telegram'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label><i class="fa fa-tiktok"></i> TikTok</label>
            <input type="text" class="form-control" name="tiktok" placeholder="TikTok" value="<?php echo $company_data['tiktok'] ?>" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Currency</label>
            <select class="form-control" name="currency">
              <option value="">~~SELECT~~</option>
              <?php foreach($currency_symbols as $k => $v): ?>
                <option value="<?php echo trim($k); ?>" <?php if($company_data['currency'] == $k) echo "selected"; ?>><?php echo $k ?> (<?php echo $v ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <hr />
      <h4><i class="fa fa-envelope"></i> SMS Settings (GeeSMS)</h4>
      <p style="color:#888;">API token from <a href="https://geezsms.com/#/api" target="_blank">geezsms.com/#/api</a></p>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Enable SMS</label>
            <select class="form-control" name="sms_enabled">
              <option value="0" <?php if(isset($company_data['sms_enabled']) && $company_data['sms_enabled'] == 0) echo "selected"; ?>>Disabled</option>
              <option value="1" <?php if(isset($company_data['sms_enabled']) && $company_data['sms_enabled'] == 1) echo "selected"; ?>>Enabled</option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>GeeSMS API Token</label>
            <input type="text" class="form-control" name="sms_token" placeholder="API token" value="<?php echo isset($company_data['sms_token']) ? $company_data['sms_token'] : '' ?>" autocomplete="off">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Shortcode ID (optional)</label>
            <input type="text" class="form-control" name="sms_shortcode" placeholder="Shortcode ID" value="<?php echo isset($company_data['sms_shortcode']) ? $company_data['sms_shortcode'] : '' ?>" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <button type="button" class="btn btn-info btn-sm" id="cfg_test_sms_btn"><i class="fa fa-flask"></i> Send Test SMS</button>
          <span id="cfg_test_sms_result"></span>
        </div>
      </div>
      <div id="cfg_test_sms_fields" class="row" style="display:none; margin-top:10px;">
        <div class="col-md-3">
          <input type="text" class="form-control" id="cfg_test_phone" placeholder="Test phone (0911...)" autocomplete="off">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control" id="cfg_test_message" placeholder="Test message" value="Test SMS from our store. This is a test." autocomplete="off">
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-success btn-sm" id="cfg_send_test_sms_btn">Send</button>
        </div>
      </div>

    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Company</button>
    </div>
  </form>
</div>

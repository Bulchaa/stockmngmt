<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-university"></i> Payment Accounts</h3>
  </div>
  <div class="box-body">
    <div id="cfg_bank_messages"></div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cfg_addBankModal"><i class="fa fa-plus"></i> Add Payment Account</button>
    <br /><br />
    <table id="cfg_manageTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Bank / Provider</th>
          <th>Account Holder</th>
          <th>Account Number</th>
          <th>Category</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Add Bank Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="cfg_addBankModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Payment Account</h4>
      </div>
      <form role="form" action="<?php echo base_url('banks/create') ?>" method="post" id="cfg_createBankForm">
        <div class="modal-body">
          <div class="form-group">
            <label>Bank / Provider Name *</label>
            <input type="text" class="form-control" name="bank_name" placeholder="e.g. Commercial Bank of Ethiopia" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Account Holder Name *</label>
            <input type="text" class="form-control" name="account_name" placeholder="Account holder name" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Account Number *</label>
            <input type="text" class="form-control" name="account_number" placeholder="Account or Telebirr number" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Account Type</label>
            <input type="text" class="form-control" name="account_type" placeholder="Saving / Current / Personal" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Category *</label>
            <select class="form-control" name="category">
              <option value="bank">Bank Transfer</option>
              <option value="telebirr">Telebirr</option>
            </select>
          </div>
          <div class="form-group">
            <label>Default?</label>
            <select class="form-control" name="is_default"><option value="0">No</option><option value="1">Yes</option></select>
          </div>
          <div class="form-group">
            <label>Active</label>
            <select class="form-control" name="is_active"><option value="1">Yes</option><option value="0">No</option></select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Bank Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="cfg_editBankModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-yellow">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Payment Account</h4>
      </div>
      <form role="form" action="<?php echo base_url('banks/update') ?>" method="post" id="cfg_updateBankForm">
        <div class="modal-body">
          <div class="form-group">
            <label>Bank / Provider Name *</label>
            <input type="text" class="form-control" id="cfg_edit_bank_name" name="edit_bank_name" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Account Holder Name *</label>
            <input type="text" class="form-control" id="cfg_edit_account_name" name="edit_account_name" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Account Number *</label>
            <input type="text" class="form-control" id="cfg_edit_account_number" name="edit_account_number" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Account Type</label>
            <input type="text" class="form-control" id="cfg_edit_account_type" name="edit_account_type" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Category *</label>
            <select class="form-control" id="cfg_edit_category" name="edit_category">
              <option value="bank">Bank Transfer</option>
              <option value="telebirr">Telebirr</option>
            </select>
          </div>
          <div class="form-group">
            <label>Default?</label>
            <select class="form-control" id="cfg_edit_is_default" name="edit_is_default"><option value="0">No</option><option value="1">Yes</option></select>
          </div>
          <div class="form-group">
            <label>Active</label>
            <select class="form-control" id="cfg_edit_is_active" name="edit_is_active"><option value="1">Yes</option><option value="0">No</option></select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Remove Bank Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="cfg_removeBankModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-red">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-trash"></i> Remove Payment Account</h4>
      </div>
      <form role="form" action="<?php echo base_url('banks/remove') ?>" method="post" id="cfg_removeBankForm">
        <div class="modal-body"><p>Are you sure you want to remove this payment account?</p></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Remove</button>
        </div>
      </form>
    </div>
  </div>
</div>

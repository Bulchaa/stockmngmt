<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-print"></i> Printer Settings</h3>
  </div>
  <form role="form" action="<?php echo base_url('configuration/update_printer') ?>" method="post">
    <div class="box-body">
      <div class="form-group">
        <label>Printer Type *</label>
        <select class="form-control" name="printer_type">
          <option value="thermal" <?php if($company_data['printer_type'] == 'thermal') echo 'selected'; ?>>Thermal (80mm) - Receipt Printer</option>
          <option value="thermal58" <?php if($company_data['printer_type'] == 'thermal58') echo 'selected'; ?>>Thermal (58mm) - Receipt Printer</option>
          <option value="inkjet" <?php if($company_data['printer_type'] == 'inkjet') echo 'selected'; ?>>Inkjet / Laser - A4/A5 Paper</option>
        </select>
        <p class="help-block">Choose the type of printer used for printing receipts and invoices.</p>
      </div>
    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Printer Settings</button>
    </div>
  </form>
</div>
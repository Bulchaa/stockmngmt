<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-file-o"></i> Paper Size</h3>
  </div>
  <form role="form" action="<?php echo base_url('configuration/update_paper') ?>" method="post">
    <div class="box-body">
      <div class="form-group">
        <label>Print Paper Preset</label>
        <select class="form-control" id="cfg_paper_preset" name="paper_preset">
          <option value="80"  <?php echo ($company_data['paper_size'] == '80mm')  ? 'selected' : ''; ?>>80mm Receipt (80 x 297 mm)</option>
          <option value="58"  <?php echo ($company_data['paper_size'] == '58mm')  ? 'selected' : ''; ?>>58mm Receipt (58 x 210 mm)</option>
          <option value="a5"  <?php echo ($company_data['paper_size'] == 'A5')    ? 'selected' : ''; ?>>A5 (148 x 210 mm)</option>
          <option value="a4"  <?php echo ($company_data['paper_size'] == 'A4')    ? 'selected' : ''; ?>>A4 (210 x 297 mm)</option>
          <option value="custom" <?php if(!in_array($company_data['paper_size'], array('80mm','58mm','A5','A4'))) echo 'selected'; ?>>Custom...</option>
        </select>
      </div>
      <div class="form-group">
        <label>Size Label</label>
        <input type="text" class="form-control" id="cfg_paper_size_label" name="paper_size" placeholder="80mm" value="<?php echo $company_data['paper_size'] ?>" autocomplete="off">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Width (mm) *</label>
            <input type="number" class="form-control" id="cfg_paper_width" name="paper_width" placeholder="80" value="<?php echo $company_data['paper_width'] ?>" min="1" autocomplete="off">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Height (mm) *</label>
            <input type="number" class="form-control" id="cfg_paper_height" name="paper_height" placeholder="297" value="<?php echo $company_data['paper_height'] ?>" min="1" autocomplete="off">
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Paper Size</button>
    </div>
  </form>
</div>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Sales
      <small>Report</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Sales Report</li>
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

       <div class="box">
           <div class="box-header">
            <div class="row">
              <form action="report/sales" method="POST" autocomplete="off">
                
                <div class="col-md-5">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control datepicker pull-right" id="datepicker_1" name="date_from" value="<?php if(isset($_POST["date_from"])){ echo $_POST["date_from"]; }  ?>">
                    </div>
                </div>
                <!-- col-md-5 -->
                <div class="col-md-5">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calender"></i>
                      </div>
                      <input type="date" class="form-control datepicker pull-right" id="datepicker_2" name="date_to" value="<?php if(isset($_POST["date_to"])){ echo $_POST["date_to"]; }  ?>">
                    </div>
                </div>
                <!-- col-md-5 -->
                <div class="col-md-2">
                    <div align="center">
                        <button type="submit" class="btn btn-success" name="btnDateFilter" value="Filter By Date">Filter By Date</button>
                    </div>
                </div>
                <!-- div.col-md-2 -->
                
              </form>
            </div></div>
           <div class="box-body">     
           <div class="row">
       
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">የጠቅለላ ትዕዘዛ ዋጋ/Total Order Price</span>
              <span class="info-box-number">
                    <?php foreach ($total as $k => $v): ?>
                  <?php  $totalsum[] = $v['total_amount'];
                     
                  endforeach;
                   $totalsumnet = array_sum($totalsum);
                      echo $totalsumnet;
                  ?>
                  
                  Birr</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Paid Total/የተከፈለ ብር</span>
              <span class="info-box-number">
                     <?php foreach ($total as $k => $v): ?>
                  <?php  $totalsum2[] = $v['paid_amount'];
                     
                  endforeach;
                   $totalsumnet2 = array_sum($totalsum2);
                      echo $totalsumnet2;
                  ?>
                     
                  Birr</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Due Amount/ቅሪ ብር</span>
              <span class="info-box-number">
                      <?php foreach ($total as $k => $v): ?>
                  <?php  $totalsum3[] = $v['due_amount'];
                     
                  endforeach;
                   $totalsumnet3 = array_sum($totalsum3);
                      echo $totalsumnet3;
                  ?>
                     
                  Birr
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
       </div>
           </div>
        <div class="box">
           <div class="box-header with-border">
            <?php if(isset($_POST["btnDateFilter"])){ ?>
              <h3 class="box-title"><?php echo "From ".$_POST["date_from"]." to ".$_POST["date_to"] ?></h3>
              <?php }else{ ?>
                <h3 class="box-title">All Sales Report</h3>
              <?php } ?>
        </div>
          <!-- /.box-header -->
          <div class="box-body">
              
            <table  class="table table-striped">
              <thead>
              <tr>
                <th>Bill no</th>
                <th>Customer Name</th>
                <th>Customer Types</th>
                <th>Date Time</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Paid status</th>
                 <th>Payment Types</th>
                <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                  
                <?php endif; ?>
              </tr> </thead>
              
              <tbody>
                  <tr>
                 <?php
                  if($user_data): ?> 
                   <?php foreach ($user_data as $key => $value): 
                       $date = date('d-m-Y', $value['payment_info']['datetime']);
			$time = date('h:i a', $value['payment_info']['datetime']);
                       $date_time = $date . ' ' . $time;
                      
                       ?>
                  <tr><td> <?php echo $value['payment_info']['bill_no']; ?></td>
			<td><?php 
                        if ($value['payment_info']['customer_types'] == 2) {
                      $users_data = $this->model_customers->getCustomerData($value['payment_info']['customer_name']);
                        
                        echo $users_data['username'].'/'.$users_data['oname']; 
                        }
                        else {
                        $orders_data = $this->model_orders->getOrdersData($value['payment_info']['order_no']);
                        echo $orders_data['customer_name'];
                        
                        }
                        
                        ?>
                        </td>
			<td><?php 
                         if($value['payment_info']['customer_types'] == 2) {
				$customer = '<span class="label label-danger">የድርጀት ድንብኘ</span>';	
			}
			else 
                        if($value['payment_info']['customer_types'] == 0) {
				$customer = '<span class="label label-default">የግለ ድንብኘ</span>';	
			}
                        
                        
                        
                        echo	$customer ?></td>
			<td>	<?php echo $date_time ?></td>
				
			<td>	<?php echo $value['payment_info']['total_amount'] ?></td>
                           <td> <?php echo $value['payment_info']['paid_amount'] ?></td>
                          <td>  <?php  echo $value['payment_info']['due_amount']; ?></td>
                           <td> <?php 
                        if($value['payment_info']['payment_types'] == 3) {
				$paid_types = '<span class="labels">Telebirr</span>';	
			}
			else 
                        if($value['payment_info']['payment_types'] == 2) {
				$paid_types = '<span class="labels">Transfer (Mobile)</span>';	
			}
			else 
                        if($value['payment_info']['payment_types'] == 1) {
				$paid_types = '<span class="labels">Transfer</span>';	
			}
                        else 
                        if($value['payment_info']['payment_types'] == 0) {
				$paid_types = '<span class="labels">Cash</span>';	
			}
                         echo $paid_types ?></td>
				<td><?php if($value['payment_info']['payment_status'] == 2) {
				$paid_status = '<span class="label label-warning">Advance Payment</span>';	
			}
			else 
                        if($value['payment_info']['payment_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
                        else 
                        if($value['payment_info']['payment_status'] == 0) {
				$paid_status = '<span class="label label-danger">Loan</span>';	
			} echo $paid_status ?></td>
                  <?php endforeach; ?>
                                
                   <?php endif; ?>
             </tr>
              </tbody>
              <tfoot>
              <tr>
                <th>Bill no</th>
                <th>Customer Name</th>
                <th>Customer Types</th>
                <th>Date Time</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Paid status</th>
                 <th>Payment Types</th>
                <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                  
                <?php endif; ?>
              </tr> </tfoot>
             

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

<?php if(in_array('deleteOrder', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Order</h4>
      </div>

      <form role="form" action="<?php echo base_url('orders/remove') ?>" method="post" id="removeForm">
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


<script>

var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function () {
        var table = $('table.table').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

           
            "searchable": true,
          
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 6],
                    }
                },
            ],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: 100,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": base_url + 'assets/build/DataTables/languages/english.json'  
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });

</script>

<script type="text/javascript">
var manageTablea;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

  $("#MainreportNav").addClass('active');
  $("#addReportNav").addClass('active');

  // initialize the datatable 
  manageTablea = $('#manageTablea').DataTable({
    'ajax': base_url + 'reports/fetchOrdersData2',
    'order': []
  });

});

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { order_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

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

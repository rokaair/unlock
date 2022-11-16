<link href='<?= $assets ?>/plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='<?= $assets ?>/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?= $assets ?>/plugins/fullcalendar/fullcalendar.min.js'></script>

<script>
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events:"<?=base_url();?>panel/events/getAllEvents",
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      bootbox.prompt("<?=lang('enter_event_title');?>", function(title){ 
        if (title) {
          $.ajax({
           url:"<?=base_url();?>panel/events/add",
           type:"POST",
           data:{title:title, start:start, end:end},
           success:function()
           {
            calendar.fullCalendar('refetchEvents');
            toastr.success("<?=lang('event_added');?>");
           }
          })
        }
        
      });
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
       url:"<?=base_url();?>panel/events/update",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       toastr.success("<?=lang('event_updated');?>");
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
       url:"<?=base_url();?>panel/events/update",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       toastr.success("<?=lang('event_updated');?>");
      }
     });
    },

    eventClick:function(event)
    {
      bootbox.confirm({
          message: "<?=lang('event_remove_r_u_sure');?>",
          buttons: {
              confirm: {
                  label: '<?=lang('yes');?>',
                  className: 'btn-success'
              },
              cancel: {
                  label: '<?=lang('no');?>',
                  className: 'btn-danger'
              }
          },
          callback: function (result) {
              if (result) {
                var id = event.id;
                $.ajax({
                 url:"<?=base_url();?>panel/events/delete",
                 type:"POST",
                 data:{id:id},
                 success:function()
                 {
                  calendar.fullCalendar('refetchEvents');
                  toastr.success("<?=lang('event_removed');?>");
                 }
                })
              }
          }
       });
    },

   });
  });
</script>

<!-- Main content -->
    <section class="content">

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $reparation_count; ?></h3>
              <p><?= lang('reparation_title'); ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?= base_url('panel/reparation'); ?>" class="small-box-footer"><?= lang('more_info'); ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $clients_count; ?></h3>
              <p><?= lang('client_title'); ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?= base_url('panel/customers'); ?>" class="small-box-footer"><?= lang('more_info'); ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $stock_count; ?></h3>
              <p><?= lang('products'); ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer"><?= lang('more_info'); ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

          <?php if($this->Admin || $this->GP['reports-finance']): ?>
          <!-- Custom tabs (Charts with tabs)-->
          <div class="box">
            <div class="box-header">
                  <i class="ion ion-stats-bars"></i>
              <h3 class="box-title"><?= lang('revenue_chart'); ?></h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <div id="hero-area" class="graph"></div>
            </div>
          </div>
          <?php endif;?>
          <!-- /.nav-tabs-custom -->
        <div class="box box-info">
            <div class="box-body">
                <div id="calendar"></div>
            </div>
          </div>
          <?php if($this->Admin || $this->GP['dashboard-qemail']): ?>
          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>
              <h3 class="box-title"><?= lang('qemail'); ?></h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="#" method="post" id="send_email_form" >
                <div class="form-group">
                  <input type="email" class="form-control" required name="emailto" id="emailto" placeholder="<?= lang('email_to'); ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" required name="subject" id="subject" placeholder="<?= lang('email_subject'); ?>">
                </div>
                <div>
                  <textarea name="body" id="body" required class="textarea" placeholder="<?= lang('email_body'); ?>" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="submit" form="send_email_form" class="pull-right btn btn-default"><?= lang('email_send'); ?>
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>
        <?php endif; ?>
        </section>

        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
          <?php if($this->Admin || $this->GP['reports-stock']): ?>
          <!-- solid sales graph -->
          <div class="box box-solid">
            <div class="box-header">
              <i class="fa fa-th"></i>
              <h3 class="box-title"><?= lang('stock'); ?></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div id="stock-chart"></div>
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
          </div>
          <?php endif;?>
          <!-- /.box -->
 <!-- quick email widget -->
          <?php if($this->Admin || $this->GP['dashboard-qsms']): ?>
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>
              <h3 class="box-title"><?= lang('quick_sms'); ?></h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="#" id="send_quicksms" method="post">
                <div class="form-group">
                  <input type="text" required class="form-control" name="number" id="phone_number" placeholder="Number eg. (+923001234567)">
                </div>
                <div>
                  <textarea required="" name="text" id="fastsms" class="textarea" placeholder="SMS Text" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-default" form="send_quicksms"><?= lang('email_send'); ?>
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>
        <?php endif; ?>
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
    <script type="text/javascript">
    

var Script = function() {

      jQuery(function() {
        Morris.Area({
          element: 'hero-area',
          data: [
          <?php if (count($list) <= 1): ?>
              {period: '01', earnings: '0'}
          <?php else: ?>
              <?php for ($i = 1; $i <= 30; ++$i):  ?>
                 {period: "<?= $list[33].'-'.$list[32].'-'.$i ?>", earnings: "<?= $list[$i]; ?>"},
              <?php endfor; ?>
          <?php endif; ?>
                
          ],

          xkey: 'period',
          ykeys: ['earnings'],
          labels: ['<?=$this->lang->line('
            earnings_graph ');?>'
          ],
          hideHover: 'auto',
          lineWidth: 1,
          pointSize: 2,
          lineColors: ['#33df33'],
          fillOpacity: 0.5,
          smooth: true,
          xLabelAngle: 0,
          xLabels: 'day',
          xLabelFormat: function(x) {
            return x.getUTCDate();
          },
          yLabelFormat: function(y) {
                        return "<?= $currency; ?>" + y.toString();
          }
        });
      });

    }();

    Morris.Donut({
      element: 'stock-chart',
      data: [
        {label: "<?= $this->lang->line("stock_value_by_price"); ?>", value: <?php echo ($stock->stock_by_price)?$stock->stock_by_price: 0; ?>},
        {label: "<?= $this->lang->line("stock_value_by_cost"); ?>", value: <?php echo ( $stock->stock_by_cost)? $stock->stock_by_cost: 0; ?>},
        {label: "<?= $this->lang->line("profit_estimate"); ?>", value: <?php echo ($stock->stock_by_price - $stock->stock_by_cost); ?>}
      ],
      colors: ["#9CC4E4", "#3A89C9", "#F26C4F"]

     });
    
      $(function () {
        $('#send_email_form').parsley({
            errorsContainer: function(pEle) {
                var $err = pEle.$element.closest('.form-group');
                return $err;
            }
        }).on('form:submit', function(event) {
          $('#loadingmessage').show();  // show the loading message.
          emailto = jQuery('#emailto').val();
          subject = jQuery('#subject').val();
          body = jQuery('#body').val();
          jQuery.ajax({
              type: "POST",
              url: base_url + "panel/welcome/send_mail",
              data: "to="+emailto+"&subject="+subject+"&body="+body,
              cache: false,
              dataType: "json",
              success: function (data) {
                  $('#loadingmessage').hide();
                  if (data == 2) {
                    toastr.error('<?= lang('field_empty'); ?>');
                  }else if (data == 1) {
                    toastr.info('<?= lang('email_sent'); ?>');
                  }else{
                    toastr.error('<?= lang('email_not_sent'); ?>');
                  }
              }
          });
          return false;
          
        }); 
        $('#send_quicksms').parsley({
            errorsContainer: function(pEle) {
                var $err = pEle.$element.closest('.form-group');
                return $err;
            }
        }).on('form:submit', function(event) {
          dta = $('#send_quicksms').serialize();
          jQuery.ajax({
              type: "POST",
              url: base_url + "panel/reparation/send_sms",
              data: dta,
              cache: false,
              dataType: "json",
              success: function(data) {
                  if(data.status == true) toastr['success']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('sms_sent');?>');
                  else toastr['error']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('sms_not_sent');?>');
              }
          });
          return false;
        }); 
    }); 
    </script>


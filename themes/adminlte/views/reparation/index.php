<link rel="stylesheet" type="text/css" href="<?= $assets ?>plugins/datatables/ext/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= $assets ?>plugins/datatables/ext/buttons.dataTables.min.css">
<script type="text/javascript" src="<?= $assets ?>plugins/datatables/ext/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/datatables/ext/jszip.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/datatables/ext/pdfmake.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/datatables/ext/vfs_fonts.js"></script>
<script type="text/javascript" src="<?= $assets ?>plugins/datatables/ext/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
<style type="text/css">
    div.dt-buttons{
        margin-left: 10px;
    }
    .panel-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
    .select2-selection__rendered{
        text-align: left;
    }

    .select2-container--default {
        display: table!important;
        table-layout: fixed!important;
    }
    .dt-button-collection .buttons-columnVisibility:before,
    .dt-button-collection .buttons-columnVisibility.active span:before {
        display:block;
        position:absolute;
        top:1.2em;
        left:0;
        width:12px;
        height:12px;
        box-sizing:border-box;
    }

    .dt-button-collection .buttons-columnVisibility:before {
        content:' ';
        margin-top:-6px;
        margin-left:10px;
        border:1px solid black;
        border-radius:3px;
    }

    .dt-button-collection .buttons-columnVisibility.active span:before {
        content:'\2714';
        margin-top:-11px;
        margin-left:12px;
        text-align:center;
        text-shadow:1px 1px #DDD, -1px -1px #DDD, 1px -1px #DDD, -1px 1px #DDD;
    }

    .dt-button-collection .buttons-columnVisibility span {
        margin-left:20px;    
    }


    .warranty_row td:first-child {
        position: relative;
        overflow: hidden;
        width: 300px;
    }
    .warranty_row td:first-child:before {
        content: "";
        position: absolute;
        width: 30px;
        height: 30px;
        background: <?= $settings->warranty_ribbon_color; ?>;
        top: -16px;
        left: -15px;
        text-align: center;
        line-height: 90px;
        transform: rotate(49deg);
    }
</style>
<script>
    function isEmptyObject(obj) {

        // null and undefined are "empty"
        if (obj == null) return true;

        // Assume if it has a length property with a non-zero value
        // that that property is correct.
        if (obj.length > 0)    return false;
        if (obj.length === 0)  return true;

        // If it isn't an object at this point
        // it is empty, but it can't be anything *but* empty
        // Is it empty?  Depends on your application.
        if (typeof obj !== "object") return true;

        // Otherwise, does it have any properties of its own?
        // Note that this doesn't handle
        // toString and valueOf enumeration bugs in IE < 9
        for (var key in obj) {
            if (hasOwnProperty.call(obj, key)) return false;
        }

        return true;
    }
    
  
    function pad(n, width, z) {
      z = z || '0';
      n = n + '';
      return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }
    function code(x) {
        return 'CASE' + pad(x, 4);
        // body...
    }
    function client_name(x) {
        x = x.split('___');
        return '<a class="view_client" href="#view_client" data-toggle="modal" data-num="'+x[0]+'">' + x[1] + '</a>';
    }

  
     $(document).ready(function () {
        $.fn.modal.Constructor.prototype.enforceFocus = $.noop;

        
        var oTable1 = $('#dynamic-table').DataTable({
            "aaSorting": [[6, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": <?=$settings->rows_per_page;?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?=base_url(); ?>panel/reparation/getAllReparations/',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            "autoWidth" : false,
            
            "aoColumns": [
                {"mRender": code, "width": "10%"},
                {"mRender": client_name, "width": "10%"},
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                {"mRender": status, "width": "20%"},
                { "width": "20%" },
                {"mRender": update_by, "width": "20%"},
                { "width": "20%" },
                {"mRender": formatMyDecimal, "width": "20%"},
                { "width": "20%" },
            ],

            dom: 'lBfrtip',
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                  columns: ':not(:last-child)',
                },
                text: '<?= lang('excel');?>',
            }, {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
                text: '<?= lang('pdf');?>',
            }, {
                extend: 'colvis',
                collectionLayout: 'fixed two-column'
            }],
            stateSave: true,
            "stateSaveParams": function (settings, data) {
                data.search.search = "";
                $.each(data.columns, function(x,y){
                    if (x == 9 || x == 10 || x == 11 || x == 12) {
                        data.columns[x].visible = false;
                    }
                });
              },
            "stateSaveCallback": function (settings, data) {
                $.ajax({
                    "url": '<?=base_url(); ?>panel/reparation/state_save',
                    "data": {state: JSON.stringify(data)},
                    "dataType": "json",
                    "type": "POST",
                    "success": function () {},
                });
            },
            <?php if($settings->reparation_table_state !== ''): ?>
            'stateLoadCallback': function (settings) {
                var o;
                // Send an Ajax request to the server to get the data. Note that
                // this is a synchronous request since the data is expected back from the
                // function
                $.ajax ({
                    'url': '<?=base_url(); ?>panel/reparation/load_state',
                    'async': false,
                    'dataType': 'json',
                    'success': function (json) {
                        o = json;
                    }
                });
                return o;
            },
            <?php endif; ?>
            "createdRow": function( row, data, dataIndex){
                x = data[8];
                warranty = data[14];

                if (warranty !== '' || warranty !== null) {
                    if (warranty) {
                        $(row).addClass('warranty_row');
                    }
                }

                if (x == 'cancelled') {
                    $('td:first', row).attr('bgcolor', '#000');
                    $('td:first', row).attr('style', 'color:#FFF;vertical-align: inherit;');
                }else{
                     x = x.split('____');
                    $('td:first', row).attr('bgcolor', x[1]);
                    $('td:first', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;');
                    $('td:first', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;background-color:'+x[1]+';');
                    $('td:first a', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;');
                }
               
                $('td:not(:first-child)', row).attr('style', 'vertical-align: inherit;');
                $('td', row).attr('align', 'center');
            }
        });


        var oTable2 = $('#dynamic-table-completed').dataTable({
            "aaSorting": [[6, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": <?=$settings->rows_per_page;?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?=base_url(); ?>panel/reparation/getAllReparations/',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });

                aoData.push({
                    "name": "type",
                    "value": "completed"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            "autoWidth" : false,
            "aoColumns": [
                {"mRender": code, "width": "10%"},
                {"mRender": client_name, "width": "10%"},
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                {"mRender": status, "width": "20%"},
                { "width": "20%" },
                {"mRender": update_by, "width": "20%"},
                { "width": "20%" },
                {"mRender": formatMyDecimal, "width": "20%"},
                { "width": "20%" },
            ],

            dom: 'lBfrtip',
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                  columns: ':not(:last-child)',
                },
                text: '<?= lang('excel');?>',
            }, {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
                text: '<?= lang('pdf');?>',
            }, {
                extend: 'colvis',
                collectionLayout: 'fixed two-column'
            }],
            stateSave: true,
            "stateSaveParams": function (settings, data) {
                data.search.search = "";
              },
            "stateSaveCallback": function (settings, data) {
                $.ajax({
                    "url": '<?=base_url(); ?>panel/reparation/state_save',
                    "data": {state: JSON.stringify(data)},
                    "dataType": "json",
                    "type": "POST",
                    "success": function () {},
                });
            },
            <?php if($settings->reparation_table_state !== ''): ?>
            'stateLoadCallback': function (settings) {
                var o;
                // Send an Ajax request to the server to get the data. Note that
                // this is a synchronous request since the data is expected back from the
                // function
                $.ajax ({
                    'url': '<?=base_url(); ?>panel/reparation/load_state',
                    'async': false,
                    'dataType': 'json',
                    'success': function (json) {
                        o = json;
                    }
                });
                return o;
            },
            <?php endif; ?>
            "createdRow": function( row, data, dataIndex){
                x = data[8];
                warranty = data[14];
                if (warranty !== '') {
                    if (warranty !== '0') {
                        $(row).addClass('warranty_row');
                    }
                }
                if (x == 'cancelled') {
                    $('td:first', row).attr('bgcolor', '#000');
                    $('td:first', row).attr('style', 'color:#FFF;vertical-align: inherit;');
                }else{
                     x = x.split('____');
                    $('td:first', row).attr('bgcolor', x[1]);
                    $('td:first', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;background-color:'+x[1]+';');
                    $('td:first a', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;');
                }
               
                $('td:not(:first-child)', row).attr('style', 'vertical-align: inherit;');
                $('td', row).attr('align', 'center');
            }
        });


        var oTable3 = $('#dynamic-table-waiting').DataTable({
            "aaSorting": [[6, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": <?=$settings->rows_per_page;?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?=base_url(); ?>panel/reparation/getAllReparations/',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });

                aoData.push({
                    "name": "type",
                    "value": "waiting"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            "autoWidth" : false,
            
            "aoColumns": [
                {"mRender": code, "width": "10%"},
                {"mRender": client_name, "width": "10%"},
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                { "width": "20%" },
                {"mRender": status, "width": "20%"},
                { "width": "20%" },
                {"mRender": update_by, "width": "20%"},
                { "width": "20%" },
                {"mRender": formatMyDecimal, "width": "20%"},
                { "width": "20%" },
            ],

            dom: 'lBfrtip',
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                  columns: ':not(:last-child)',
                },
                text: '<?= lang('excel');?>',
            }, {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
                text: '<?= lang('pdf');?>',
            }, {
                extend: 'colvis',
                collectionLayout: 'fixed two-column'
            }],
            stateSave: true,
            "stateSaveParams": function (settings, data) {
                data.search.search = "";
              },
            "stateSaveCallback": function (settings, data) {
                $.ajax({
                    "url": '<?=base_url(); ?>panel/reparation/state_save',
                    "data": {state: JSON.stringify(data)},
                    "dataType": "json",
                    "type": "POST",
                    "success": function () {},
                });
            },
            <?php if($settings->reparation_table_state !== ''): ?>
            'stateLoadCallback': function (settings) {
                var o;
                // Send an Ajax request to the server to get the data. Note that
                // this is a synchronous request since the data is expected back from the
                // function
                $.ajax ({
                    'url': '<?=base_url(); ?>panel/reparation/load_state',
                    'async': false,
                    'dataType': 'json',
                    'success': function (json) {
                        o = json;
                    }
                });
                return o;
            },
            <?php endif; ?>
            "createdRow": function( row, data, dataIndex){
                x = data[8];
                warranty = data[14];
                console.log(warranty);
                if (warranty !== '') {
                    if (warranty !== '0') {
                        $(row).addClass('warranty_row');
                    }
                }

                if (x == 'cancelled') {
                    $('td:first', row).attr('bgcolor', '#000');
                    $('td:first', row).attr('style', 'color:#FFF;vertical-align: inherit;');
                }else{
                     x = x.split('____');
                    $('td:first', row).attr('bgcolor', x[1]);
                    $('td:first', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;');
                    $('td:first', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;background-color:'+x[1]+';');
                    $('td:first a', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;');
                }
               
                $('td:not(:first-child)', row).attr('style', 'vertical-align: inherit;');
                $('td', row).attr('align', 'center');
            }
        });


        <?php if($this->input->get('q')): $q = $this->input->get('q'); ?>
            // oTable1.fnFilter( '<?=$q;?>' ).draw();
            oTable1.search( '<?=$q;?>'  ).draw();
            oTable3.search( '<?=$q;?>'  ).draw();
            oTable2.fnFilter( '<?=$q;?>' ).draw();
        <?php endif;?>
    });


    jQuery(document).on("click", "#print_reparation", function() {
        var num = jQuery(this).data("num");
        var tipo = jQuery(this).data("type");
        // var half = jQuery('#half_a4').prop('checked');
        var full = jQuery('#full_a4').prop('checked') ? 1 : 0;
        var two_copies = jQuery('#two_copies').prop('checked') ? 1 : 0;
        toastr['success']("<?= $this->lang->line('reparation_is_printing');?>");
        var thePopup = window.open( base_url + "panel/reparation/invoice/" + encodeURI(num) + "/" + tipo+ "/" + full+ "/" + two_copies, '_blank', "width=890, height=700");
    });

</script>


<!-- Main content -->
    <section class="content">
        <?php if($this->Admin || $GP['repair-add']): ?>
                <button href="#reparationmodal" class="add_reparation btn btn-primary">
                    <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('reparation_title'); ?>
                </button>
            <?php endif; ?>
            <br>
            <br>
        <div class="row">

            <div class="col-md-12">
              <!-- Custom Tabs (Pulled to the right) -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                  <li class=""><a href="#CompletedRepairs" data-toggle="tab" aria-expanded="false"><?=lang('completed_repairs');?></a></li>
                  <li ><a href="#WaitingRepairs" data-toggle="tab" aria-expanded="false"><?=lang('waiting_repairs');?></a></li>
                  <li class="active"><a href="#PendingRepairs" data-toggle="tab" aria-expanded="false"><?=lang('pending_repairs');?></a></li>
                  <li class="pull-left header"><i class="fa fa-th"></i> <?=lang('repair_table');?></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="PendingRepairs">
                    <div class="table-responsive">
                        
                        <table class="display compact table table-bordered table-striped" id="dynamic-table" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </thead>
                    
                            <tfoot>
                                <tr>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="CompletedRepairs">
                    <div class="table-responsive">
                        <table class="display compact table table-bordered table-striped" id="dynamic-table-completed" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </thead>
                    
                            <tfoot>
                                <tr>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                  </div>

                   <div class="tab-pane" id="WaitingRepairs">
                    <div class="table-responsive">
                        <table class="display compact table table-bordered table-striped" id="dynamic-table-waiting" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </thead>
                    
                            <tfoot>
                                <tr>
                                    <th><?= lang('reparation_code'); ?></th>
                                    <th><?= lang('reparation_name'); ?></th>
                                    <th><?= lang('reparation_imei'); ?></th>
                                    <th><?= lang('client_telephone'); ?></th>
                                    <th><?= lang('reparation_defect'); ?></th>
                                    <th><?= lang('reparation_model'); ?></th>
                                    <th><?= lang('reparation_opened_at'); ?></th>
                                    <th><?= lang('date_closing'); ?></th>
                                    <th><?= lang('reparation_status'); ?></th>
                                    <th><?= lang('added_by'); ?></th>
                                    <th><?= lang('last_modified_by'); ?></th>
                                    <th><?= lang('reparation_attachements_count'); ?></th>
                                    <th><?= lang('grand_total'); ?></th>
                                    <th><?= lang('actions'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- nav-tabs-custom -->
            </div>
        </div>
    </section>

<script type="text/javascript">
jQuery(document).on("click", ".view", function () {
    var num = jQuery(this).data("num");
    find_reparation(num);
});

if (getUrlVars()["id"]) {
    find_reparation(getUrlVars()["id"]);
    $('#view_reparation').modal('show');
}
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars;
}

</script>
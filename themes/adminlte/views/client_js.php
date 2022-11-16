<style type="text/css">
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
    #map {
        height: 100%;
    }
    #autocomplete{
        z-index: 9999;   
    }
    .pac-container {
        background-color: #FFF;
        z-index: 9999;
        position: fixed;
        display: inline-block;
        float: left;
    }

    
</style>
<script type="text/javascript">
     jQuery(document).on("click", ".view_client", function () {
        var num = jQuery(this).data("num");
        find_client(num);
    });

function update_by(x) {
    if (x=='') {
        return '<?=lang('not_modified');?>';
    }
    return x;
}

function status(x) {
    if (x == 'cancelled') {
        return '<div class="text-center"><span class="row_status label" style="background-color:#000;">Cancelled</span></div>';
    }
    x = x.split('____');
    return '<div class="text-center"><span class="row_status label" style="background-color:'+x[1]+'; color:'+x[2]+';">'+x[0]+'</span></div>';
}

function alphanumeric_unique() {
        return Math.random().toString(36).split('').filter( function(value, index, self) { 
            return self.indexOf(value) === index;
        }).join('').substr(2,8);
    }    
jQuery(document).on("click", "#sendsmsfast", function() {
        var txt = jQuery('#fastsms').val();
        var number = jQuery('#rv_phone_number').html();
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/reparation/send_sms",
            data: "text=" + txt + "&number=" + number + "&token=<?=$_SESSION['token'];?>",
            cache: false,
            dataType: "json",
            success: function(data) {
                if(data.status == true) toastr['success']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('sms_sent');?>');
                else toastr['error']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('sms_not_sent');?>');
            }
        });
    });
    jQuery(document).on("click", "#delete_reparation", function () {
        var num = jQuery(this).data("num");
        bootbox.prompt({
            title: "Are you sure!",
            inputType: 'checkbox',
            inputOptions: [
                {
                    text: '<?= lang('want_to_add_to_stock-delete'); ?>',
                    value: '1',
                },
            ],
            callback: function (result) {
                if (result) {
                    var add_to_stock = false;
                    if (result.length == 1) {
                        add_to_stock = true;
                    }
                    jQuery.ajax({
                        type: "POST",
                        url: base_url + "panel/reparation/delete",
                        data: "id=" + encodeURI(num) + "&add_to_stock=" + encodeURI(add_to_stock),
                        cache: false,
                        dataType: "json",
                        success: function (data) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "progressBar": true,
                                "positionClass": "toast-bottom-right",
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr['success']("<?= lang('deleted'); ?>: ", "<?= lang('reparation_deleted'); ?>");
                            $('#dynamic-table').DataTable().ajax.reload();
                        }
                    });
                }
            }
        });
    });
</script>

<!-- ============= MODAL VISUALIZZA ORDINI/RIPARAZIONI ============= -->
<div class="col-md-12 modal fade" id="view_reparation" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-ku">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><div id="titoloOE"></div></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-mobile"></i> <?= lang('reparation_imei'); ?> </span><span id="rv_imei"></span></p>
                        </div>
                        
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> <?= lang('client_title'); ?></span><span id="rv_client"></span></p>
                        </div>
                      
                        <div class="col-md-12 col-lg-4 bio-row stato">
                            <p><span class="bold"><i class="fa fa-signal"></i> <?= lang('reparation_condition'); ?> </span><span class="label" id="rv_condition"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-calendar"></i> <?= lang('reparation_opened_at'); ?> </span><span id="rv_created_at"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row  closing_date_div">
                            <p><span class="bold"><i class="fa fa-calendar"></i> <?= lang('date_closing'); ?> </span><span id="rv_date_closing"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row expected_close_date_div">
                            <p><span class="bold"><i class="fa fa-calendar"></i> <small><?= lang('expected_close_date'); ?> </small></span><span id="rv_expected_close_date"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fas fa-link"></i> <?= lang('assigned_to'); ?> </span><span id="rv_assigned_to"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fas fa-link"></i> <?= lang('reparation_defect'); ?> </span><span id="rv_defect"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-folder-open"></i> <?= lang('reparation_category'); ?> </span><span id="rv_category"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-tag"></i> <?= lang('reparation_model'); ?> </span><span id="rv_model"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fas fa-money-bill-alt"></i><?= lang('reparation_advance'); ?></span><span id="rv_advance"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fas fa-money-bill-alt"></i><?= lang('reparation_service_charges'); ?></span><span id="rv_service_charges"></span></p>
                        </div>
                        
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-phone"></i> <?= lang('client_telephone'); ?> </span><span id="rv_phone_number"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-eye"></i> <?= lang('reparation_code'); ?> </span><span id="rv_rep_code"></span></p>
                        </div>

                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-eye"></i> <?= lang('taxrate_title'); ?> </span><span id="rv_taxrate"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row nofloat">
                            <p><span class="bold"><i class="fas fa-money-bill-alt"></i><?= lang('reparation_price'); ?> </span><span id="rv_price"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row nofloat">
                            <p><span class="bold"><i class="fas fa-cloud"></i><?= lang('icloud'); ?> </span><span id="rv_icloud"></span></p>
                        </div>
                         <div class="col-md-12 col-lg-4 bio-row nofloat">
                            <p><span class="bold"><i class="fas fa-cloud"></i><?= lang('icloud_password'); ?> </span><span id="rv_icloud_password"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row nofloat">
                            <p><span class="bold"><i class="fas fa-key"></i><?= lang('passcode'); ?> </span><span id="rv_passcode"></span></p>
                        </div>

                        <div class="col-md-12 col-lg-4 bio-row nofloat">
                            <p><span class="bold"><i class="fas fa-key"></i><?= lang('warranty'); ?> </span><span id="rv_warranty"></span></p>
                        </div>
                        <?php 
                        $custom_fields = explode(',', $settings->custom_fields);
                        foreach($custom_fields as $line){
                            if (!empty($line)) {
                        ?>
                            <div class="col-md-12 col-lg-4 bio-row">
                                <p><span class="bold"><i class="fa fa-info-circle"></i> <?= $line; ?> </span><span class="show_custom" id="v<?= bin2hex($line); ?>"></span></p>
                            </div>

                        <?php }} ?>
                        <div class="col-md-12 control-group table-group">
                            <label class="table-label" for="combo"><?= lang("defective_items"); ?></label>
                            <div class="controls table-controls">
                                <table class="table items table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <tr>
                                        <th class="col-md-5 col-sm-5 col-xs-5"><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
                                        <th class="col-md-2 col-sm-2 col-xs-2"><?= lang("quantity"); ?></th>
                                        <th class="col-md-3 col-sm-3 col-xs-3"><?= lang("unit_price"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody id="view_repair_items"></tbody>
                                </table>
                                <table class="table items table-striped table-bordered table-condensed table-hover">
                                    <tfoot>
                                        <tr>
                                         <th colspan="2" class="warning"></th>
                                         <th colspan="1" class="warning"><span class="pull-right"><?= lang('tax');?></span></th>
                                            <th colspan="1" class="success"><span id="rv_tax_span">0.00</span></th>
                                            <th colspan="1" class="warning"><span class="pull-right"><?=lang('subtotal')?></span></th>
                                            <th colspan="1" class="info"><span id="rv_price_span">0.00</span></th>
                                           
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="1" class="warning"><span class="pull-right"><?=lang('reparation_service_charges')?></span></th>
                                                <th colspan="1" class="success"><span id="rv_sc_span">0.00</span></th>
                                            <th class="warning"><span class="pull-right"><?= lang('reparation_advance'); ?></span></th>
                                            <th class="success"><span id="rv_advance_span">0.00</span></th>
                                            <th class="warning"><span class="pull-right"><?= lang('grand_total'); ?></span></th>
                                            <th class="success"><span id="rv_gtotal">0.00</span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="col-md-6 bio-row textareacom">
                                    <div class="form-group comment">
                                        <?= lang('reparation_comment', 'rv_comment'); ?>
                                        <textarea class="form-control" id="rv_comment" rows="6" disabled=""></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 bio-row textareacom">
                                    <div class="form-group comment">
                                        <?= lang('reparation_diagnostics', 'rv_diagnostics'); ?>
                                        <textarea class="form-control" id="rv_diagnostics" rows="6" disabled=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6 bio-row fastsms">
                                    <div class="form-group rv_comment">
                                        <?=lang('quick_sms', 'fastsms');?>
                                        <textarea class="form-control" id="fastsms" rows="6" placeholder="Instantly send a text message to the client by entering your text here"></textarea>
                                        <button type="button" id="sendsmsfast"><i class="fa fa-check"></i> <?=lang('send');?></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="footerOR" class="modal-footer">

            </div>
        </div>
    </div>
</div>

<!-- ============= MODAL MODIFICA supplierI ============= -->
<div class="modal fade" id="reparationmodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-ku">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titReparation"></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                    <div class="row">
                        <form id="rpair_form" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="attachment_data" id="attachment_data" value>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <?=lang('date_opening', 'date_opening');?>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                     <input required="" id="date_opening" name="date_opening" type="text" class="validate form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <?=lang('date_closing', 'date_closing');?>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                     <input id="date_closing" name="date_closing" type="text" class="validate form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $("#date_opening, #date_closing").datetimepicker({
                                            format: 'DD.MM.YYYY HH:mm:ss',
                                            locale: '<?=lang('bootstrap_datetimepicker');?>',
                                        });
                                        $('#date_opening').val(Date());
                                    </script>
                                
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <?=lang('reparation_imei', 'imei');?>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fas fa-mobile"></i>
                                                </div>
                                                 <input required="" id="imei" name="imei" type="text" class="validate form-control imei_typeahead">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('client_title', 'client_name');?>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa  fa-user"></i>
                                            </div>
                                            <select required id="client_name" name="client_name" data-num="1" class="form-control m-bot15" style="width: 100%">
                                                <option></option>
                                                <?php 
                                                    foreach ($clients as $client) :
                                                    echo '<option value="'.$client->id.'">'.$client->name.' '.$client->company.'</option>';
                                                    endforeach; 
                                                ?>
                                            </select>
                                            <a id="add_client" class="add_c btn input-group-addon">
                                                <i class="fa fa-user-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('reparation_category', 'category_select');?>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa  fa-folder"></i>
                                            </div>
                                            <input id="category" name="category" type="text" class="validate form-control categories_typeahead">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <?=lang('assigned_to', 'assigned_to');?>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-folder"></i>
                                                </div>
                                                <select required id="assigned_to" name="assigned_to" class="form-control m-bot15" style="width: 100%">
                                                    <?php
                                                        foreach($users as $user){
                                                            echo '<option value="'.$user->id.'">'.$user->first_name . ' ' . $user->last_name .'</option>';
                                                        } 
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <?=lang('model_manufacturer', 'reparation_manufacturer');?>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-folder"></i>
                                                </div>
                                                <input class="form-control manufacturer_name_typeahead" id="reparation_manufacturer" name="manufacturer" required="" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <?=lang('reparation_model', 'reparation_model');?>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-folder"></i>
                                                </div>
                                                <input class="form-control model_name_typeahead" id="reparation_model" name="model" required="" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <?=lang('reparation_defect', 'defect');?>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fas fa-link"></i>
                                                </div>
                                                 <input required id="defect" name="defect" type="text" class="validate form-control defect_typeahead">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('reparation_advance', 'advance');?>
                                        <div class="input-group">
                                             <div class="input-group-addon">
                                                <i class="fas fa-money-bill-alt"></i>
                                            </div>
                                            <input required step="any"  id="advance" name="advance" min='0' value="0" type="number" class="validate form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('reparation_service_charges', 'service_charges');?>
                                        <div class="input-group">
                                             <div class="input-group-addon">
                                                <i class="fas fa-money-bill-alt"></i>
                                            </div>
                                            <input required id="service_charges" name="service_charges" min="0" type="number" value="0" step="any" class="validate form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <?=lang('expected_close_date', 'expected_close_date');?>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                                 <input id="expected_close_date" name="expected_close_date" type="text" class="validate form-control date">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('icloud', 'icloud');?>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fas fa-cloud"></i>
                                            </div>
                                            <input id="icloud" name="icloud" type="text" class="validate form-control">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('icloud_password', 'icloud_password');?>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fas fa-cloud"></i>
                                            </div>
                                            <input id="icloud_password" name="icloud_password" type="text" class="validate form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('passcode', 'passcode');?>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fas fa-key"></i>
                                            </div>
                                            <input id="passcode" name="passcode" type="text" class="validate form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <?=lang('warranty', 'warranty');?>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fas fa-file"></i>
                                            </div>
                                            <?php 
                                                $warranties = array(
                                                    '0' => lang('no_warranty'),
                                                    '1M' => lang('1M'),
                                                    '3M' => lang('3M'),
                                                    '6M' => lang('6M'),
                                                ); 

                                                echo form_dropdown('warranty', $warranties, '', 'class="form-control" style="width:100%;" id="warranty"');
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12 row">
                                    <div class="checkbox">
                                        <label>
                                            <input name="sim" id="sim" value="1" type="checkbox">
                                            <?=lang('sim');?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 row">
                                    <div class="checkbox">
                                        <label>
                                            <input name="card" id="card" value="1" type="checkbox">
                                            <?=lang('card');?>
                                        </label>
                                    </div>
                                </div>

                                <?php 
                                    $custom = explode(',', $settings->custom_fields);
                                    foreach($custom as $line){
                                        if (!empty($line)) {
                                ?>
                                
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?= $line; ?></label>
                                        <input id="custom_<?= bin2hex($line); ?>" name="custom_<?= bin2hex($line); ?>" type="text" class="custom validate form-control">
                                    </div>
                                </div>
                                <?php } }?>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group combo">
                                        <?= lang("add_item", 'add_item'); ?>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                    <i class="fas fa-link"></i>
                                            </div>
                                        <?php echo form_input('add_item', '', 'class="form-control ttip" id="add_item" data-placement="top" data-trigger="focus" data-bv-notEmpty-message="' . ('please_add_items_below') . '" placeholder="' . lang("add_item") . '"'); ?>
                                             
                                        </div>
                                    </div>
                                    <div class="control-group table-group">
                                        <label class="table-label" for="combo"><?= lang("defective_items"); ?></label>
                                        <div class="controls table-controls">
                                            <table id="prTable"
                                                   class="table items table-striped table-bordered table-condensed table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-5 col-sm-5 col-xs-5"><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
                                                    <th class="col-md-2 col-sm-2 col-xs-2"><?= lang("quantity"); ?></th>
                                                    <th class="col-md-3 col-sm-3 col-xs-3"><?= lang("unit_price"); ?></th>
                                                    <th class="col-md-1 col-sm-1 col-xs-1 text-center">
                                                        <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <td colspan="4"><?= lang('nothing_to_display'); ?></td>
                                                </tbody>
                                            </table>
                                            <table class="table items table-striped table-bordered table-condensed table-hover">
                                                <tfoot>
                                                    <tr>
                                                     <th colspan="2" class="warning"></th>
                                                     <th colspan="1" class="warning"></th>
                                                        <th colspan="1" class="warning"></th>
                                                        <th colspan="1" class="warning"><span class="pull-right"><?=lang('subtotal')?></span></th>
                                                        <th colspan="1" class="info"><span id="price_span">0.00</span></th>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <th colspan="5" class="warning"><span class="pull-right"><?= lang('total'); ?></span></th>
                                                        <th colspan="1" class="success"><span id="totalprice_span">0.00</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="1" class="warning"><span class="pull-right"><?=lang('reparation_service_charges')?></span></th>
                                                            <th colspan="1" class="success"><span id="sc_span">0.00</span></th>
                                                        <th class="warning"><span class="pull-right"><?= lang('reparation_advance'); ?></span></th>
                                                        <th class="success"><span id="advance_span">0.00</span></th>
                                                        <th class="warning"><span class="pull-right"><?= lang('grand_total'); ?></span></th>
                                                        <th class="success"><span id="gtotal">0.00</span></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                        <div style="clear: both;"></div>
                        <div class="col-lg-12">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?= lang('reparation_comment', 'comment'); ?> <i id="add_timestamp" class="fa fa-calendar"></i>
                                    <textarea class="form-control" id="comment" name="comment" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?= lang('reparation_diagnostics', 'diagnostics'); ?> <i id="add_timestamp" class="fa fa-calendar"></i>
                                    <textarea class="form-control" id="diagnostics" name="diagnostics" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                    <button data-dismiss="modal" class="pull-left btn btn-default" type="button">
                        <i class="fa fa-reply"></i> 
                        <?= lang('go_back'); ?>
                    </button>
                    <div class="col-lg-2"> 
                        <select style="width: 100%;" id="status_edit" class="form-control">
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= $status->id; ?>"><?= $status->label; ?></option>
                            <?php endforeach; ?>
                            <option value="0"><?= lang('cancelled'); ?></option>
                        </select>
                    </div>
                    <div id="footerReparation">
                      
                    </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- ============= MODAL Upload Manager ============= -->
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="upload_modal_title"></h4>
            </div>
            <div class="modal-body">
                <label for="upload_manager"><?=lang('Attachments');?></label>
                <div class="file-loading">
                    <input id="upload_manager" name="upload_manager[]" type="file" multiple>
                </div>
            </div>
        </div>    
    </div>
</div>

<script type="text/javascript">
     var count = 1;
        (function ($) {
        "use strict";
        $.fn.fileinputLocales['mylang'] = <?= json_encode(lang('upload_manager')); ?>;
    })(window.jQuery);
    jQuery(document).on("click", "#upload_modal_btn", function() {
        mode = $(this).attr('data-mode');
        num = $(this).attr('data-num');
        if (mode == 'edit') {
            $.ajax({
                type: 'POST',
                url: "<?=base_url();?>panel/reparation/getAttachments",
                dataType: "json",
                data:({"id":num}),
                success: function (data) {
                    $('#upload_manager').fileinput('destroy');
                    $("#upload_manager").fileinput({
                        initialPreviewAsData: true, 
                        initialPreview: data.urls,
                        initialPreviewConfig: data.previews,
                        deleteUrl: "<?=base_url();?>panel/reparation/delete_attachment",
                        maxFileSize: 999999,
                        uploadExtraData: {id:num},
                        uploadUrl: "<?=base_url();?>panel/reparation/upload_attachments",
                        uploadAsync: false,
                        overwriteInitial: false,
                        showPreview: true,
                        language: 'mylang',
                    }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
                        $('#dynamic-table').DataTable().ajax.reload();
                    });
                }
            });
        }
        jQuery('#upload_modal').modal("show");
    });

    jQuery(".add_reparation").on("click", function (e) {
        $('#rpair_form').find("input[type=text], textarea").val("");
        $('#rpair_form').find("select").val("").trigger('change');
        $('#rpair_form').parsley().reset();
        items = {};
        $('#prTable tbody').empty();
        $('#prTable tbody').html('<tr><td colspan="4"><?= lang('nothing_to_display') ?></td></tr>');
        localStorage.removeItem('slitems');
        loadRItems();
        code = jQuery.now();
        // Upload Manager Start
        $('#attachment_data').val('');
        $('#upload_manager').fileinput('destroy');
        $("#upload_manager").fileinput({
            uploadUrl: "<?=base_url();?>panel/reparation/upload_attachments",
            uploadAsync: false,
            language: 'mylang',
        }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
            response = data.response;
            data = JSON.parse(response.data);
            $('#attachment_data').val(data.join(','))
        });
        // Upload Manager End
        $('#reparationmodal').modal('show');

        jQuery('#titReparation').html("<?= lang('add'); ?> <?= lang('reparation_title'); ?>");

        footer = '<div class=\"col-sm-3 \" style=\"padding-left: 0;\"><input id=\"code\" type=\"text\" class=\"validate form-control\" value=\"' + code + '\" placeholder=\"<?= lang('reparation_code');?>\"></div>';
        footer += '<button id="upload_modal_btn" class="btn btn-success pull-left" data-mode="add"><i class="fa fa-cloud"></i> <?=lang('upload_file');?></button>';
        footer += '<span class="pull-left label label-info label-xs" style="padding:6px 12px;width:auto;" ><?=lang('reparation_sms', 'sms');?><input type="checkbox" value="1" name="sms" id="repair_sms"></span><span  style="padding:6px 12px;width:auto;" class="pull-left label label-warning label-xs"><label for="email"><?=lang('send_email_check');?></label><input type="checkbox" value="1" name="email" id="repair_email"></span><button id="repair_submit"  role="button" form="rpair_form"  class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> <?= lang("add"); ?> <?= lang("reparation_title"); ?></button>';
        jQuery('#footerReparation').html(footer);
    });
    jQuery(document).on("click", "#modify_reparation", function () {
        $('#rpair_form').find("input[type=text], textarea").val("");
        $('#rpair_form').find("select").val("").trigger('change');
        var num = $(this).data('num');
        jQuery('#titReparation').html("<?= lang('edit'); ?> <?= lang('reparation_title'); ?>");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/reparation/getReparationByID",
            data: "id=" + encodeURI(num) + "&token=<?=$_SESSION['token'];?>",
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data.status < 1) {
                    toastr['error']("<?=lang('cancelled_reparation_not_editable');?>");
                    $('#reparationmodal').modal('hide');
                    return;
                }
               
                jQuery('#titReparation').html("<?= lang('edit'); ?> <?= lang('reparation_title'); ?>" + data.model_name);
                jQuery('#client_name').val(parseInt(data.client_id)).trigger("change");
                jQuery('#warranty').val(data.warranty).trigger("change");
                jQuery('#category').val(data.category);
                jQuery('#reparation_model').val(data.model_name);
                jQuery('#reparation_manufacturer').val(data.manufacturer);
                jQuery('#defect').val(data.defect);
                jQuery('#advance').val(data.advance);
                jQuery('#service_charges').val(data.service_charges);
                jQuery('#potax2').val(parseInt(data.tax_id)).trigger("change");
                jQuery('#assigned_to').val(parseInt(data.assigned_to)).trigger("change");
                jQuery('#comment').val(data.comment);
                jQuery('#imei').val(data.imei);
                jQuery('#diagnostics').val(data.diagnostics);
                jQuery('#expected_close_date').val(data.expected_close_date);
                jQuery('#date_opening').val(data.date_opening);
                jQuery('#date_closing').val(data.date_closing);
                jQuery('#icloud').val(data.icloud);
                jQuery('#icloud_password').val(data.icloud_password);
                jQuery('#passcode').val(data.passcode);
                jQuery('#sim').prop('checked', (data.sim == 1? true : false)).iCheck('update');
                jQuery('#card').prop('checked', (data.card == 1? true : false)).iCheck('update');
            


                var ci = data.items;
                items = {};
                $('#prTable tbody').empty();
                $('#prTable tbody').html('<tr><td colspan="4"><?= lang('nothing_to_display') ?></td></tr>');
                localStorage.removeItem('slitems');
                loadRItems();
                $.each(ci, function() { add_product_item(this); });
          
                var IS_JSON = true;
                try {
                    var json = $.parseJSON(data.custom_field);
                } catch(err) {
                    IS_JSON = false;
                }                

                if(IS_JSON)  {
                    $.each(json, function(id_field, val_field) {
                        jQuery('#custom_'+id_field).val(val_field);
                    });
                }
                footer = '<div class=\"col-sm-3 \" style=\"padding-left: 0;\"><input id=\"code\" type=\"text\" class=\"validate form-control\" value=\"'+data.code+'\" placeholder=\"<?= lang('reparation_code');?>\"></div>';
                footer += '<button id="upload_modal_btn" class="btn btn-success pull-left" data-mode="edit" data-num="' + encodeURI(num) + '"><i class="fa fa-cloud"></i> <?=lang('view_attached');?></button>';
                
                footer += '<span class="pull-left label label-info label-xs" style="width:auto; padding:6px 12px;" ><?=lang('reparation_sms', 'sms');?><input type="checkbox"  value="1" name="sms" id="repair_sms"></span><span  style="width:auto; padding:6px 12px;" class="pull-left label label-warning label-xs"><label for="email"><?=lang('send_email_check');?></label><input type="checkbox"  value="1" name="email" id="repair_email"></span><button id="repair_submit" class="btn btn-success" role="button" form="rpair_form"   data-mode="modify" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> <?=lang('save_reparation');?></button>';
                jQuery('#footerReparation').html(footer);
                jQuery('#status_edit').val(data.status).trigger('change');
                if (parseInt(data.sms) === 1) { $('#repair_sms').prop('checked', true); }
                if (parseInt(data.email) === 1) { $('#repair_email').prop('checked', true); }
            }
        });
    });
    $("#add_item").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('panel/inventory/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        model_id: $("#model").val(),
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            // source: '<?= site_url('panel/inventory/suggestions'); ?>',
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_product_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');

                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    if (ui.item.type != 'service') {
                        if (ui.item.total_qty > 0) {
                            if (localStorage.getItem('prods')) {
                                slitems = JSON.parse(localStorage.getItem('prods'));
                                item_id = ui.item.id;
                                if (slitems[item_id]) {
                                    if (slitems[item_id].available_now != 0) {
                                        var row = add_product_item(ui.item);
                                        if (row)
                                            $(this).val('');
                                    }else{
                                        alert(ui.item.label + "<?= lang('not_in_stock');?>");
                                    }
                                }else{
                                    var row = add_product_item(ui.item);
                                    if (row)
                                        $(this).val(''); 
                                }
                            }else{
                                    var row = add_product_item(ui.item);
                                    if (row)
                                        $(this).val(''); 
                            }
                        }else{
                            alert(ui.item.label + "<?= lang('not_in_stock');?>");
                        }
                    }else{
                        var row = add_product_item(ui.item);
                        if (row)
                            $(this).val(''); 
                    }

                    
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= ('no_product_found') ?>');
                }
            }
        });
        // var items = JSON.parse(localStorage.getItem('slitems'));
        $( "#add_item" ).autocomplete( "option", "appendTo", ".combo" );
    $(document).on('click', '.del', function () {
        var id = $(this).attr('id');
        $(this).closest('#row_' + id).remove();
        delete items[id];
        if(items.hasOwnProperty(id)) { } else {
            localStorage.setItem('slitems', JSON.stringify(items));
            loadRItems();
            return;
        }
        calculate_price();
    });
  
    if (localStorage.getItem('slitems')) {
        loadRItems();
    }
        function calculate_price() {
            var rows = $('#prTable').children('tbody').children('tr');
            var pp = 0;
            $.each(rows, function () {
                pp += parseFloat(parseFloat($(this).find('.rprice').val())*parseFloat($(this).find('.rquantity').val()));
            });
            var service_charges = $('#service_charges').val() ? parseFloat($('#service_charges').val()) : 0;
            $('#potax2').val();
            $('#price_span').html(parseFloat(pp ? pp : 0, 4));
            var potax2 = $('#potax2').val();
            total = $('#totalprice_span').html();
            total = total ? parseFloat(total) : 0;
            total += service_charges;
            invoice_tax = 0;
            // $.each(tax_rates, function () {
            //     if (this.id == potax2) {
            //         if (this.type == 2) {
            //             invoice_tax = parseFloat(this.rate);
            //         }
            //         if (this.type == 1) {
            //             invoice_tax = parseFloat((((total) * this.rate) / 100), 4);
            //         }
            //     }
            // });

            $('#totalprice_span').html(parseFloat((parseFloat(pp)), 4));
            $('#sc_span').html(formatDecimal(service_charges));
            $('#tax_span').html(parseFloat(invoice_tax ? invoice_tax : 0));
            advance = parseFloat($('#advance').val());
            $('#advance_span').html(formatDecimal(advance?advance:0));
            gtotal = (total + invoice_tax) - advance; 
            $('#gtotal').html(formatDecimal(gtotal));
            return true;
        }
        var invoice_tax = null;
        var total = null;
        $('#potax2').on('change', function() {
            var potax2 = $('#potax2').val();
            var service_charges = $('#service_charges').val() ? parseFloat($('#service_charges').val()) : 0;
            total = $('#totalprice_span').html();
            total = total ? parseFloat(total) : 0;
            total += service_charges;

            // $.each(tax_rates, function () {
            //     if (this.id == potax2) {
            //         if (this.type == 2) {
            //             invoice_tax = parseFloat(this.rate);
            //         }
            //         if (this.type == 1) {
            //             invoice_tax = parseFloat((((total) * this.rate) / 100), 4);
            //         }
            //     }
            // });
            advance = parseFloat($('#advance').val());
            $('#tax_span').html(formatDecimal(invoice_tax));
            $('#gtotal').html(formatDecimal((invoice_tax + total) - advance));

        });

        $(document).on('change', '#service_charges, #advance', function () {
            calculate_price();
        });
         $(document).on('keyup', '#service_charges,  #advance', function () {
            calculate_price();
        });
        function loadRItems() {
            if (localStorage.getItem('slitems')) {
                items = JSON.parse(localStorage.getItem('slitems'));
                var pp = 0;
                $("#prTable tbody").empty();
                $.each(items, function () {
                    var row_no = this.id;
                    var item_id = this.id;
                    var newTr = $('<tr id="row_' + row_no + '" class="item_' + this.id + '" data-item-id="' + row_no + '"></tr>');
                    tr_html = '<td><input name="item_id[]" id="item_id" type="hidden" value="' + this.id + '"><input name="item_name[]" type="hidden" value="' + this.name + '"><input name="item_code[]" type="hidden" value="' + this.code + '"><span id="name_' + row_no + '">' + this.name + ' (' + this.code + ')</span></td>';
                    tr_html += '<td>'+formatDecimal(this.qty)+'<input class="form-control text-center rquantity" name="item_quantity[]" type="hidden" value="' + formatDecimal(this.qty) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                    tr_html += '<td>'+formatDecimal(this.price)+'<input class="form-control text-center rprice" name="item_price[]" type="hidden" value="' + formatDecimal(this.price) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="item_price_' + row_no + '" onClick="this.select();"></td>';
                    tr_html += '<td class="text-center"><i class="fa fa-times tip del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                    newTr.html(tr_html);
                    newTr.prependTo("#prTable");
                    pp += formatDecimal(parseFloat(this.price)*parseFloat(this.qty));
                    $('.item_' + item_id).addClass('warning');
                });
                $('#price_span').html(pp);
                var service_charges = $('#service_charges').val();
                var total_ = parseFloat(pp);
                $('#totalprice_span').html(total_);
                // var potax2 = $('#potax2').val();
                // $.each(tax_rates, function () {
                //     if (this.id == potax2) {
                //         if (this.type == 2) {
                //             invoice_tax = formatDecimal(this.rate);
                //         }
                //         if (this.type == 1) {
                //             invoice_tax = formatDecimal((((total_) * this.rate) / 100), 4);
                //         }
                //     }
                // });
                $('#sc_span').html(service_charges?service_charges:0);
                $('#tax_span').html(invoice_tax?invoice_tax:0);
                advance = $('#advance').val();
                $('#advance_span').html(advance?advance:0);
                $('#gtotal').html((invoice_tax?invoice_tax:0 + (total_?total_:0) + parseFloat(service_charges?service_charges:0)) - parseFloat(advance));
               
            }else{
                var service_charges = ($('#service_charges').val()) ? $('#service_charges').val() : '0';
                advance = $('#advance').val();
                $('#tax_span').html(0.00);
                $('#price_span').html(service_charges?service_charges:0);
                // $('#totalprice_span').html(service_charges?service_charges:0);
                $('#gtotal').html(formatDecimal(service_charges?service_charges:0 - parseFloat(advance?advance:0)));
            }
        }
    items = {};
    function add_product_item(item) {
            if (item == null) {
                return false;
            }
            item_id = item.id;
            if (items[item_id]) {
                items[item_id].qty = (parseFloat(items[item_id].qty) + 1).toFixed(2);
                if (item.type != 'service') {
                    items[item_id].available_now = (parseFloat(items[item_id].available_now) - 1).toFixed(2);
                }
            } else {
                items[item_id] = item;
                if (item.type != 'service') {
                    items[item_id].available_now -= 1;
                }
                
            }

            localStorage.setItem('slitems', JSON.stringify(items));

            loadRItems();
            return true;
        }
    $('select').select2({placeholder: "<?=lang('select_placeholder');?>"});
    
     $(function () {
      $('#rpair_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
      }).on('form:submit', function(event) {

        var mode = jQuery('#repair_submit').data("mode");
        var id = jQuery('#repair_submit').data("num");
        var code = jQuery('#code').val();
        var status_code = jQuery('#status_edit').val();
        var url = "";
        var dataString = new FormData($('#rpair_form')[0]);
        if ($('#category_select').val() == 'other') {
            $('#category_select').attr('required', false);
            $('#category_input').attr('required', true);
        }
        dataString.append('code',code);
        dataString.append('status',status_code);
        var sms = $('#repair_sms').prop('checked');
        var email = $('#repair_email').prop('checked');
        dataString.append('sms', sms);
        dataString.append('email', email);

        if (mode == "add") {
            url = base_url + "panel/reparation/add";
            $.ajax({
                url: url,
                type: "POST",
                data:  dataString,
                contentType:false,
                cache: false,
                processData:false,
                success: function (result) {
                    toastr['success']("<?= lang('add'); ?>", "<?= lang('reparation_title'); ?> " + name + " " + " <?= lang('added'); ?>");
                    // sms_result = result.sms_result;
                    // if (sms_result.sms_sent !== 'true' && sms_result.sms_sent !== 'false') {
                    //     toastr['warning'](sms_result.sms_sent);
                    // }
                    setTimeout(function () {
                        $('#reparationmodal').modal('hide');
                        find_reparation(result.id);
                        $('#dynamic-table').DataTable().ajax.reload();
                        $('#dynamic-table-completed').DataTable().ajax.reload();
                        $('#view_reparation').modal('show');
                    }, 500);
                }
            });

        } else {
            url = base_url + "panel/reparation/edit";
            dataString.append('id',id);
            $.ajax({
                url: url,
                type: "POST",
                data:  dataString,
                contentType:false,
                cache: false,
                processData:false,
                success: function (result) {
                    toastr['success']("<?= lang('edit'); ?>", "<?= lang('reparation_title'); ?>: " + name + " " + "<?= lang('edited'); ?>");
                    // sms_result = result.sms_result;
                    // if (sms_result.sms_sent !== 'true' && sms_result.sms_sent !== 'false') {
                    //     toastr['warning'](sms_result.sms_sent);
                    // }
                    setTimeout(function () {
                        $('#reparationmodal').modal('hide');
                        find_reparation(id);
                        $('#dynamic-table').DataTable().ajax.reload();
                        $('#dynamic-table-completed').DataTable().ajax.reload();
                        $('#view_reparation').modal('show');
                    }, 500);
                }
            });
        }
        return false;
    });
    });
    jQuery('.inp_cat').hide();

    jQuery("#category_select").on("select2:select", function (e) {
        var selected = jQuery("#category_select").val();
        if(selected === 'other') {
            jQuery('.select_cat').hide();
            jQuery('.inp_cat').show();
            jQuery('#category_input').val('');
            jQuery('#category_input').focus();

        }
        else
        {
            jQuery('#category_select').val(selected);
        }
    });

function find_reparation(num) {
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/reparation/getReparationByID",
            data: "id=" + num,
            cache: false,
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (typeof data.name === 'undefined') {
                    alert('Not Found');
                } else {
                    jQuery('#titoloOE').html("<?=lang('reparation_title');?>: " + " " + data.model_name + " <span>");
                    jQuery('#rv_client').html(data.name);
                    jQuery('#rv_condition').html(data.status);
                    jQuery('#rv_created_at').html(data.date_opening);
                    jQuery('#rv_defect').html(data.defect);
                    jQuery('#rv_category').html(data.category);
                    jQuery('#rv_model').html(data.manufacturer + ' ' + data.model_name);
                    jQuery('#rv_advance').html('<?= $settings->currency; ?>' + formatMoney(data.advance));
                    jQuery('#rv_price').html('<?= $settings->currency; ?>' + formatMoney(data.grand_total));
                    jQuery('#rv_phone_number').html(data.telephone);
                    jQuery('#rv_rep_code').html(data.code);
                    jQuery('#rv_comment').html(data.comment);
                    jQuery('#rv_imei').html(data.imei);
                    jQuery('#rv_diagnostics').html(data.diagnostics);
                    jQuery('#rv_icloud').html(data.icloud);
                    jQuery('#rv_icloud_password').html(data.icloud_password);
                    jQuery('#rv_passcode').html(data.passcode);
                    warranties = <?=json_encode($warranties);?>;
                    jQuery('#rv_warranty').html(warranties[data.warranty]);

                    jQuery('#rv_service_charges').html(data.service_charges);
                    console.log(data.date_closing);
                    if (data.date_closing != null) {
                        jQuery('#rv_date_closing').html(data.date_closing);
                        $('.expected_close_date_div').hide();
                        $('.closing_date_div').show();
                    }else{
                        jQuery('#rv_expected_close_date').html(data.expected_close_date);
                        $('.closing_date_div').hide();
                        $('.expected_close_date_div').show();
                    }
                    jQuery('#rv_taxrate').html('<?= $settings->currency; ?>' + formatMoney(data.tax) + (data.tax_name ? ' (' + data.tax_name + ')': ''));
                    jQuery('#rv_assigned_to').html(data.assigned_name);

                    $("#view_repair_items").empty();
                    var pp = 0;

                    // Table of Items
                    $.each(data.items, function() { 
                        var row_no = this.id;
                        var item_id = this.id;
                        var newTr = $('<tr id="row_' + row_no + '" class="item_' + this.id + '" data-item-id="' + row_no + '"></tr>');
                        tr_html = '<td>' + this.name + ' (' + this.code + ')</td>';
                        tr_html += '<td>'+formatDecimal(this.qty)+'</td>';
                        tr_html += '<td>'+formatDecimal(this.price)+'</td>';
                        newTr.html(tr_html);
                        newTr.prependTo("#view_repair_items");
                        pp += parseFloat(parseFloat(this.price)*parseFloat(this.qty));
                    });

                    $('#rv_price_span').html(formatDecimal(pp));
                    $('#rv_sc_span').html(formatDecimal(data.service_charges));
                    $('#rv_tax_span').html(formatDecimal(data.tax));
                    $('#rv_advance_span').html(formatDecimal(data.advance));
                    $('#rv_gtotal').html(formatDecimal((parseFloat(data.tax) + parseFloat(data.total) + parseFloat(data.service_charges)) - parseFloat(data.advance)));
                    // TABLE Add - END

                    jQuery('.show_custom').html('');
                    var IS_JSON = true;
                    try
                    {
                        var json = $.parseJSON(data.custom_field);
                    }
                    catch(err)
                    {
                        IS_JSON = false;
                    }                
                    if(IS_JSON) 
                    {
                        $.each(json, function(id_field, val_field) {
                            jQuery('#v'+id_field).html(val_field);
                        });
                    }
                    var string = "<div class=\"pull-right btn-group\">";
                    string += '<span class="pull-left label label-info label-xs" style="padding:6px 12px;" ><label for="half_a4">Half A4 Size</label><input id="half_a4" type="checkbox" value="1"></span>';
                    string += '<span class="pull-left label label-info label-xs" style="padding:6px 12px;" ><label for="full_a4">Full A4 Size</label><input id="full_a4" type="checkbox" value="1"></span>';
                    string += '<span class="pull-left label label-info label-xs" style="padding:6px 12px;" ><label for="two_copies">Two Copies</label>  <input id="two_copies" type="checkbox" value="1"></span>';
                    string += '<span class="pull-left label label-info label-xs" style="padding:6px 12px;" ><?=lang('reparation_sms', 'sms');?><input type="checkbox" '+(parseInt(data.sms) === 1 ? 'checked' : '' )+' disabled value="1" name="sms"></span><span  style="padding:6px 12px;" class="pull-left label label-warning label-xs"><label for="email"><?=lang('send_email_check');?></label><input type="checkbox" '+(parseInt(data.email) === 1 ? 'checked' : '' )+' disabled value="1" name="email"></span>';
                    <?php if($this->Admin || $this->GP['repair-view_files']): ?>
                        string += '<button id="upload_modal_btn" class="btn btn-success pull-left" data-mode="edit" data-num="' + encodeURI(num) + '"><i class="fa fa-cloud"></i> <?=lang('view_attached');?></button>';
                    <?php endif;?> 

                    string += "<button type=\"button\" data-type=\"2\" data-num=\"" + data.id + "\" id=\"print_reparation\" class=\"btn btn-default\"><i class=\"fa fa-print\"></i> <?= lang('report'); ?></button><button type=\"button\" data-type=\"1\" data-num=\"" + data.id + "\" id=\"print_reparation\" class=\"btn btn-default\"><i class=\"fa fa-print\"></i> <?= lang('invoice');?></button><button data-dismiss=\"modal\" class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-reply\"></i> <?=lang('go_back');?></button></div><div class=\"btn-group pull-left\">";

                    <?php if($this->Admin || $GP['repair-delete']): ?>
                        string += "<button data-dismiss=\"modal\" id=\"delete_reparation\" data-num=\"" + data.id + "\" class=\"btn btn-danger\" type=\"button\"><i class=\"fa fa-trash-o \"></i> <?= lang('delete');?></button>";
                    <?php endif; ?>
                    <?php if($this->Admin || $GP['repair-edit']): ?>
                        string += "<button id=\"modify_reparation\" data-dismiss=\"modal\" href=\"#reparationmodal\" data-toggle=\"modal\" data-num=\"" + data.id + "\" class=\"btn btn-success\"><i class=\"fas fa-edit\"></i>Modify</button>";
                    <?php endif; ?>
                    next_status = data.next_status
                    if (data.status > 0 && next_status) {
                        string = string + "<button type=\"button\" id=\"status_change\" class=\"btn btn-primary\" data-to_status=\"" + next_status.id + "\" data-num=\"" + data.id + "\"><i class=\"fa fa-check\"></i> "+next_status.label+" </button>";
                    }
                    string = string + "</div>";
                    if (data.status > 0) {
                        jQuery('#rv_condition').html(data.status_name);
                        jQuery('#rv_condition').css('color',data.fg_color);
                        jQuery('#rv_condition').css('background-color',data.bg_color);
                    } else {
                        jQuery('#rv_condition').html("<?=lang('cancelled');?>");
                        jQuery('#rv_condition').css('color', '#FFF');
                        jQuery('#rv_condition').css('background-color', '#000');

                    }

                    jQuery('#footerOR').html(string);
                }
            }
        });
    }

    jQuery(document).on("click", "#status_change", function() {
        var num = jQuery(this).data("num");
        var to_status = jQuery(this).data("to_status");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/reparation/status_toggle",
            data: "id=" + encodeURI(num) + "&to_status="+encodeURI(to_status),
            cache: false,
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    msg = '';
                    if (data.data.sms_sent) {
                        msg += "<?= lang('sms_sent'); ?>\n";
                    }else{
                        msg += "<?= lang('sms_not_sent'); ?>\n";
                    }
                    if (data.data.email_sent) {
                        msg += "<?= lang('email_sent'); ?>\n";
                    }else{
                        msg += "<?= lang('email_not_sent'); ?>\n";
                    }
                    toastr['success']("<?= lang('status_changed_to');?> "+data.data.label+"\n"+msg);
                    $('#dynamic-table').DataTable().ajax.reload();
                    find_reparation(num);
                }else{
                    toastr['error']("<?= lang('error_support');?>");

                }
            }
        });
    });
</script>
<!-- Manufacturer Add -->
<div class="modal fade" id="modelmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="model_title_head"></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                    <div class="row">
                        <form id="model_form" class="col s12">
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('model_name', 'model_name'); ?>
                                    <select class="form-control" id="model_name" name="name[]" required="" multiple style="width: 100%;"></select>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('model_manufacturer', 'model_manufacturer'); ?>
                                    <input class="form-control manufacturer_name_typeahead" id="manufacturer_name" name="parent_id" required="" style="width: 100%;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="model_footer">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.input-group .tt-menu.tt-open {
    top: 34px !important;
}
.tt-menu {
  min-width: 160px;
  margin-top: 2px;
  padding: 5px 0;
  background-color: #fff;
  border: 1px solid #ebebeb;
  *border-right-width: 2px;
  *border-bottom-width: 2px;
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  width: 100%;
}
.tt-suggestion {
  display: block;
  padding: 4px 12px;
}
.tt-suggestion p {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  height: 17px;
}
.tt-suggestion:hover {
    color: #303641;
    background: #f3f3f3;
}

.twitter-typeahead{
    display: block !important;
}
</style>
<script>
    $(document).ready(function () {
        $("#model_name").select2({
          tags: true,
          tokenSeparators: [','],
          // closeOnSelect: false,
        });
    });

    var substringMatcher = function(strs) {
      return function findMatches(q, cb) {
        var matches, substringRegex;

        // an array that will be populated with substring matches
        matches = [];

        // regex used to determine if a string contains the substring `q`
        substrRegex = new RegExp(q, 'i');

        // iterate through the pool of strings and for any string that
        // contains the substring `q`, add it to the `matches` array
        $.each(strs, function(i, str) {
          if (substrRegex.test(str)) {
            matches.push(str);
          }
        });

        cb(matches);
      };
    };

    var manufacturers = [
        <?php foreach ($manufacturers as $manufacturer): ?>
            "<?=$manufacturer->name;?>",
        <?php endforeach; ?>
    ];
    $('.manufacturer_name_typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'manufacturers',
        source: substringMatcher(manufacturers)
    });


    var categories = [
        <?php foreach (explode(',', $settings->category) as $line): ?>
            "<?=$line;?>",
        <?php endforeach; ?>
    ];
    $('.categories_typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'categories',
        source: substringMatcher(categories)
    });

    $('.model_name_typeahead').typeahead(null, {
        name: 'model',
        display: 'name',
        source: function(query, syncResults, asyncResults) {
            $.get( '<?=base_url();?>panel/inventory/getModels/'+query+'?manufacturer='+encodeURI($('#reparation_manufacturer').val()), function(data) {
                asyncResults(data);
            });
        }
    });

    var defectSuggestions = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // prefetch: '<?=base_url();?>panel/reparation/getDefects/',
        remote: {
            url: '<?=base_url();?>panel/reparation/getDefects/%QUERY',
            wildcard: '%QUERY'
        }
    });

    $('.defect_typeahead').typeahead(null, {
        name: 'defect',
        display: 'defect',
        source: defectSuggestions
    });


    var imeiSuggestions = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // prefetch: '<?=base_url();?>panel/reparation/getDefects/',
        remote: {
            url: '<?=base_url();?>panel/reparation/getMobileImeis/%QUERY',
            wildcard: '%QUERY'
        }
    });

    $('.imei_typeahead').typeahead(null, {
        name: 'imei',
        display: 'imei',
        source: imeiSuggestions
    });

    $('.imei_typeahead').bind('typeahead:autocomplete typeahead:select', function(ev, suggestion) {
        imei = $(this).val();
        jQuery.ajax({
            type: "POST",
            url: '<?=base_url();?>panel/reparation/getReparationByIMEI',
            data: 'imei='+imei,
            cache: false,
            success: function (data) {
                $('#category').val(data.category);
                $('#reparation_manufacturer').val(data.manufacturer);
                $('#reparation_model').val(data.model_name);
                $('#client_name').val(data.client_id).trigger('change');
            }
        });
    });

    jQuery(".add_model").on("click", function (e) {
        $('#modelmodal').modal('show');
        $('#model_form').trigger("reset");
        $("#model_name").val("").trigger('change');
        $('#model_form').parsley().reset();
        jQuery('#model_title_head').html("<?= lang('add'); ?> <?= lang('model_title'); ?>");
        jQuery('#model_footer').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang("go_back") ?></button><button id="submit" role="button" form="model_form" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> <?= lang("add"); ?> <?= lang("model_title"); ?></button>');
    });

     $(function () {
      $('#model_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
      }).on('form:submit', function(event) {
        var mode = jQuery('#submit').data("mode");
        var id = jQuery('#submit').data("num");

        var name = jQuery('#model_name').val();
        var manufacturer = jQuery('#manufacturer_name').val();
       
        var url = "";
        var dataString = "";

        if (mode == "add") {
            url = base_url + "panel/inventory/add_model";
            dataString = $('#model_form').serialize();
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success']("<?= lang('add'); ?>", "<?= lang('model_title'); ?>: " + name + " " + manufacturer + " <?= lang('added'); ?>");
                    setTimeout(function () {
                        $('#modelmodal').modal('hide');
                        if ($('#reparationmodal').hasClass('in')) {
                            jQuery('#model').append('<option value="'+data+'">'+name+'</option>');
                            jQuery('#model').val(data);
                            $("#model").select2();
                        }else{
                            $('#dynamic-table').DataTable().ajax.reload();
                        }
                    }, 500);

                }
            });
        } else {
            url = base_url + "panel/inventory/edit_model";
            dataString = $('#model_form').serialize() + "&id=" + encodeURI(id);
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success']("<?= lang('save'); ?>", "<?= lang('model_title'); ?>: " + name + " " + manufacturer + "<?= lang('updated'); ?>");
                    setTimeout(function () {
                        $('#modelmodal').modal('hide');
                        $('#dynamic-table').DataTable().ajax.reload();
                    }, 500);
                }
            });
        }
        return false;
      });
    });

</script>


<!-- ============= MODAL View CLient ============= -->
<div class="modal fade" id="view_client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><div id="titoloclienti"></div></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> <?= lang('client_name'); ?> </span><span id="v_name"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> <?= lang('client_company'); ?> </span><span id="v_company"></span></p>
                        </div>
                        <!-- <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-road"></i> <?= lang('client_address'); ?></span><span id="v_address"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-globe"></i><?= lang('client_city'); ?></span><span id="v_city"></span></p>
                        </div>
                         <div class="col-md-12 col-lg-6 bio-row">
                            <p>
                                <span class="bold">
                                    <i class="fa fa-globe"></i>
                                    <?= lang('client_postal_code'); ?>
                                </span>
                                <span id="v_postal_code"></span>
                            </p>
                        </div> -->
                        
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-phone"></i> <?= lang('client_telephone'); ?> </span><span id="v_telephone"></span></p>
                        </div>
                         <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-phone"></i> <?= lang('client_telephone2'); ?> </span><span id="v_telephone2"></span></p>
                        </div>
                       <!--  <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> <?= lang('client_email'); ?> </span><span id="v_email"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-barcode"></i> <?= lang('client_vat'); ?> </span><span id="v_vat"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('client_ssn'); ?> </span><span id="v_cf"></span></p>
                        </div> -->

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                             <div class="form-group commenti">
                                <label><?= lang('client_comment'); ?></label>
                                <textarea class="form-control" id="v_comment" rows="6" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group commenti">
                                <label><?= lang('client_info'); ?></label>
                                <textarea class="form-control" id="v_info" rows="6" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 no-padding">
                            <?=lang('client_image_upload', 'image');?>
                        </div>
                        <div class="col-lg-4">
                            <div id="v_showIfImage" style="display: none;">
                                <button class="btn btn-primary" id="v_view_image_in" data-num> <?=lang('download');?> <i class="fa fa-download"></i></button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer" id="footerClient"></div>
        </div>
    </div>
</div>

<!-- ============= MODAL MODIFY CLIENTI ============= -->
<div class="modal fade" id="clientmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titclienti"></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                    <div class="row"> 
                        <form id="client_form" class="col s12" data-parsley-validate" autocomplete="off">
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_name', 'name1'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-user"></i>
                                        </div>
                                        <input id="name1" name="name" type="text" class="validate form-control" required>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_company', 'company1'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-user"></i>
                                        </div>
                                        <input name="company" id="company1" type="text" class="validate form-control" required>
                                    </div>
                                </div>
                            </div>
                            <!--  <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label><?=lang('geolocate');?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-map-marker"></i>
                                        </div>
                                        <div id="locationField">
                                          <input id="autocomplete" class="form-control" placeholder="<?=lang('enter_address');?>"
                                                 onFocus="geolocate()" type="text"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <?= lang('client_address', 'address1'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-road"></i>
                                        </div>
                                        <input type="hidden" class="field form-control input-xs" id="street_number">
                                        <input type="hidden" class="field form-control input-xs" id="administrative_area_level_1">
                                        <input name="address"  id="route" type="text" class="validate form-control input-xs">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_city', 'city1'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-globe"></i>
                                        </div>
                                        <input name="city" id="locality" type="text" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_postal_code', 'postal_code'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-globe"></i>
                                        </div>
                                        <input name="postal_code" id="postal_code" type="text" class="validate form-control">
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_telephone', 'telephone'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-phone"></i>
                                        </div>
                                        <input id="telephone" name="telephone" type="text" class="validate form-control" data-mask="(999) 999-9999">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_telephone2', 'telephone2'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-phone"></i>
                                        </div>
                                        <input id="telephone2" name="telephone2" type="text" class="validate form-control" data-mask="(999) 999-9999">
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?=lang('icloud', 'icloud_user');?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-cloud"></i>
                                        </div>
                                        <input id="icloud_user" name="icloud_user" type="text" class="validate form-control">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?=lang('icloud_password', 'icloud_pass');?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-cloud"></i>
                                        </div>
                                        <input id="icloud_pass" name="icloud_pass" type="text" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_email', 'email1'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-envelope"></i>
                                        </div>
                                        <input id="email1" name="email" type="email" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_vat', 'vat1'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-envelope"></i>
                                        </div>
                                        <input name="vat" id="vat1" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('client_ssn', 'cf1'); ?>
                                    <input name="cf" id="cf1"  class="validate form-control">
                                </div>
                            </div> -->
                            <div class="col-lg-8 col-sm-12">
                                <div class="col-md-12 no-padding">
                                    <?=lang('client_image_upload', 'image');?>
                                </div>
                                <div class="col-lg-8 no-padding">
                                    <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-upload"></i>
                                        </div>
                                        <input id="image" type="file" data-browse-label="Browse" name="image" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                                    </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div id="showIfImage" style="display: none;">
                                        <button class="btn btn-primary" id="view_image_in" data-num><i class="fa fa-eye"></i></button>
                                        <button class="btn btn-danger" id="delete_customer_image" data-num><i class="fa fa-trash-o"></i> <?=lang('delete')?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="input-field">
                                <div class="input-field col-lg-6">
                                    <div class="form-group">
                                        <?= lang('client_comment', 'comment1'); ?>
                                        <textarea class="form-control" id="comment1" name="comment" rows="6"></textarea>
                                    </div>
                                </div>

                                 <div class="input-field col-lg-6">
                                    <div class="form-group">
                                        <?= lang('client_info', 'info'); ?>
                                        <textarea class="form-control" id="info" name="info" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
            <div class="modal-footer" id="footerClient1">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    jQuery(".add_c").on("click", function (e) {
        $('#clientmodal').modal('show');
        $('#client_form').trigger("reset");
        $('#client_form').parsley().reset();
        $('#showIfImage').hide();

        jQuery('#titclienti').html("<?= lang('add'); ?> <?= lang('client_title'); ?>");
        jQuery('#footerClient1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang("go_back"); ?></button><button role="button" form="client_form" id="submit" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> <?= lang("add"); ?> <?= lang("client_title"); ?></button>');
    });

    function showImage(url) {
        var img = new Image();
        img.src = url;
        img.onload = function() {
            bootbox.dialog({ message: "<a target='_blank' href='"+url+"'><center><img src='"+url+"'></center></a>" , backdrop:true, onEscape:true}).find("div.modal-dialog").css({ "width": (this.width)+40+"px"});
        }

    };


    jQuery(document).on("click", "#view_image_in, #v_view_image_in", function (e) {
        e.preventDefault();
        image_name = $(this).attr('data-num');
        if (image_name) {
            window.open('<?=base_url();?>assets/uploads/images/'+image_name);
            // showImage('<?=base_url();?>assets/uploads/images/'+image_name);
        }else{
            bootbox.alert({
                message: '<?=lang('client_no_image');?>',
                backdrop: true
            });
        }
    });

    jQuery(document).on("click", "#delete_customer_image, #v_delete_customer_image", function (e) {
        e.preventDefault();
        var num = jQuery(this).attr("data-num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/customers/delete_image",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr['success']("client image removed");
                    $('#showIfImage').hide();
                    $('#v_showIfImage').hide();
                }else{
                    toastr['error']("error client image not removed");
                }
            }
        });
    });

    jQuery(document).on("click", "#modify_client", function () {
            jQuery('#titclienti').html('<?= lang('edit'); ?> <?= lang('client_title'); ?>');
            var num = jQuery(this).data("num");
            $('#client_form').trigger("reset");
            $('#client_form').parsley().reset();

            jQuery.ajax({
                type: "POST",
                url: base_url + "panel/customers/getCustomerByID",
                data: "id=" + encodeURI(num) + "&token=<?=$_SESSION['token'];?>",
                cache: false,
                dataType: "json",
                success: function (data) {
                    jQuery('#name1').val(data.name);
                    jQuery('#company1').val(data.company);
                    jQuery('#address1').val(data.address);
                    jQuery('#city1').val(data.city)
                    jQuery('#telephone').val(data.telephone);
                    jQuery('#email1').val(data.email)
                    jQuery('#comment1').val(data.comment);
                    jQuery('#postal_code').val(data.postal_code);
                    jQuery('#vat1').val(data.vat);
                    jQuery('#cf1').val(data.cf);
                    jQuery('#telephone2').val(data.telephone2);
                    jQuery('#info').val(data.info);
                    jQuery('#icloud_user').val(data.icloud_user);
                    jQuery('#icloud_pass').val(data.icloud_pass);

                    $('#showIfImage').hide();
                    if (data.image) {
                        $('#showIfImage').show();
                        $('#view_image_in').attr('data-num', data.image);
                        $('#delete_customer_image').attr('data-num', data.id);
                    }
                    jQuery('#footerClient1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang("go_back"); ?></button><button id="submit" role="button" form="client_form" class="btn btn-success" data-mode="modify" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> <?= lang("save"); ?> <?= lang("client_title"); ?></button>')
                }
            });
        });

$(function () {
    $('#client_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
    }).on('form:submit', function(event) {
        var mode = jQuery('#submit').data("mode");
        var id = jQuery('#submit').data("num");

        var name = jQuery('#name1').val();
        var company = jQuery('#company1').val();
        var address = jQuery('#address1').val();
        var city = jQuery('#city1').val();
        var telephone = jQuery('#telephone').val();
        var email = jQuery('#email1').val();
        var comment = jQuery('#comment1').val();
        var vat = jQuery('#vat1').val();
        var cf = jQuery('#cf1').val();

        var url = "";
        var formData = new FormData($('form#client_form')[0]);
        if (mode == "add") {
            url = base_url + "panel/customers/add";
            jQuery.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    toastr['success']("<?= lang('add');?>", "<?= lang('client_title');?> " + name + " " + company + " <?= lang('added');?>");
                    if (data.error) {
                        toastr['error'](data.error);
                    }
                    setTimeout(function () {
                        $('#clientmodal').modal('hide');
                        jQuery('#client_name').append('<option value="'+data.id+'">'+name+' '+company+'</option>');
                        if ($('#reparationmodal').hasClass('in')) {
                            $('#client_name').val(data.id);
                            $("#client_name").select2();
                        }else{
                            find_client(data.id);
                            $('#dynamic-table').DataTable().ajax.reload();
                            $('#view_client').modal('show');
                        }
                    }, 500);
                }
            });
        } else {
            formData.append('id', id);
            url = base_url + "panel/customers/edit";
            jQuery.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    toastr['success']("<?= lang('edit');?>", "<?= lang('client_title');?>: " + name + " " + company + "<?= lang('updated');?>");
                    if (data.error) {
                        toastr['error'](data.error);
                    }
                    setTimeout(function () {
                        $('#clientmodal').modal('hide');
                        find_client(id);
                        $('#dynamic-table').DataTable().ajax.reload();
                        $('#view_client').modal('show');
                    }, 500);
                }
            });
        }
        return false;
    });
});
   
   function reparationID_link(x) {
        x = x.split('___');
        find_reparation(x[0]);
        return '<a data-dismiss="modal" class="view" href="#view_reparation" data-toggle="modal" data-num="'+x[0]+'">'+x[1]+'</a>';
   }
    // View Client - FIND
    var oTable;
    function find_client(num) {
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/customers/getCustomerByID",
            data: "id=" + encodeURI(num) + "&token=<?=$_SESSION['token'];?>",
            cache: false,
            dataType: "json",
            success: function (data) {
                if (typeof data.name === 'undefined') {
                    $('#view_client').modal('hide');
                    toastr['error']('No Client', '');
                } else {
                    jQuery('#titoloclienti').html('Client: ' + data.name);
                    jQuery( ".flatb.add" ).data( "name", data.name+' '+data.company);
                    jQuery( ".flatb.add" ).data( "id_name", data.id);
                    jQuery( ".flatb.lista" ).data( "name", data.name+' '+data.company);
                    jQuery('#v_name').html(data.name);
                    jQuery('#v_company').html(data.company);
                    jQuery('#v_address').html(data.address);
                    jQuery('#v_city').html(data.city)
                    jQuery('#v_telephone').html(data.telephone);
                    jQuery('#v_email').html(data.email)
                    jQuery('#v_comment').html(data.comment);
                    jQuery('#v_vat').html(data.vat);
                    jQuery('#v_postal_code').html(data.postal_code);
                    jQuery('#v_cf').html(data.cf);
                    jQuery('#v_telephone2').html(data.telephone2);
                    jQuery('#v_info').html(data.info);
                    $('#v_showIfImage').hide();
                    if (data.image) {
                        $('#v_showIfImage').show();
                        $('#v_view_image_in').attr('data-num', data.image);
                        $('#v_delete_customer_image').attr('data-num', data.id);
                    }

                    var string = "<button data-dismiss=\"modal\" class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-reply\"></i> <?= lang('go_back');?></button>";
                    <?php if($this->Admin || $GP['customers-edit']): ?>
                        string += "<button data-dismiss=\"modal\" id=\"modify_client\" href=\"#clientmodal\" data-toggle=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-success\"><i class=\"fa fa-pencil\"></i> <?= lang('modify'); ?></button>";
                    <?php endif; ?>
                    <?php if($this->Admin || $GP['customers-delete']): ?>
                        string += "<button id=\"delete_client\" data-dismiss=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-danger\" type=\"button\"><i class=\"fa fa-trash-o \"></i> <?= lang('delete'); ?></button>";
                    <?php endif; ?>
                    jQuery('#footerClient').html(string);
                }
            }
        });
    }

</script>
<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
     
      var componentForm = {
        street_number: 'long_name',
        route: 'long_name',
        locality: 'long_name',
         administrative_area_level_1: 'short_name',
        // country: 'long_name',
         postal_code: 'short_name'
      };


      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        var fullAddress = [];
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
            if (addressType == "street_number") {
                fullAddress[0] = val;
            } else if (addressType == "route") {
                fullAddress[1] = val;
            }
        }
        document.getElementById('route').value = fullAddress.join(" ");
        if (document.getElementById('route').value !== "") {
          document.getElementById('route').disabled = false;
        }
      }


      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $settings->google_api_key?>&libraries=places&callback=initAutocomplete"
        async defer></script>
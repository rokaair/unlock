<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#extras').change(function() {
      if ($(this).is(':checked')) {
        $('#extras-con').slideDown();
      } else {
        $('#extras-con').slideUp();
      }
    });
   
});
</script>

<script type="text/javascript">
    
    <?php if ($this->session->userdata('remove_pols')) { ?>
    if (localStorage.getItem('poitems')) {
        localStorage.removeItem('poitems');
    }
    if (localStorage.getItem('podiscount')) {
        localStorage.removeItem('podiscount');
    }
    if (localStorage.getItem('potax2')) {
        localStorage.removeItem('potax2');
    }
    if (localStorage.getItem('poshipping')) {
        localStorage.removeItem('poshipping');
    }
    if (localStorage.getItem('poref')) {
        localStorage.removeItem('poref');
    }
    if (localStorage.getItem('powarehouse')) {
        localStorage.removeItem('powarehouse');
    }
    if (localStorage.getItem('ponote')) {
        localStorage.removeItem('ponote');
    }
    if (localStorage.getItem('posupplier')) {
        localStorage.removeItem('posupplier');
    }
    if (localStorage.getItem('pocurrency')) {
        localStorage.removeItem('pocurrency');
    }
    if (localStorage.getItem('poextras')) {
        localStorage.removeItem('poextras');
    }
    if (localStorage.getItem('podate')) {
        localStorage.removeItem('podate');
    }
    if (localStorage.getItem('postatus')) {
        localStorage.removeItem('postatus');
    }
  
    <?php $this->repairer->unset_data('remove_pols');
} ?>
    var count = 1, an = 1, po_edit = false, product_variant = 0, DT = <?= $settings->default_tax_rate ?>, DC = '<?= $settings->currency ?>', shipping = 0,
        product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0,
        tax_rates = <?php echo json_encode($tax_rates); ?>, poitems = {};
        
    $(document).ready(function () {
        <?php if($this->input->get('supplier')) { ?>
        if (!localStorage.getItem('poitems')) {
            localStorage.setItem('posupplier', <?=$this->input->get('supplier');?>);
        }
        <?php } ?>

        if (!localStorage.getItem('podate')) {
            $("#podate").datetimepicker({
                defaultDate: "<?= date('m/d/y m:i:s'); ?>"
            });
        }
        $(document).on('change', '#podate', function (e) {
            localStorage.setItem('podate', $(this).val());
        });
        if (podate = localStorage.getItem('podate')) {
            $('#podate').val(podate);
        }
        if (!localStorage.getItem('potax2')) {
            localStorage.setItem('potax2', <?=$settings->default_tax_rate;?>);
            setTimeout(function(){ $('#extras').iCheck('check'); }, 1000);
        }
        ItemnTotals();
        $("#add_item").autocomplete({
            // source: '<?= site_url('panel/purchases/suggestions'); ?>',
            source: function (request, response) {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('panel/purchases/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        supplier_id: $("#posupplier").val()
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang("nothing_found"); ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang("nothing_found"); ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_purchase_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang("nothing_found"); ?>');
                }
            }
        });
    });

</script>
<div class="box">
            <div class="box-header">
              <h3 class="box-title"><?= lang('add_purchase'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                        echo form_open_multipart("panel/purchases/add", $attrib)
                        ?>
                        <div class="row">
                            <div class="col-lg-12">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang('date', 'podate'); ?>
                                            <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="podate" required="required"'); ?>
                                        </div>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('reference_no', 'poref'); ?>
                                        <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $ponumber), 'class="form-control input-tip" id="poref"'); ?>
                                    </div>
                                </div>
                                

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('status', 'postatus'); ?>
                                        <?php
                                        $post = array('received' => lang("received"), 'pending' => lang('pending'), 'ordered' => lang('ordered'));
                                        echo form_dropdown('status', $post, (isset($_POST['status']) ? $_POST['status'] : ''), 'id="postatus" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("status") . '" required="required" style="width:100%;" ');
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('document', 'document'); ?>
                                        <input id="document" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false"
                                               data-show-preview="false" class="form-control file">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="panel panel-warning">
                                        <div
                                            class="panel-heading"><?= lang('please_select_these_before_adding_product'); ?></div>
                                        <div class="panel-body" style="padding: 5px;">
                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <?= lang('supplier', 'posupplier'); ?>
                                                    <select class="form-control" name="posupplier" id="posupplier">
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="col-md-12" id="sticker">
                                    <div class="well well-sm">
                                        <div class="form-group" style="margin-bottom:0;">
                                            <div class="input-group wide-tip">
                                                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                                    <i class="fa fa-2x fa-barcode addIcon"></i></a></div>
                                                <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . lang('add_product') . '"'); ?>
                                                
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="control-group table-group">
                                        <label class="table-label"><?= lang('order_items'); ?></label>

                                        <div class="controls table-controls">
                                            <table id="poTable"
                                                   class="table items table-striped table-bordered table-condensed table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-4"><?= lang('product_name'); ?>(<?= lang('product_code'); ?>)</th>
                                                    

                                                    <th class="col-md-1"><?= lang('unit_cost'); ?></th>
                                                    <th class="col-md-1"><?= lang('quantity'); ?></th>
                                                    <?php if($settings->product_discount == 1): ?>
                                                    <th class="col-md-1"><?= lang('discount'); ?></th>
                                                    <?php endif; ?>
                                                    <?php if($settings->tax1 == 1): ?>
                                                    <th class="col-md-1"><?= lang('tax'); ?></th>
                                                    <?php endif; ?>
                                                    <th><?= lang("subtotal"); ?> (<span
                                                            class="currency"><?= $settings->currency ?></span>)
                                                    </th>
                                                    <th style="width: 30px !important; text-align: center;"><i
                                                            class="fa fa-trash-o"
                                                            style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot></tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <input type="hidden" name="total_items" value="" id="total_items" required="required"/>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox" class="checkbox" id="extras" value=""/>
                                        <label for="extras" class="padding05"><?= lang('more_options'); ?></label>
                                    </div>
                                    <div class="row" id="extras-con" style="display: none;">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?= lang('order_tax', 'potax2'); ?>
                                                    <?php
                                                    $tr = array();
                                                    foreach ($tax_rates as $tax) {
                                                        $tr[$tax['id']] = $tax['name'];
                                                    }
                                                    echo form_dropdown('order_tax', $tr, "", 'id="potax2" class="form-control input-tip select" style="width:100%;"');
                                                    ?>
                                                </div>
                                            </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('discount', 'podiscount'); ?>
                                                <?php echo form_input('discount', '', 'class="form-control input-tip" id="podiscount"'); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('shipping', 'poshipping'); ?>
                                                <?php echo form_input('shipping', '', 'class="form-control input-tip" id="poshipping"'); ?>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <?= lang('note', 'ponote');?>
                                        <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="ponote" style="margin-top: 10px; height: 100px;"'); ?>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div
                                        class="from-group"><?php echo form_submit('add_pruchase', lang('submit'), 'id="add_pruchase" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                        <button type="button" class="btn btn-danger" id="reset"><?= lang('reset'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bottom-total" class="well well-sm" style="margin-bottom: 0;">
                            <table class="table table-bordered table-condensed totals" style="margin-bottom:0;">
                                <tr class="warning">
                                    <td><?= lang('items') ?> <span class="totals_val pull-right" id="titems">0</span></td>
                                    <td><?= lang('total') ?> <span class="totals_val pull-right" id="total">0.00</span></td>
                                    <td><?= lang('order_discount') ?> <span class="totals_val pull-right" id="tds">0.00</span></td>
                                    <?php if ($settings->tax2) { ?>
                                        <td><?= lang('order_tax') ?> <span class="totals_val pull-right" id="ttax2">0.00</span></td>
                                    <?php } ?>
                                    <td><?= lang('shipping') ?> <span class="totals_val pull-right" id="tship">0.00</span></td>
                                    <td><?= lang('grand_total') ?> <span class="totals_val pull-right" id="gtotal">0.00</span></td>
                                </tr>
                            </table>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
          </div>

<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="prModalLabel"></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= lang('product_tax') ?></label>
                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax['id']] = $tax['name'];
                                }
                                echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
                        </div>
                    </div>
                        

                        <div class="form-group">
                            <label for="pdiscount" class="col-sm-4 control-label"><?= lang('product_discount') ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pdiscount">
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="pcost" class="col-sm-4 control-label"><?= lang('unit_cost') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pcost">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_cost'); ?></th>
                            <th style="width:25%;"><span id="net_cost"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                    </table>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?= lang('calculate_unit_cost'); ?></div>
                        
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="pcost" class="col-sm-4 control-label"><?= lang('subtotal') ?></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="psubtotal">
                                        <div class="input-group-addon" style="padding: 2px 8px;">
                                            <a href="#" id="calculate_unit_price" class="tip" title="<?= lang('calculate_unit_cost'); ?>">
                                                <i class="fa fa-calculator"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="punit_cost" value=""/>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_cost" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#potax2').select2();
    $('#posupplier').select2();
    jQuery(function ($) {        
      $('form').bind('submit', function () {
        $('#posupplier').prop('disabled', false);
      });
    });
</script>
<script type="text/javascript" src="<?= $assets; ?>plugins/custom/purchases.js"></script>
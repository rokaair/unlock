<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
    .ui-autocomplete {
z-index: 99999;
}
.btn-app {
    border-radius: 3px;
    position: relative;
    padding: 0;
    margin: 0 0 10px 10px;
    min-width: 80px;
    height: 60px;
    text-align: center;
    color: #666;
    border: 1px solid #ddd;
    background-color: #f4f4f4;
    font-size: 12px;
}
.table_cat {
    height: 130px !important;
    width: 100px;
    white-space: normal;
    overflow: hidden;
    font-weight: 700;
}
.label-btnpr{
    bottom: 0px !important;
    display: block;
    padding: 9px;
}

.product {
    border: 1px solid #eee;
    cursor: pointer;
    height: 115px;
    margin: 0 0 3px 2px;
    padding: 2px;
    width: 10.5%;
    min-width: 100px;
    overflow: hidden;
    display: inline-block;
    font-size: 13px;
}
/*.btn-prni:hover {
    background: #eee;
    border: 1px solid #e5e5e5;
}*/
.product span {
    display: table-cell;
    height: 45px;
    line-height: 15px;
    vertical-align: middle;
    text-transform: uppercase;
    width: 10.5%;
    min-width: 94px;
    overflow: hidden;
}
/*.btn-prni:hover span {
    background: #eee;
}*/
.product img {
    max-height: 60px !important;
}
.product.active { background: #eee; border: 1px solid #e5e5e5; cursor: default;  }

</style>
<script type="text/javascript">
<?php if ($this->session->userdata('remove_posls')): ?>
    if (localStorage.getItem('pospitems')) {
        localStorage.removeItem('pospitems');
    }
    if (localStorage.getItem('poscustomer')) {
        localStorage.removeItem('poscustomer');
    }
    if (localStorage.getItem('posnote')) {
        localStorage.removeItem('posnote');
    }

<?php 
$this->session->set_userdata('remove_posls', 0);
endif; ?>
jQuery(document).ready( function($) {
	$('#poscustomer').change(function (e) {
	    localStorage.setItem('poscustomer', $(this).val());
	});
    $( ".client_name" ).select2();
    if (poscustomer = localStorage.getItem('poscustomer')) {
        $( "#poscustomer" ).val(poscustomer).trigger('change');
    }
    nav_pointer();

});

</script>
<div>
<form id="pos-sale-form" name="pos-sale-form" action="" method="post">
<div class="col-md-12">
    <div class="row">
        <div class="col-md-7">
            <div id="sticker">
                <!-- <div class="input-group"> -->
                <?php echo form_input('add_pos_item', '', 'class="form-control pos-tip" id="add_pos_item" data-placement="top" data-trigger="focus" placeholder="' . $this->lang->line("search_product_by_name_code") . '" title="' . $this->lang->line("au_pr_name_tip") . '"'); ?>
                    <!-- <div class="input-group-addon" style="padding: 2px 8px;">
                        <a href="#" id="addManually">
                            <i class="fa fa-plus-circle" id="addIcon" style="font-size: 1.5em;"></i>
                        </a>
                    </div> -->
                <!-- </div> -->
            </div>
        </div>

        <div class="col-md-5">
            <div id="left-top">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa  fa-user"></i>
                        </div>
                        <select id="poscustomer" name="customer" class="client_name form-control" style="width: 100%" required>
                            <option selected disabled><?= lang('select_pos_Client'); ?></option>
                            <option value="-1" <?= $this->input->get('customer') && $this->input->get('customer') == -1 ? 'selected' : ''; ?>><?= lang('walk_in'); ?></option>
                            <?php 
                                foreach ($customers as $client) :
                                echo '<option value="'.$client->id.'">'.$client->name.'</option>';
                                endforeach; 
                            ?>
                        </select>
                        <a id="add_client" class="add_c btn input-group-addon"><i class="fa fa-user-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="col-md-7">
   <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
            <h5 style="font-size:16px;" class="box-title" id="rhead">
                <a onclick="getCategories()"> <?= lang('pos'); ?></a>
            </h5>
        </div>
        <div class="box-body pad">
            <div id="gridbox">
                <?php foreach($categories as $category): ?>
                <a id="category_btn" class="btn btn-app table_cat" onclick="selectCategory(<?= $category->id; ?>, true)">
                    <div style="background-image:url(<?= base_url() ?>assets/uploads/<?= $category->image ? $category->image : 'no_image.png'; ?>); background-size: 100px 100px;  height: 100px;width: 100px;">
                    </div>
                    <span id="cat_id_<?= $category->id; ?>" style="font-size: 12px" class="label label-warning label-btnpr"><?= $category->name;?></span>    
                </a>
                <?php endforeach; ?>
                <hr>
                <div class="quick-menu">
                    <div id="proContainer">
                        <div id="ajaxproducts">
                            <div id="item-list">
                                <?php echo $products; ?>
                            </div>
                            
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </div>
            <div class="btn-group btn-group-justified pos-grid-nav">
                <div class="btn-group">
                    <button class="btn btn-primary pos-tip" title="<?=lang('previous')?>" type="button" id="previous">
                        <i class="fa fa-chevron-left"></i>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-primary pos-tip" title="<?=lang('next')?>" type="button" id="next">
                        <i class="fa fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
    <div class="col-md-5">
        <div class="row">
            <div id="left-middle">
                <div id="product-list">
                    <table class="table pitems table-striped table-bordered table-condensed table-hover"
                           id="posTable" style="margin-bottom: 0;">
                        <thead>
                        <tr>
                            <th width="40%"><?= lang('product');?></th>
                            <th width="10%"><?= lang('qty');?></th>
                            <th width="15%"><?= lang('price');?></th>
                            <!-- <th width="10%"><?= lang('tax');?></th> -->
                            <th width="10%"><?= lang('discount');?></th>
                            <th width="20%"><?= lang('subtotal');?></th>
                            <th style="width: 5%; text-align: center;">
                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                            </th>
                        </tr>
                        </thead>
                        <tbody id="Pro-table" bgcolor="white">
                        </tbody>
                    </table>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div id="left-bottom">
                <table id="totalTable"
                       style="padding: 10px; width:100%; float:right; color:#000; background: #FFF;">
                    <tr>
                        <td style="padding: 5px 10px; width: 24%; border-top: 1px solid #DDD;"><?=lang('pitems');?></td>
                        <td class="text-right" style="padding: 5px 10px; width: 24%;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;padding: 5px 10px;">
                            <span id="tpitems">0</span>
                        </td>
                        <td style="padding: 5px 10px; width: 24%;border-top: 1px solid #DDD;"><?=lang('subtotal');?></td>
                        <td class="text-right" style="padding: 5px 10px; width: 24%;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                            <span id="subtotal">0.00</span>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 24%; padding: 5px 10px;"><?=lang('order_tax');?>
                        </td>
                        <td class="text-right" style="width: 24%; padding: 5px 10px;font-size: 14px; font-weight:bold;">
                            <span id="ttax2">0.00</span>
                        </td> -->
                        <td style="width: 24%; padding: 5px 10px;"><?=lang('discount');?>
                        </td>
                        <td class="text-right" style="width: 24%; padding: 5px 10px;font-weight:bold;">
                            <span id="tds">0.00</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="gtotals_tds surcharge_td text-right" style="display:none; padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" colspan="2">
                            <span id="surcharge_span">0.00</span>
                        </td>
                        <td class="gtotals_tds" style="padding: 5px 10px; border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" colspan="2">
                            <?= lang('grand_total');?>
                        </td>
                        <td class="gtotals_tds text-right" style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" colspan="2">
                            <span id="gtotal">0.00</span>
                        </td>
                    </tr>
                </table>

                <div class="clearfix"></div>
                <div id="botbuttons" class="col-xs-12 text-center btn-group">
                    <input type="hidden" name="biller" id="biller" value="<?= $this->ion_auth->user()->row()->id;?>"/>
                    <div class="row">
                        <div class="col-xs-6" style="padding: 0;">
                                <button type="button" class="btn btn-danger btn-block btn-flat" style="height:67px;" 
                                id="reset">
                                    <?=lang('clear_sale');?>
                                </button>
                        </div>
                        <div class="col-xs-6" style="padding: 0;">
                            <button type="button" class="btn btn-success btn-block" id="payment" style="height:67px;">
                                <i class="fa fa-money" style="margin-right: 5px;"></i>
                                <?=lang('payment');?>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="payment-con">
                    <?php for ($i = 1; $i <= 5; $i++) {?>
                        <input type="hidden" name="amount[]" id="amount_val_<?=$i?>" value=""/>
                        <input type="hidden" name="balance_amount[]" id="balance_amount_<?=$i?>" value=""/>
                        <input type="hidden" name="paid_by[]" id="paid_by_val_<?=$i?>" value="cash"/>
                        <input type="hidden" name="cc_no[]" id="cc_no_val_<?=$i?>" value=""/>
                        <input type="hidden" name="cc_holder[]" id="cc_holder_val_<?=$i?>" value=""/>
                        <input type="hidden" name="cheque_no[]" id="cheque_no_val_<?=$i?>" value=""/>
                        <input type="hidden" name="cc_month[]" id="cc_month_val_<?=$i?>" value=""/>
                        <input type="hidden" name="cc_year[]" id="cc_year_val_<?=$i?>" value=""/>
                        <input type="hidden" name="cc_type[]" id="cc_type_val_<?=$i?>" value=""/>
                        <input type="hidden" name="cc_cvv2[]" id="cc_cvv2_val_<?=$i?>" value=""/>
                        <input type="hidden" name="payment_note[]" id="payment_note_val_<?=$i?>" value=""/>
                    <?php }
                    ?>
                    <input type="hidden" name="pos_note" value="" id="pos_note">
                    

                </div>
                <div style="clear:both; height:5px;"></div>
            </div>
        </div>
    </div>
    <?= form_close();?>
</div>

    <div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="payModalLabel"><?=lang('finalize_sale');?></h4>
            </div>
            <br>
            <div class="modal-body" id="payment_content">
                    <div class="col-md-9">
                        <div class="clearfir"></div>
                        <div id="payments">
                            <div class="well well-sm well_1">
                                <div class="payment">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="amount_1"><?=lang('amount');?></label>
                                                <input name="amount[]" type="text" id="amount_1"
                                                       class="pa form-control kb-pad1 amount"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-sm-offset-1">
                                            <div class="form-group">
                                                <label for="paid_by_1"><?=lang('paying_by');?></label>
                                                <select style="width: 100%" name="paid_by[]" id="paid_by_1" class="form-control paid_by">
                                                    <option disabled><?=lang('select_payment_method'); ?></option>
                                                        <option value="cash"><?=lang('cash'); ?></option>
                                                        <option value="CC"><?=lang('CC'); ?></option>
                                                        <option value="Cheque"><?=lang('cheque'); ?></option>
                                                        <option value="ppp"><?=lang('ppp'); ?></option>
                                                    	<option value="other"><?=lang('other'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <div class="pcc_1" style="display:none;">
                                                <!-- <div class="form-group">
                                                    <input type="text" id="swipe_1" class="form-control swipe"
                                                           placeholder="Swipe Your Card"/>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input name="cc_no[]" type="text" id="pcc_no_1"
                                                                   class="form-control"
                                                                   placeholder="<?= lang('cc_no');?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                                            <input name="cc_holer[]" type="text" id="pcc_holder_1"
                                                                   class="form-control"
                                                                   placeholder="<?= lang('cc_holder');?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select name="cc_type[]" id="pcc_type_1"
                                                                    class="form-control pcc_type"
                                                                    placeholder="<?=lang('card_type')?>">
                                                                <option value="Visa"><?= lang('Visa'); ?></option>
                                                                <option value="MasterCard"><?= lang('MasterCard'); ?></option>
                                                                <option value="Amex"><?= lang('Amex'); ?></option>
                                                                <option value="Discover"><?= lang('Discover'); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input name="cc_month[]" type="text" id="pcc_month_1"
                                                                   class="form-control"
                                                                   placeholder="<?= lang(
                                                                    'month'); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">

                                                            <input name="cc_year" type="text" id="pcc_year_1"
                                                                   class="form-control"
                                                                   placeholder="<?= lang(
                                                                    'year'); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">

                                                            <input name="cc_cvv2" type="text" id="pcc_cvv2_1"
                                                                   class="form-control"
                                                                   placeholder="<?= lang(
                                                                    'cvv2'); ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pcheque_1" style="display:none;">
                                                <div class="form-group"><?=lang('check_number');?>
                                                    <input name="cheque_no[]" type="text" id="cheque_no_1" class="form-control cheque_no"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?=lang('payment_note');?></label>
                                                <textarea name="payment_note[]" id="payment_note_1"
                                                          class="pa form-control kb-text payment_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="multi-payment"></div>
                        <button type="button" class="btn btn-primary col-md-12 addButton"><i
                                class="fa fa-plus"></i> <?=lang('add_more_payments');?></button>
                        <div style="clear:both; height:15px;"></div>
                        
                    </div>
                    <div class="col-md-2">
                        <div class="font16">
                            <table class="table table-bordered table-condensed table-striped" style="margin-bottom: 0;">
                                <tbody>
                                <tr>
                                    <td style="width: 25%;"><?= lang('quantity'); ?></td>
                                    <td style="width: 25%;" class="text-right"><span id="item_count">0.00</span></td>
                                <tr>
                                </tr>
                                    <td style="width: 25%;"><?= lang('total'); ?></td>
                                    <td style="width: 25%;" class="text-right"><span id="twt">0.00</span></td>
                                </tr>
                                <tr>
                                    <td width="25%"><?= lang('tpayments'); ?></td>
                                    <td style="width: 25%;" class="text-right"><span id="total_paying">0.00</span></td>
                                <tr>
                                </tr>
                                    <td style="width: 25%;"><?= lang('change'); ?></td>
                                    <td style="width: 25%;" class="text-right"><span id="balance">0.00</span></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                    	<div class="form-group">
		                    <label><?= lang('sale_note') ?></label>
		                    <textarea rows="4" name="sale_note" id="sale_note" class="form-control"></textarea>
		                </div>
                    </div>
                    
                    <!--  -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-block btn-lg btn-primary" id="submit-sale"><?=lang('submit');?></button>
            </div>
        </div>
    </div>
</div>
    
<div class="modal" id="prdModal" tabindex="-1" role="dialog" aria-labelledby="prdModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-2x">&times;</i></span><span class="sr-only"><?= lang('close') ?></span></button>
                <h4 class="modal-title" id="prdModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form id="discount_form" class="form-horizontal" role="form">
                    <div class="default">
                        <div class="form-group">
                            <label for="pdiscount" class="col-sm-4 control-label"><?= lang('discount') ?></label>
                            <div class="col-sm-8">
                                <div id="did-div"></div>
                                <div id="pdiscount-div">
                                	<input type="text" class="form-control"  name="discount_input" id="discount_input">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="pull-left btn btn-danger"><?= lang('cancel') ?></button>
                <button type="submit" id="discount_form_btn" class="btn btn-primary" form="discount_form"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div style="clear: both;"></div>
<style type="text/css">
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 0px 8px;
}
    .font16 { font-size: 16px; font-weight: bold; }
    .btn-pr {
        border: 1px solid #eee;
        cursor: pointer;
        height: 60px;
        margin: 0 0 3px 2px;
        padding: 2px;
        /*width: 10.5%;*/
        min-width: 100px;
        overflow: hidden;
        display: inline-block;
        font-size: 13px;
    }
    /*.btn-prni:hover {
        background: #eee;
        border: 1px solid #e5e5e5;
    }*/
    .btn-pr span {
        display: table-cell;
        height: 45px;
        line-height: 15px;
        vertical-align: middle;
        text-transform: uppercase;
        /*width: 10.5%;*/
        min-width: 94px;
        overflow: hidden;
    }
    /*.btn-prni:hover span {
        background: #eee;
    }*/
    .btn-pr.active { background: #eee; border: 1px solid #e5e5e5; cursor: default;  }
    /*#product-list { position: absolute; overflow: hidden; width: 100%; height: 410px; border-bottom: 1px solid #DDD; }
    #left-middle { position: relative; }*/
#posTable thead, #posTable tbody { display: block; }
#product-list #posTable tbody {
    height: 250px;          
    overflow-y: auto;    
}

#totalTable tbody tr{
    width: 100%;
    display: inline-table;
}
/* Hide HTML5 Up and Down arrows. */
input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
 
input[type="number"] {
    -moz-appearance: textfield;
}
</style>
<script type="text/javascript">
   
  <?php for ($i = 1; $i <= 5; $i++) {?>
        $('#paymentModal').on('change', '#amount_<?=$i?>', function (e) {
            $('#amount_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('blur', '#amount_<?=$i?>', function (e) {
            $('#amount_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#paid_by_<?=$i?>', function (e) {
            $('#paid_by_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_no_<?=$i?>', function (e) {
            $('#cc_no_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_holder_<?=$i?>', function (e) {
            $('#cc_holder_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_month_<?=$i?>', function (e) {
            $('#cc_month_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_year_<?=$i?>', function (e) {
            $('#cc_year_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_type_<?=$i?>', function (e) {
            $('#cc_type_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_cvv2_<?=$i?>', function (e) {
            $('#cc_cvv2_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#cheque_no_<?=$i?>', function (e) {
            $('#cheque_no_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#payment_note_<?=$i?>', function (e) {
            $('#payment_note_val_<?=$i?>').val($(this).val());
        });
        <?php }
        ?>

jQuery(document).ready( function($) {

    $('#paid_by_1, #pcc_type_1').select2({minimumResultsForSearch: 7});
    // Disable scroll when focused on a number input.
    $('form').on('focus', 'input[type=number]', function(e) {
        $(this).on('wheel', function(e) {
            e.preventDefault();
        });
    });

    // Restore scroll on number inputs.
    $('form').on('blur', 'input[type=number]', function(e) {
        $(this).off('wheel');
    });
 
    // Disable up and down keys.
    $('form').on('keydown', 'input[type=number]', function(e) {
        if ( e.which == 38 || e.which == 40 )
            e.preventDefault();
    });  
      
});

    $('#cancel_edit').click(function () {
        event.preventDefault();
        var row = $('#' + $('#prow_id').val());
        var item_id = $('#prow_id').val();
        delete pitems[item_id];
        localStorage.setItem('pospitems', JSON.stringify(pitems));
        loadPOSpitems();
        $('#prModal').modal('hide');
    });

    $('#vcancel_edit').click(function () {
        event.preventDefault();
        var row = $('#' + $('#prvow_id').val());
        var item_id = $('#prvow_id').val();
        delete pitems[item_id];
        localStorage.setItem('pospitems', JSON.stringify(pitems));
        loadPOSpitems();
        $('#prvModal').modal('hide');
    });

    $("#add_pos_item").autocomplete({
        source: function(request, response) {
            var id = $("ul#products-tab li.active a").attr('id');
            var value = $('#add_pos_item').val();
            $.getJSON('<?= site_url('panel/pos/suggestions'); ?>', { type: id, term: value }, response);
        },
        minLength: 1,
        delay: 250,
        autoFocus: true,
        select: function( event, ui ) {
            $( "#id_city" ).val( ui.item.id );
            $(this).closest('form').submit();
        },
        focus: function( event, ui ) { event.preventDefault(); },
        select: function (event, ui) {
            event.preventDefault();
            if (ui.item.id !== 0) {
                var row = add_pos_product_item(ui.item);
                if (row)
                    $(this).val(''); 
            } else {
                if (row)
                    $(this).val(''); 
            }
        }
    });
    function loadPOSpitems(edit_pitems = true) {
        if (localStorage.getItem('pospitems')) {
            pitems = JSON.parse(localStorage.getItem('pospitems'));
            var pp = 0;
            var total_tax = 0;
            total = 0;
            count = 1;
            an = 1;
            product_tax = 0;
            invoice_tax = 0;
            product_discount = 0;
            order_discount = 0;
            total_discount = 0;


            $("#posTable tbody").empty();
            $.each(pitems, function () {
                var row_no = this.item_id;
                var item_id = this.item_id;
                var unit_price = this.price;
                var cost = this.cost;
                var discount = this.discount;
                var code = this.code;
                var type = this.type;
                var item_ds = this.discount ? (this.discount).toString() : '0';
                var item_qty = this.qty;
                var product_tax = 0;
                item_tax_method = this.tax_method

               	var ds = item_ds ? item_ds : '0';
	            if (ds.indexOf("%") !== -1) {
	                var pds = ds.split("%");
	                if (!isNaN(pds[0])) {
	                    item_discount = formatDecimal((parseFloat(((unit_price) * parseFloat(pds[0])) / 100)), 4);
	                } else {
	                    item_discount = formatDecimal(ds);
	                }
	            } else {
	                 item_discount = formatDecimal(ds);
	            }
	            product_discount += formatDecimal(item_discount * item_qty);
	            unit_price = formatDecimal(unit_price-item_discount);
	            var pr_tax = this.tax_rate;
	            var pr_tax_val = 0, pr_tax_rate = 0;
                // if (pr_tax !== false && pr_tax != 0) {
                //     if (pr_tax.type == 1) {
                //         if (item_tax_method == '0') {
                //             pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)), 4);
                //             pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                //         } else {
                //             pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / 100, 4);
                //             pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                //         }

                //     } else if (pr_tax.type == 2) {

                //         pr_tax_val = formatDecimal(pr_tax.rate);
                //         pr_tax_rate = pr_tax.rate;

                //     }
                //     product_tax += pr_tax_val * item_qty;
                // }
	            item_price = item_tax_method == 0 ? formatDecimal((unit_price-pr_tax_val), 4) : formatDecimal(unit_price);

	            unit_price = formatDecimal((unit_price+item_discount), 4);
                invoice_tax += product_tax;
                var subtotal = formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)));

                var newTr = $('<tr id="row_' + row_no + '" class="item_' + this.item_id + '" data-item-id="' + row_no + '"></tr>');
                tr_html = '<td style="width: 35%;"><input name="item_id[]" id="item_id" type="hidden" value="' + item_id + '"><input name="subtotal[]" id="p_subtotal" type="hidden" value="' + subtotal + '"><input name="item_discount[]" id="item_discount" type="hidden" value="' + product_discount + '"><input name="item_type[]" id="item_type" type="hidden" value="' + type + '"><input name="item_cost[]" id="item_cost" type="hidden" value="' + cost + '"><input name="item_name[]" type="hidden" value="' + this.name + '"><input name="item_code[]" type="hidden" value="' + code + '"><span class="sname" id="name_' + row_no + '">' + code +' - '+ this.name + '</span>';
                tr_html += ' <button id="' + row_no + '" data-item="' + item_id + '" data-price="' + item_price + '" title="Edit" style="cursor:pointer;" class="discount btn btn-xs btn-primary"><i class="fas fa-cut" aria-hidden="false"><i></button>';
                tr_html += '</td>';
                tr_html += '<td style="width: 15%;"><input class="form-control text-center rquantity" name="item_qty[]" type="number" value="' + (item_qty) + '" data-id="' + row_no + '" data-item="' + this.item_id + '" id="item_price_' + row_no + '"></td>';
                tr_html += '<td style="width: 15%;">'+formatMoney(item_price)+'<input class="form-control text-center" name="unit_price[]" type="hidden" value="' + (unit_price) + '"><input class="form-control text-center rprice" name="item_price[]" type="hidden" value="' + (item_price) + '" data-id="' + row_no + '" data-item="' + this.item_id + '" id="item_price_' + row_no + '" onClick="this.select();"></td>';
                // tr_html += '<td style="width: 10%;">'+formatMoney(product_tax)+'<input class="form-control text-center rtax" name="item_tax[]" type="hidden" value="' + formatPOSDecimal(product_tax) + '" data-id="' + row_no + '" data-item="' + this.item_id + '" id="item_price_' + row_no + '" onClick="this.select();"><input class="form-control text-center" name="item_tax_id[]" type="hidden" value="' + (pr_tax.id) + '"></td>';
                tr_html += '<td style="width: 10%;">'+formatMoney(product_discount)+'</td>';
                tr_html += '<td style="width: 20%;">'+formatMoney((subtotal))+'</td>';
                if (edit_pitems) {
                    tr_html += '<td style="width: 5%;" class="text-center"><i class="fa fa-times tip del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                }else{
                    tr_html += '<td style="width: 5%;" class="text-center">-</td>';
                }
                newTr.html(tr_html);
                newTr.prependTo("#posTable");
                total += parseFloat(subtotal);
                count += 1;
                an++;
                pp += (parseFloat(item_price));
                total_tax += parseFloat(product_tax);
                total_discount += parseFloat(product_discount);
                $('.item_' + item_id).addClass('warning');

            });
	
            total = formatPOSDecimal(total);
            var gtotal = (parseFloat(total));
            $('#subtotal').text(formatMoney(total-total_tax));
            $('#tpitems').text((an - 1));
            $('#total_pitems').val((parseFloat(count) - 1));
            $('#tds').text(formatMoney(total_discount));
            $('#ttax2').text(formatMoney(invoice_tax));
            $('#gtotal').text(formatMoney(gtotal));
            $('#gtotal').val(Math.abs(gtotal));
            
        }
    }
    
    $('#payment').click(function () {
        if ($('#poscustomer').val() == '' || $('#poscustomer').val() == null) {
            bootbox.alert('<?=lang('select_pos_Client'); ?>');
            return;
        } else {
            if (typeof count === 'undefined') {
                bootbox.alert('<?=lang('add_product_before_checkout'); ?>');
                return false;
            }
            var twt = formatDecimal(((total + invoice_tax) - order_discount));
            gtotal = formatDecimal(twt);
            if (gtotal < 0) {
                bootbox.alert('<?=lang('checkout_negative'); ?>>');
                return;
            }
            $('#twt').text($('#gtotal').html());
            $('#item_count').text(count - 1);
            $('#paymentModal').appendTo("body").modal('show');
            $('#amount_1').focus();
        }
    });
       /* --------------------------
     * Edit Row Quantity Method
    --------------------------- */
    var old_row_qty;
    $(document).on("focus", '.rquantity', function () {
        old_row_qty = $(this).val();
    }).on("change", '.rquantity', function () {
    	if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert('Unexpected Value');
            return;
        }
        var row = $(this).closest('tr');
        var new_qty = parseFloat($(this).val()),
        item_id = row.attr('data-item-id');
        item = pitems[item_id];
        if (item.type == 'service') {
            pitems[item_id].qty = new_qty;
        }else{
            if (new_qty <= item.quantity) {
                pitems[item_id].qty = new_qty;
            }else{
                $(this).val(old_row_qty);
                pitems[item_id].qty = old_row_qty;
                bootbox.alert('<?=lang('stock_error'); ?> '+item.quantity);
                return;
            }
        }
       
        localStorage.setItem('pospitems', JSON.stringify(pitems));
        loadPOSpitems();
    });
    function formatCNum(x) {
        if (site.settings.decimals_sep == ',') {
            var x = x.toString();
            var x = x.replace(",", ".");
            return parseFloat(x);
        }
        return x;
    }
    function calculateTotals() {
        gtotal = $('#gtotal').val();
        var total_paying = 0;
        var ia = $(".amount");
        $.each(ia, function (i) {
            var this_amount = formatCNum($(this).val() ? $(this).val() : 0);
            total_paying += parseFloat(this_amount);
        });
        $('#total_paying').text(formatMoney(total_paying));
       
        $('#balance').text(formatMoney(total_paying - gtotal));
        $('#balance_' + pi).val(formatDecimal(total_paying - gtotal));
        total_paid = total_paying;
        grand_total = gtotal;
	}
	$(document).on('blur', '#sale_note', function () {
	    localStorage.setItem('posnote', $(this).val());
	    $('#sale_note').val($(this).val());
	});

    $(document).on('click', '#submit-sale', function () {
        if (total_paid == 0 || total_paid < grand_total) {
            bootbox.confirm("<?=lang('paid_l_t_payable');?>", function (res) {
                if (res == true) {
                    $('#pos_note').val(localStorage.getItem('posnote'));
                    $('#pos-sale-form').submit();
                }
            });
            return false;
        } else {
            $('#pos_note').val(localStorage.getItem('posnote'));
            $('#pos-sale-form').submit();
        }
    });
  
    $(document).on('focus', '.amount', function () {
        pi = $(this).attr('id');
        calculateTotals();
    }).on('blur', '.amount', function () {
        calculateTotals();
    }).on('keyup', '.amount', function () {
        calculateTotals();
    });

    $(document).on('click', '.del', function () {
        var id = $(this).attr('id');
        var item = pitems[id];
        $(this).closest('#row_' + id).remove();
        delete pitems[id];
        if(pitems.hasOwnProperty(id)) { } else {
            localStorage.setItem('pospitems', JSON.stringify(pitems));
            loadPOSpitems();
            return;
        }
    });
    
    pitems = {};
    function add_pos_product_item(item, edit_item=true) {
        if (item == null) {
            return false;
        }
        if (item.type == 'standard' && item.quantity < 1) {
        	bootbox.alert('<?= lang('pos_not_in_stock'); ?>');
        	return;
        }
        item_id = item.item_id;
        console.log(item);
        if (item.type == 'standard') {
            if (pitems[item_id]){
                item = pitems[item_id];
                if (item.qty < item.quantity) {
                    pitems[item_id].qty = parseInt(pitems[item_id].qty)+1;
                }else{
                    bootbox.alert('<?= lang('stock_error'); ?> '+item.quantity);
                    return;
                }
            }else{
                pitems[item_id] = item;
            } 
        }else{
            if (pitems[item_id]){
                pitems[item_id].qty = pitems[item_id].qty+1;
            }else{
                pitems[item_id] = item;
            } 
        }
        

        localStorage.setItem('pospitems', JSON.stringify(pitems));
        loadPOSpitems(edit_item);
        return true;
    }


    $(document).on('click', '.btn-pr', function (e) {
        e.preventDefault();
        code = $(this).val(),
        type = $(this).data('type'),
        $.ajax({
            type: "get",
            url: "<?=site_url('panel/pos/getProductDataByTypeAndID')?>",
            data: {code: code, type: type},
            dataType: "json",
            success: function (data) {
                // e.preventDefault();
                if (data !== null) {
                    $.each(data, function () {
                        add_pos_product_item(this);
                    });
                } else {
                    bootbox.alert('<?= lang('no_match_found'); ?>');
                }
            }
        });
    });
    function addbyTypeAndID(type, code) {
        $.ajax({
            type: "get",
            url: "<?=site_url('panel/pos/getProductDataByTypeAndID')?>",
            data: {code: code, type: type},
            dataType: "json",
            success: function (data) {
                if (data !== null) {
                    $.each(data, function () {
                        add_pos_product_item(this);
                    });
                }
            }
        });
    }

    /* -----------------------
     * Edit Row Modal Hanlder
     ----------------------- */
    $(document).on('click', '.discount', function (event) {
        event.preventDefault();
        var row = $(this).closest('tr');
        var row_id = row.attr('id');
        item_id = row.attr('data-item-id');
        price = $(this).data('price');
        item = pitems[item_id];
        $('#prdModalLabel').text(item.name + ' (' + item.code + ')');
        $('#did-div').html('<input type="hidden" name="pdrow_id" id="pdrow_id" value="'+item_id+'"><input type="hidden" name="price_dd" id="price_dd" value="'+price+'"><input type="hidden" id="ptypeid" name="ptypeid" data-id="'+item.item_id+'" data-type="'+item.type+'">');
        $('#prdModal').appendTo("body").modal('show');
    });
    

    $("#discount_form").submit(function( event ) {
        event.preventDefault();
        var item = pitems[item_id];
        var discount = $('#discount_input').val() ? parseFloat($('#discount_input').val()) : '0';
        pitems[item_id].discount = discount;
        localStorage.setItem('pospitems', JSON.stringify(pitems));
        $('#prdModal').modal('hide');
        loadPOSpitems();
        return;
    });
  
    function formatPOSDecimal(x, d) {
        if (!d) { d = 2; }
        return accounting.formatMoney(x, '', 2, '', '.', "%s%v");
    }


    $(document).on('change', '.paid_by', function () {
        var p_val = $(this).val(),
            id = $(this).attr('id'),
            pa_no = id.substr(id.length - 1);
        $('#rpaidby').val(p_val);
        if (p_val == 'cash' || p_val == 'other') {
            $('.pcheque_' + pa_no).slideUp();
            $('.pcc_' + pa_no).slideUp();
            $('.pcash_' + pa_no).slideDown();
            $('#payment_note_' + pa_no).focus();
        } else if (p_val == 'CC') {
            $('.pcheque_' + pa_no).slideUp();
            $('.pcash_' + pa_no).slideUp();
            $('.pcc_' + pa_no).slideDown();
            $('#swipe_' + pa_no).focus();
        } else if (p_val == 'Cheque') {
            $('.pcc_' + pa_no).slideUp();
            $('.pcash_' + pa_no).slideUp();
            $('.pcheque_' + pa_no).slideDown();
            $('#cheque_no_' + pa_no).focus();
        } else {
            $('.pcheque_' + pa_no).slideUp();
            $('.pcc_' + pa_no).slideUp();
            $('.pcash_' + pa_no).slideUp();
        }
    });

    $('#paymentModal').on('shown.bs.modal', function(e){
        $('#amount_1').focus();
    });
    var pi = 'amount_1', pa = 2;
    $(document).on('click', '.addButton', function () {
        if (pa <= 5) {
            $('#paid_by_1, #pcc_type_1').select2('destroy');
            var phtml = $('#payments').html(),
                update_html = phtml.replace(/_1/g, '_' + pa);
            pi = 'amount_' + pa;
            $('#multi-payment').append('<button type="button" class="close close-payment" style="margin: -10px 0px 0 0;"><i class="fa fa-2x">&times;</i></button>' + update_html);
            $('#paid_by_1, #pcc_type_1, #paid_by_' + pa + ', #pcc_type_' + pa).select2({minimumResultsForSearch: 7});
            pa++;
        } else {
            bootbox.alert('<?= lang('max_allowed_limit_reached'); ?>.');
            return false;
        }
        $('#paymentModal').css('overflow-y', 'scroll');
    });

    $(document).on('click', '.close-payment', function () {
        $(this).next().remove();
        $(this).remove();
        pa--;
    });

    // clear localStorage and reload
    $('#reset').click(function (e) {
        bootbox.confirm("<?= lang('r_u_sure'); ?>", function (result) {
            if (result) {
                if (localStorage.getItem('pospitems')) {
                    localStorage.removeItem('pospitems');
                }
                if (localStorage.getItem('poscustomer')) {
                    localStorage.removeItem('poscustomer');
                }
                //location.reload();
                window.location.href = site.base_url+"panel/pos";
            }
        });
    });
// If there is any item in localStorage
if (localStorage.getItem('pospitems')) {
    loadPOSpitems();
}
var pro_limit = "<?=$pos_settings->products_per_page?>", p_page = 0, per_page = 0, tcp = "<?=$tcp?>",cat_id = 0, ocat_id = 0, sub_cat_id = 0, osub_cat_id;

function selectCategory(category_id, parent) {
    var catname = $('#cat_id_'+category_id).text();
    if (parent) {
        $('#rhead').append(" <i class='fa fa-hand-o-right' style='color:#00C0EF'></i><span id='category_title' data-num='"+category_id+"'>"+ catname +"</span>");
    }else{
        $('#rhead').append(" <i class='fa fa-hand-o-right' style='color:#00C0EF'></i><span>"+ catname +"</span>");
    }
    url = "<?=site_url('panel/pos/getSubCategories/')?>";
    if (!parent) {
        url = "<?=site_url('panel/pos/getProductsByCategory/')?>";
    }
    $.ajax({
        type: "get",
        url: url+category_id,
        dataType: "json",
        success: function (data) {
            $('#gridbox').html(data.products);
            p_page = 'n';
            tcp = data.tcp;
            cat_id = data.cat_id;
            sub_cat_id = data.sub_cat_id;
            nav_pointer();
        }
    });
}
function getCategories() {
    $('#rhead').html("<a onclick='getCategories()'><?= lang('pos'); ?></a>");
    $.ajax({
        type: "get",
        url: "<?=site_url('panel/pos/getCategories/')?>",
        dataType: "json",
        success: function (data) {
            $('#gridbox').html(data.products);
            p_page = 'n';
            tcp = data.tcp;
            cat_id = data.cat_id;
            sub_cat_id = data.sub_cat_id;
            nav_pointer();
        }
    });
}

$(document).on('click', '#category_title', function (e) {
    title = $(this).html();
    id = $(this).data('num'),
    $('#rhead').html("<a onclick='getCategories()'><?= lang('pos'); ?></a>"+" <i class='fa fa-hand-o-right' style='color:#00C0EF'></i><span id='category_title' data-num='"+id+"'>"+ title + "</span>");
    e.preventDefault();
    $.ajax({
        type: "get",
        url: "<?=site_url('panel/pos/getSubCategories/')?>"+id,
        dataType: "json",
        success: function (data) {
            $('#gridbox').html(data.products);
            p_page = 'n';
            tcp = data.tcp;
            cat_id = data.cat_id;
            sub_cat_id = data.sub_cat_id;
            nav_pointer();
        }
    });
});

function addProduct(id) {
    $.ajax({
        type: "get",
        url: "<?=site_url('panel/pos/getProductByID/')?>"+id,
        dataType: "json",
        success: function (data) {
            if (data !== null) {
                $.each(data, function () {
                    add_pos_product_item(this);
                });
            } else {
                bootbox.alert('<?= lang('no_match_found'); ?>');
            }
        }
    });
}

$('#next').click(function () {
    if (p_page == 'n') {
        p_page = 0
    }
    p_page = p_page + pro_limit;
    if (tcp >= pro_limit && p_page < tcp) {
        $('#modal-loading').show();
        $.ajax({
            type: "get",
            url: "<?=base_url('panel/pos/ajaxproducts');?>",
            data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
            dataType: "html",
            success: function (data) {
                $('#item-list').empty();
                var newPrs = $('<div></div>');
                newPrs.html(data);
                newPrs.appendTo("#item-list");
                nav_pointer();
            }
        }).done(function () {
            $('#modal-loading').hide();
        });
    } else {
        p_page = p_page - pro_limit;
    }
});

$('#previous').click(function () {
    if (p_page == 'n') {
        p_page = 0;
    }
    if (p_page != 0) {
        $('#modal-loading').show();
        p_page = p_page - pro_limit;
        if (p_page == 0) {
            p_page = 'n'
        }
        $.ajax({
            type: "get",
            url: "<?=base_url('panel/pos/ajaxproducts');?>",
            data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
            dataType: "html",
            success: function (data) {
                $('#item-list').empty();
                var newPrs = $('<div></div>');
                newPrs.html(data);
                newPrs.appendTo("#item-list");
                nav_pointer();
            }

        }).done(function () {
            $('#modal-loading').hide();
        });
    }
});

$("#add_pos_item").autocomplete({
    source: function (request, response) {
        if (!$('#poscustomer').val()) {
            $('#add_pos_item').val('').removeClass('ui-autocomplete-loading');
            bootbox.alert('<?=lang('select_customer');?>');
            $('#add_pos_item').focus();
            return false;
        }
        $.ajax({
            type: 'get',
            url: '<?=base_url('panel/pos/suggestions');?>',
            dataType: "json",
            data: {
                term: request.term,
                customer_id: $("#poscustomer").val()
            },
            success: function (data) {
                $(this).removeClass('ui-autocomplete-loading');
                response(data);
            }
        });
    },
    minLength: 1,
    autoFocus: false,
    delay: 250,
    response: function (event, ui) {
        if ($(this).val().length >= 16 && ui.content[0].id == 0) {
            bootbox.alert('<?=lang('no_match_found')?>', function () {
                $('#add_pos_item').focus();
            });
            $(this).val('');
        }
        else if (ui.content.length == 1 && ui.content[0].id != 0) {
            ui.item = ui.content[0];
            $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
            $(this).autocomplete('close');
        }
        else if (ui.content.length == 1 && ui.content[0].id == 0) {
            bootbox.alert('<?=lang('no_match_found')?>', function () {
                $('#add_pos_item').focus();
            });
            $(this).val('');

        }
    },
    select: function (event, ui) {
        event.preventDefault();
        if (ui.item.id !== 0) {
            var row = add_pos_product_item(ui.item);
            if (row)
                $(this).val('');
        } else {
            bootbox.alert('<?=lang('no_match_found')?>');
        }
    }
});

function nav_pointer() {
    var pp = p_page == 'n' ? 0 : parseInt(p_page);
    (pp == 0) ? $('#previous').attr('disabled', true) : $('#previous').attr('disabled', false);
    ((pp+pro_limit) > parseInt(tcp)) ? $('#next').attr('disabled', true) : $('#next').attr('disabled', false);
}
</script>

<div class="modal modal-primary fade" id="myCashModal" tabindex="-1" role="dialog" aria-labelledby="myCashModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal modal-primary fade" id="myCDrawerModal" tabindex="-1" role="dialog" aria-labelledby="myCDrawerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
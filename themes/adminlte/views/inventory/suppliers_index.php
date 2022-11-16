<script>
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": <?=$settings->rows_per_page; ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?=base_url(); ?>panel/inventory/getAllSuppliers',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            ],
           
        });
              
    });


    jQuery(document).on("click", "#delete", function () {
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/inventory/delete_supplier",
            data: "id=" + encodeURI(num),
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
                toastr['success']("<?= lang('deleted');?>: ", "<?= lang('supplier_deleted'); ?>");
                $('#dynamic-table').DataTable().ajax.reload();
            }
        });
    });


</script>

<!-- ============= MODAL MODIFICA supplierI ============= -->
<div class="modal fade" id="suppliermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titsupplieri"></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <p class="tips custip"></p>
                    <div class="row">
                        <form id="suppliers_form" class="col s12">
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_name', 'suppliers_name'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-user"></i>
                                        </div>
                                        <input id="suppliers_name" name="name" type="text" class="validate form-control" required>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_company', 'suppliers_company'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-user"></i>
                                        </div>
                                        <input id="suppliers_company" name="company" type="text" class="validate form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <?= lang('supplier_address', 'suppliers_address'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-road"></i>
                                        </div>
                                        <input id="suppliers_address" name="address" type="text" class="validate form-control">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_city', 'suppliers_city'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-globe"></i>
                                        </div>
                                        <input id="suppliers_city" name="city" type="text" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_country', 'suppliers_country'); ?>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-envelope"></i>
                                        </div>
                                        <input id="suppliers_country" name="country" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_state', 'suppliers_state'); ?>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-envelope"></i>
                                        </div>
                                        <input id="suppliers_state" name="state" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_postal_code', 'suppliers_postal_code'); ?>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-envelope"></i>
                                        </div>
                                        <input id="suppliers_postal_code" name="postal_code" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_phone', 'suppliers_phone'); ?>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-phone"></i>
                                        </div>
                                        <input id="suppliers_phone" type="text" name="phone" class="validate form-control" data-mask="(999) 999-9999">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_email', 'suppliers_email'); ?>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-envelope"></i>
                                        </div>
                                        <input id="suppliers_email" type="email" name="email" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('supplier_vat', 'suppliers_vat_no'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-envelope"></i>
                                        </div>
                                        <input id="suppliers_vat_no" name="vat_no" class="validate form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
            <div class="modal-footer" id="footersupplier1">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>


<!-- ============= MODAL View supplier ============= -->
<div class="modal fade" id="view_supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><div id="titlesupplier"></div></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="row">
                        
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> <?= lang('supplier_name'); ?> </span><span id="vs_name"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> <?= lang('supplier_company'); ?> </span><span id="vs_company"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-road"></i> <?= lang('supplier_address'); ?></span><span id="vs_address"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-globe"></i> <?= lang('supplier_city'); ?></span><span id="vs_city"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-phone"></i> <?= lang('supplier_country'); ?> </span><span id="vs_country"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> <?= lang('supplier_state'); ?> </span><span id="vs_state"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-barcode"></i> <?= lang('supplier_postal_code'); ?> </span><span id="vs_postal_code"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('supplier_phone'); ?> </span><span id="vs_phone"></span></p>
                        </div>
                        
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('supplier_email'); ?> </span><span id="vs_email"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-6 bio-row">
                            <p><span class="bold"><i class="fa fa-quote-left"></i> <?= lang('supplier_vat'); ?> </span><span id="vs_vat_no"></span></p>
                        </div>

                    </div>
                   
                </div>
            </div>
            <div class="modal-footer" id="footersupplier"></div>
        </div>
    </div>
</div>

<?php if($this->Admin || $GP['inventory-add_supplier']): ?>
<button href="#suppliermodal" class="add_supplier btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('supplier_title'); ?>
</button>
<?php endif; ?>

<!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="panel">


                    
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="display compact table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <th><?= lang('supplier_name'); ?></th>
                                        <th><?= lang('supplier_company'); ?></th>
                                        <th><?= lang('supplier_phone'); ?></th>
                                        <th><?= lang('supplier_email'); ?></th>
                                        <th><?= lang('supplier_city'); ?></th>
                                        <th><?= lang('supplier_country'); ?></th>
                                        <th><?= lang('supplier_vat'); ?></th>
                                        <th><?= lang('actions'); ?></th>
                                        
                                    </tr>
                                </thead>
                        
                                <tfoot>
                                    <tr>
                                        <th><?= lang('supplier_name'); ?></th>
                                        <th><?= lang('supplier_company'); ?></th>
                                        <th><?= lang('supplier_phone'); ?></th>
                                        <th><?= lang('supplier_email'); ?></th>
                                        <th><?= lang('supplier_city'); ?></th>
                                        <th><?= lang('supplier_country'); ?></th>
                                        <th><?= lang('supplier_vat'); ?></th>
                                        <th><?= lang('actions'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
        </div>
    </section>
<script type="text/javascript">
    jQuery(document).on("click", ".view", function () {
        var num = jQuery(this).data("num");
        find(num);

    });

    if (getUrlVars()["id"]) {
        find(getUrlVars()["id"]);
        $('#view_supplier').modal('show');
    }


    jQuery(".add_supplier").on("click", function (e) {
        $('#suppliermodal').modal('show');

        $('#suppliers_form').trigger("reset");
        $('#suppliers_form').parsley().reset();

        jQuery('#titsupplieri').html('<?= lang("add"); ?> <?= lang("supplier_title"); ?>');

        jQuery('#footersupplier1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang("go_back"); ?></button><button id="submit" role="button" form="suppliers_form" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> <?= lang("add"); ?> <?= lang("supplier_title"); ?></button>');
    });

    jQuery(document).on("click", "#modify_supplier", function () {
        jQuery('#titsupplieri').html('<?= lang("edit"); ?> <?= lang("supplier_title"); ?>');
        var num = jQuery(this).data("num");
        jQuery.ajax({
                type: "POST",
                url: base_url + "panel/inventory/getSupplierByID",
                data: "id=" + encodeURI(num) + "&token=<?=$_SESSION['token'];?>",
                cache: false,
                dataType: "json",
                success: function (data) {
                    $('#suppliers_form').trigger("reset");
                    $('#suppliers_form').parsley().reset();
                    jQuery('#suppliers_name').val(data.name);
                    jQuery('#suppliers_company').val(data.company);
                    jQuery('#suppliers_address').val(data.address);
                    jQuery('#suppliers_city').val(data.city)
                    jQuery('#suppliers_country').val(data.country);
                    jQuery('#suppliers_state').val(data.state)
                    jQuery('#suppliers_postal_code').val(data.postal_code);
                    jQuery('#suppliers_phone').val(data.phone);
                    jQuery('#suppliers_email').val(data.email);
                    jQuery('#suppliers_vat_no').val(data.vat_no);

                    jQuery('#footersupplier1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang("go_back"); ?></button><button id="submit" role="button" form="suppliers_form" class="btn btn-success" data-mode="modify" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i>  <?= lang("save"); ?> <?= lang("supplier_title"); ?></button>')
                }
            });
        });

    $('#suppliers_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
      }).on('form:submit', function(event) {
        var mode = jQuery('#submit').data("mode");
        var id = jQuery('#submit').data("num");
        var name = jQuery('#suppliers_name').val();
        var company = jQuery('#suppliers_company').val();
        var url = "";
        var dataString = "";

        if (mode == "add") {
            url = base_url + "panel/inventory/add_supplier";
            dataString = $('#suppliers_form').serialize();
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success']("<?= lang('edit'); ?>", "<?= lang('supplier_title'); ?> " + name + " " + company + " <?= lang('added'); ?>");
                    setTimeout(function () {
                        $('#suppliermodal').modal('hide');
                        find(data);
                        $('#dynamic-table').DataTable().ajax.reload();
                        $('#view_supplier').modal('show');
                    }, 500);
                }
            });
        } else {
            url = base_url + "panel/inventory/edit_supplier";
            dataString = $('#suppliers_form').serialize() + "&id=" + encodeURI(id);
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success']("<?= lang('edit'); ?>", "<?= lang('supplier_title'); ?>: " + name + " " + company + "<?= lang('updated'); ?>");
                    setTimeout(function () {
                        $('#suppliermodal').modal('hide');
                        find(id);
                        $('#dynamic-table').DataTable().ajax.reload();
                        $('#view_supplier').modal('show');

                    }, 500);
                }
            });
        }
        return false;
    });

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars;
}
function find(num) {
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/inventory/getSupplierByID",
            data: "id=" + encodeURI(num) + "&token=<?=$_SESSION['token'];?>",
            cache: false,
            dataType: "json",
            success: function (data) {
                if (typeof data.name === 'undefined') {
                    $('#view_supplier').modal('hide');
                    toastr['error']('<?= lang("no"); ?> <?= lang("supplier_title"); ?>', '');
                } else {
                    jQuery('#titlesupplier').html('supplier: ' + data.name);
                    jQuery( ".flatb.add" ).data( "name", data.name+' '+data.company);
                    jQuery( ".flatb.add" ).data( "id_name", data.id);
                    jQuery( ".flatb.lista" ).data( "name", data.name+' '+data.company);
                    jQuery('#vs_name').html(data.name);
                    jQuery('#vs_company').html(data.company);
                    jQuery('#vs_address').html(data.address);
                    jQuery('#vs_city').html(data.city)
                    jQuery('#vs_country').html(data.country);
                    jQuery('#vs_state').html(data.state)
                    jQuery('#vs_postal_code').html(data.postal_code);
                    jQuery('#vs_phone').html(data.phone);
                    jQuery('#vs_email').html(data.email);
                    jQuery('#vs_vat_no').html(data.vat_no);

                    var string = "<button data-dismiss=\"modal\" class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-reply\"></i> <?= lang('go_back'); ?></button>";

                    <?php if($this->Admin || $GP['inventory-delete_supplier']): ?>
                        string += "<button id=\"delete\" data-dismiss=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-danger\" type=\"button\"><i class=\"fa fa-trash-o \"></i> <?= lang('delete'); ?></button>";
                    <?php endif; ?>
                    <?php if($this->Admin || $GP['inventory-edit_supplier']): ?>
                        string += "<button data-dismiss=\"modal\" id=\"modify_supplier\" href=\"#suppliermodal\" data-toggle=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-success\"><i class=\"fa fa-pencil\"></i> <?= lang('modify'); ?></button>";
                    <?php endif; ?>


                    jQuery('#footersupplier').html(string);
                }
            }
        });
    }
    
</script>
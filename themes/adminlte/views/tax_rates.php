<script>
function type(x) {
    if (x == 1) {
        return "Percentage";
    }
    if (x == 2) {
        return "Fixed";
    }
}
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": <?=$settings->rows_per_page; ?>,
            'bProcessing': true, 'bServerSide': false,
            'sAjaxSource': '<?=base_url(); ?>panel/settings/tax_rates/getAll',
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
            {"mRender": type },
            null,
            ],
           
        });
              
    });


    jQuery(document).on("click", "#delete", function () {
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/settings/tax_rates/delete",
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
                toastr['success']("<?=lang('deleted');?>: ", "<?= lang('taxrate_deleted'); ?>");
                $('#dynamic-table').DataTable().ajax.reload();
            }
        });
    });

</script>

<!-- ============= MODAL MODIFICA supplierI ============= -->
<div class="modal fade" id="taxmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <form class="col s12" id="tax_form">
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('tax_name', 'tax_name'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-user"></i>
                                        </div>
                                        <input id="tax_name" name="name" type="text" class="validate form-control" required>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 input-field">
                                <div class="form-group">
                                    <?= lang('tax_code', 'tax_code'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-user"></i>
                                        </div>
                                        <input id="tax_code" name="code" type="text" class="validate form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <?= lang('tax_rate', 'tax_rate'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-road"></i>
                                        </div>
                                        <input data-parsley-type="number" id="tax_rate" required name="rate" type="text" class="validate form-control">
                                    </div>
                                    
                                </div>
                            </div>

							<div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <?= lang('tax_type', 'tax_type'); ?>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-road"></i>
                                        </div>
                                        <select id="tax_type" required name="type" class="validate form-control">
                                            <option value="1">Percentage</option>
                                            <option value="2">Fixed</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>

                        </form>
                </div>
            </div>
            <div class="modal-footer" id="footertaxrate">
                  <!--    -->
            </div>
        </div>
    </div>
</div>
</div>


<?php if($this->Admin || $GP['tax_rates-add']): ?>
<button href="#taxmodal" class="add_taxrate btn btn-primary">
    <i class="fa fa-plus-circle"></i> <?= lang('add').' '.lang('taxrate_title'); ?>
</button>
<?php endif; ?>
<!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="panel">
                    <div class="panel-body">
                        <div class="adv-table">
                            <table class="display compact table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <th><?= lang('tax_name'); ?></th>
                                        <th><?= lang('tax_code'); ?></th>
                                        <th><?= lang('tax_rate'); ?></th>
                                        <th><?= lang('tax_type'); ?></th>
                                        <th><?= lang('actions'); ?></th>
                                    </tr>
                                </thead>
                        
                                <tfoot>
                                    <tr>
                                        <th><?= lang('tax_name'); ?></th>
                                        <th><?= lang('tax_code'); ?></th>
                                        <th><?= lang('tax_rate'); ?></th>
                                        <th><?= lang('tax_type'); ?></th>
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



    jQuery(".add_taxrate").on("click", function (e) {
        $('#taxmodal').modal('show');
        $('#tax_form').trigger("reset");
        $('#tax_form').parsley().reset();
    
        jQuery('#titsupplieri').html("<?= lang('add').' '.lang('taxrate_title'); ?>");

        jQuery('#footertaxrate').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i><?= lang("go_back"); ?></button><button id="submit" class="btn btn-success" role="submit" form="tax_form" data-mode="add"><i class="fa fa-user"></i> <?= lang("add"); ?></button>');
    });

    jQuery(document).on("click", "#modify", function () {
        jQuery('#titsupplieri').html('Edit Tax Rate');
        $('#tax_form').trigger("reset");
        $('#tax_form').parsley().reset();
        var num = $(this).data('num');
            jQuery.ajax({
                type: "POST",
                url: base_url + "panel/settings/tax_rates/byID",
                data: "id=" + encodeURI(num) + "&token=<?=$_SESSION['token'];?>",
                cache: false,
                dataType: "json",
                success: function (data) {
                    jQuery('#tax_name').val(data.name);
                    jQuery('#tax_code').val(data.code);
                    jQuery('#tax_rate').val(data.rate);
                    jQuery('#tax_type').val(data.type)
                    jQuery('#footertaxrate').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> <?= lang("go_back"); ?></button><button id="submit" class="btn btn-success" data-mode="modify" role="submit" form="tax_form" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> <?= lang("save"); ?></button>')
                }
            });
        });


$(function () {
    $('#tax_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
    }).on('form:submit', function(event) {
        var mode = jQuery('#submit').data("mode");
        var id = jQuery('#submit').data("num");

        var name = jQuery('#tax_name').val();
        var code = jQuery('#tax_code').val();
        var rate = jQuery('#tax_rate').val();
        var type = jQuery('#tax_type').val();

        var url = "";
        var dataString = $('#tax_form').serialize();

        if (mode == "add") {
            url = base_url + "panel/settings/tax_rates/add";
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success']("<?= lang('add'); ?>", "<?= lang('taxrate_title'); ?>: " + name + " <?= lang('added'); ?>");
                    setTimeout(function () {
                        $('#taxmodal').modal('hide');
                        find(data);
                        $('#dynamic-table').DataTable().ajax.reload();
                    }, 500);
                }
            });
        } else {
            url = base_url + "panel/settings/tax_rates/edit";
            dataString =  dataString + "&id=" + encodeURI(id);
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success']("<?= lang('save'); ?>", "<?= lang('taxrate_title'); ?>: " + name + "<?= lang('updated'); ?>");
                    setTimeout(function () {
                        $('#taxmodal').modal('hide');
                        find(id);
                        $('#dynamic-table').DataTable().ajax.reload();
                    }, 500);
                }
            });
        }
        return false;
    });
});
    
</script>
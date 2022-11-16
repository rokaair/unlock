<script>
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": <?=$settings->rows_per_page; ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?=base_url(); ?>panel/customers/getAllCustomers',
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
            null
            ],
        });
    });

    jQuery(document).on("click", "#view_image", function (e) {
        e.preventDefault();
        image_name = $(this).data('num');
        if (image_name) {
            showImage('<?=base_url();?>assets/uploads/images/'+image_name);
        }else{
            bootbox.alert({
                message: '<?=lang('client_no_image');?>',
                backdrop: true
            });
        }
    });

    jQuery(document).on("click", "#delete_client", function () {
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/customers/delete",
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
                toastr['success']("<?= lang('deleted'); ?>: ", "<?= lang('client_deleted'); ?>");
                $('#dynamic-table').DataTable().ajax.reload();
            }
        });
    });
</script>

<?php if($this->Admin || $GP['customers-add']): ?>
    <button href="#clientmodal" class="add_c btn btn-primary">
        <i class="fa fa-plus-circle"></i> <?= lang('add'); ?> <?= lang('client_title'); ?>
    </button>

    <a href="<?= base_url('panel/customers/import_csv'); ?>" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-plus-circle"></i> <?= lang("import_customers_by_csv"); ?>
    </a>

<?php endif; ?>
<a href="<?= base_url('panel/customers/export'); ?>" class="btn btn-primary pull-right">
    <i class="fa fa-file-excel-o"></i> <?= lang("export_to_excel"); ?>
</a>
<!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="panel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="display compact table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <th><?= lang('client_name'); ?></th>
                                        <th><?= lang('client_company'); ?></th>
                                        <th><?= lang('client_telephone'); ?></th>
                                        <th><?= lang('client_telephone2'); ?></th>
                                        <th><?= lang('actions'); ?></th>
                                    </tr>
                                </thead>
                        
                                <tfoot>
                                    <tr>
                                        <th><?= lang('client_name'); ?></th>
                                        <th><?= lang('client_company'); ?></th>
                                        <th><?= lang('client_telephone'); ?></th>
                                        <th><?= lang('client_telephone2'); ?></th>
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
   

    if (getUrlVars()["id"]) {
        find_client(getUrlVars()["id"]);
        $('#view_client').modal('show');
    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }
</script>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        oTable = $('#CategoryTable').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= base_url('panel/settings/getCategories') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"bSortable": false, "mRender": checkbox}, {"bSortable": false, "mRender": img_hl}, null, null, null, {"bSortable": false}]
        });
    });
</script>
<?= form_open('panel/settings/category_actions', 'id="action-form"') ?>
<section class="content">
        <div class="row">
            <section class="panel">
                    <!-- Single button -->
                    <div class="btn-group">
                        <?php if($this->Admin || $GP['categories-add']): ?>
                            <a type="button" class="btn btn-danger" href="<?php echo base_url('panel/settings/add_category'); ?>" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i> <?= lang('add_category') ?>
                            </a>
                        <?php endif; ?>

                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        
                        <li>
                            <a href="<?php echo base_url('panel/settings/import_categories'); ?>" data-toggle="modal" data-target="#myModal">
                                <i class="fas fa-plus"></i> <?= lang('import_categories') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="excel" data-action="export_excel">
                                <i class="fas fa-file-excel"></i> <?= lang('export_to_excel') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="excel" data-action="export_pdf">
                                <i class="fas fa-file-pdf"></i> <?= lang('export_to_pdf') ?>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" id="delete" data-action="delete">
                                <i class="fas fa-trash"></i> <?= lang('delete_categories') ?>
                            </a>
                        </li>
                      </ul>
                    </div>
                   
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="CategoryTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th style="min-width:30px; width: 30px; text-align: center;">
                                            <input class="checkbox checkth" type="checkbox" name="check"/>
                                        </th>
                                        <th style="min-width:40px; width: 40px; text-align: center;">
                                            <?= lang("image"); ?>
                                        </th>
                                        <th><?= lang("category_code"); ?></th>
                                        <th><?= lang("category_name"); ?></th>
                                        <th><?= lang("parent_category"); ?></th>
                                        <th style="width:100px;"><?= lang("actions"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="dataTables_empty">
                                            <?= lang('loading_data_from_server') ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
        </div>
    </section>

<div style="display: none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<script language="javascript">
    $(document).ready(function () {

        $('#delete').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#excel').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#pdf').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

    });
</script>



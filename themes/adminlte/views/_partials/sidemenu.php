<ul class="sidebar-menu" data-widget="tree">
  
    <li class="header"><?=lang('main_nav_span');?></li>
    <?php foreach ($menu as $parent => $parent_params): ?>
        <?php if ( empty($page_auth[$parent_params['url']]) || $this->ion_auth->in_group($page_auth[$parent_params['url']]) ): ?>
            <?php if ( empty($parent_params['children']) ): ?>
                <?php if($this->Admin || (@$this->GP[str_replace('/', '-', $parent_params['name'])])): ?>
                    <?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
                    <li class='<?php if ($active) echo 'active'; ?>'>
                      <a href='<?= base_url();?>panel/<?php echo $parent_params['url']; ?>'>
                        <i class='<?php echo $parent_params['icon']; ?>'></i> 
                        <span><?php echo lang($parent_params['name']); ?></span>
                      </a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <?php $parent_active = ($ctrler==$parent); ?>
                 <li class="treeview <?php if ($parent_active) echo 'active'; ?>">
                  <a href="#">
                    <i class="<?php echo $parent_params['icon']; ?>"></i> <span><?php echo lang($parent_params['name']); ?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php foreach ($parent_params['children'] as $name => $url): ?>
                        <?php if($this->Admin || @$this->GP[str_replace('/', '-', $name)]): ?>
                            <?php $child_active = ($current_uri==$url); ?>
                            <li <?php if ($child_active) echo 'class="active"'; ?>><a href="<?= base_url();?>panel/<?php echo $url; ?>"><i class="far fa-circle"></i> <?php echo lang($name); ?></a></li>

                        <?php endif; ?>
                    <?php endforeach; ?>

                  </ul>
                </li>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
<!-- /.sidebar -->
</aside>
<!-- Modal -->
<div class="modal fade" id="sendSMSModal" role="dialog" aria-labelledby="sendSMSModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=lang('send_sms_label');?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="get" id="SendSMS">
      <div class="form-group">
          <?php $client_dp = array(); if($clients): foreach ($clients as $client) {
            if (is_numeric($client->telephone)) {
              $client_dp[$client->id] = $client->name;
            }
          } endif;
          ?>
          <?= form_dropdown('client_id', $client_dp, set_value('client_id'), 'class="form-control" style="width:100%;" id="client_id_sms"');?>
          </div>
          <div>
            <textarea required="" name="text" id="fastsms" class="textarea" placeholder="Message" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('close');?></button>
        <button type="submit" form="SendSMS" class="btn btn-primary" value="Submit"><?=lang('send');?></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="sendEmailModal" role="dialog" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=lang('send_email_label');?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" method="post" id="sendEmail">
                <div class="form-group">
                  <?php $client_dp = array(); if($clients): foreach ($clients as $client) {
                    if (filter_var($client->email, FILTER_VALIDATE_EMAIL)) {
                      $client_dp[$client->id] = $client->name;
                    }
                  }endif;
                  ?>
                  <?= form_dropdown('email_to[]', $client_dp, set_value('email_to'), 'class="form-control" multiple style="width:100%;"');?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="<?= lang('email_subject'); ?>">
                </div>
                <div>
                  <textarea name="body" id="sms_body" class="textarea" placeholder="<?= lang('email_body'); ?>" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('close');?></button>
        <button type="submit" form="sendEmail"  class="btn btn-primary"><?=lang('send');?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$("#sendEmail").submit(function(e) {
  e.preventDefault();
  $('#loadingmessage').show();  // show the loading message.
  emailto = jQuery('#emailto').val();
  subject = jQuery('#subject').val();
  body = jQuery('#body').val();
  jQuery.ajax({
    type: "POST",
    url: base_url + "panel/welcome/send_mail",
    data: $('#sendEmail').serialize(),
    cache: false,
    dataType: "json",
    success: function (data) {
      $('#loadingmessage').hide();
      if (data == 2) {
        toastr.info('<?= lang('field_empty'); ?>');
      }else if (data == 1) {
        toastr.success('<?= lang('email_sent'); ?>');
      }else{
        toastr.warning('<?= lang('email_not_sent'); ?>');
      }
      }
  });
});

$("#SendSMS").submit(function(e) {
  e.preventDefault();
  dta = $(this).serialize();
  jQuery.ajax({
      type: "POST",
      url: base_url + "panel/reparation/send_sms",
      data: dta,
      cache: false,
      dataType: "json",
      success: function(data) {
        if(data.status == true) {
            toastr.success('<?= lang('sms_sent'); ?>');
        } else{
            toastr.warning('<?= lang('sms_not_sent'); ?>');
        }
      }  
  });
});


</script>
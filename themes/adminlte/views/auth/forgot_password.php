<div class="login-box">
  <div class="login-logo"><img width="360px" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>"></div>

  <div class="login-box-body">
    <p class="login-box-msg"><?php echo lang('forgot_password_heading');?></p>


      <div class="<?= $message ? 'alert alert-info' : ''; ?>" id=" infoMessage"><?php echo $message;?></div>
        <?php echo form_open("panel/login/forgot_password");?>

          <p>
            <label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
            <?php echo form_input($identity);?>
          </p>

        <div class="row">
           <?php if ($this->mSettings->enable_recaptcha): ?>
              <center>
                <?= $this->recaptcha->create_box(array('data-size'=>'compact')); ?>
                </center>
                <br>
            <?php endif; ?>

            <div class="col-xs-4 pull-right">
              <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary btn-block btn-flat"');?>
            </div>
        </div>


      <?php echo form_close();?>
  </div>
</div>

<script type="text/javascript">
<?php if ($this->mSettings->enable_recaptcha): ?>
window.onload = function() {
  var recaptcha = document.forms["login_form"]["g-recaptcha-response"];
  recaptcha.required = true;
  recaptcha.oninvalid = function(e) {
    alert("<?=lang('complete_captcha');?>");
  }
}
<?php endif; ?>
</script>
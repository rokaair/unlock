<style type="text/css">
    <?php if($settings->background): ?>
      .login-page {
        position: relative;
        /*opacity: 0.65;*/
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;

      }
      .login-page {
        background-image: url('<?= base_url(); ?>assets/uploads/backgrounds/<?= $settings->background;?>');
        height: 100%;
      }
    <?php endif; ?>
</style>
<div class="login-box">

  <div class="login-logo"><img width="360px" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>"></div>

  <div class="login-box-body">
    <p class="login-box-msg"><?php echo lang('login_subheading');?></p>

      <div id="infoMessage"><?php echo $message;?></div>
      <?php echo form_open("panel/login", 'id="login_form"');?>

        <div class="form-group has-feedback">
          <?php echo form_input($identity, '', "class='form-control' placeholder='".lang('login_identity_label')."'");?>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          
          <?php echo form_input($password, '', "class='form-control' placeholder='".lang('login_password_label')."'");?>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
           <?php if ($this->mSettings->enable_recaptcha): ?>
              <center>
                <?= $this->recaptcha->create_box(array('data-size'=>'compact')); ?>
                </center>
                <br>
            <?php endif; ?>
          <div class="col-xs-8">
          <label>
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><?php echo lang('login_remember_label');?></label>
          </div>
          <div class="col-xs-4">
            <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary btn-block btn-flat"');?>

          </div>
        </div>
        <a href="<?=base_url()?>panel/login/forgot_password">I forgot my password</a>

      <?php echo form_close();?>
  </div>
</div>

<script type="text/javascript">
$('#remember').iCheck({ checkboxClass: 'icheckbox_square-blue',
  radioClass: 'iradio_square-blue',
  increaseArea: '20%' 
});

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
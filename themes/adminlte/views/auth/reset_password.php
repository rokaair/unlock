<div class="login-box">
  <div class="login-logo"><img width="360px" src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>"></div>

  <div class="login-box-body">
    <p class="login-box-msg"><?php echo lang('reset_password_heading');?></p>


      <div class="<?= $message ? 'alert alert-info' : ''; ?>" id=" infoMessage"><?php echo $message;?></div>
        <?php echo form_open("panel/login/reset_password/". $code);?>

          	<p>
				<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
				<?php echo form_input($new_password);?>
			</p>

			<p>
				<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
				<?php echo form_input($new_password_confirm);?>
			</p>

			<?php echo form_input($user_id);?>
			<?php echo form_hidden($csrf); ?>


        <div class="row">
           <?php if ($this->mSettings->enable_recaptcha): ?>
              <center>
                <?= $this->recaptcha->create_box(array('data-size'=>'compact')); ?>
                </center>
                <br>
            <?php endif; ?>

            <div class="col-xs-4 pull-right">
              <?php echo form_submit('submit', lang('reset_password_submit_btn'), 'class="btn btn-primary btn-block btn-flat"');?>
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
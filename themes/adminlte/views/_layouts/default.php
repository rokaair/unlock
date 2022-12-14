<div class="wrapper">
	<?php if(!$settings->use_topbar): ?>
		<?php $this->load->view($this->theme . '_partials/navigation'); ?>
	<?php else: ?>
		<?php $this->load->view($this->theme . '_partials/navigation_top'); ?>
	<?php endif; ?>
	<?php // Left side column. contains the logo and sidebar ?>
	<?php if(!$settings->use_topbar): ?>
	<aside class="main-sidebar">
		<section class="sidebar">
			  <div class="user-panel">
		        <div class="pull-left image">
		          <img src="<?= base_url(); ?>assets/uploads/members/<?= $user->image; ?>" class="img-circle" alt="User Image">
		        </div>
		        <div class="pull-left info">
		          <p><?= $user->first_name.' '.$user->last_name; ?></p>
		          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		        </div>
		      </div>
			<?php // (Optional) Add Search box here ?>
			<?php $this->load->view($this->theme . '_partials/sidemenu_search'); ?>
			<?php $this->load->view($this->theme . '_partials/sidemenu'); ?>
		</section>
	</aside>
	<?php endif;?>

	<?php // Right side column. Contains the navbar and content of the page ?>
	<div class="content-wrapper" id="content-wrapper">
		<section class="content-header">
			<h1><?php echo $page_title; ?></h1>
			<?php //$this->load->view($this->theme . '_partials/breadcrumb'); ?>
		</section>
		<section class="content">
			<?php if (isset($_SESSION['message'])) { ?>
		      <div class="alert alert-success">
		          <button data-dismiss="alert" class="close" type="button">×</button>
		          <?= $_SESSION['message']; ?>
		      </div>
		  <?php } ?>
		  <?php if (isset($_SESSION['error'])) { ?>
		      <div class="alert alert-danger">
		          <button data-dismiss="alert" class="close" type="button">×</button>
		          <?= ($_SESSION['error']); ?>
		      </div>
		  <?php } ?>
		  <?php if (isset($_SESSION['warning'])) { ?>
		      <div class="alert alert-warning">
		          <button data-dismiss="alert" class="close" type="button">×</button>
		          <?= ($_SESSION['warning']); ?>
		      </div>
		  <?php } ?>

			<?php $this->load->view($this->theme . $inner_view); ?>
		</section>
	</div>

	<?php $this->load->view($this->theme . 'client_js');?>

	<?php // Footer ?>
	<?php $this->load->view($this->theme . '_partials/footer'); ?>

</div>
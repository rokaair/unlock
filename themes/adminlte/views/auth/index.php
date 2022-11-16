<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo lang('index_heading');?></h3><p><?php echo lang('index_subheading');?></p>
              <div class="box-tools">
                <div class="input-group input-group-sm pull-right">
                	<a class="btn btn-default" href="<?= base_url('panel/auth/create_user'); ?>"><?= lang('index_create_user_link'); ?></a>
                </div>
              </div>
            </div>
            <!-- /.box-header -->

            <div class="box-body table-responsive no-padding">
              <table cellpadding=0 cellspacing=10 class="table table-hover">
					<thead>
						<tr>
							<th><?php echo lang('index_fname_th');?></th>
							<th><?php echo lang('index_lname_th');?></th>
							<th><?php echo lang('index_email_th');?></th>
							<th><?php echo lang('index_groups_th');?></th>
							<th><?php echo lang('index_status_th');?></th>
							<th><?php echo lang('index_action_th');?></th>
						</tr>
					</thead>
					<?php foreach ($users as $user):?>
						<tr>
				            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
				            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
				            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
							<td>
								<?php foreach ($user->groups as $group):?>
									<?php echo anchor("panel/auth/permissions/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
				                <?php endforeach?>
							</td>

							<td>
								<?php if(($user->active)): ?>
				            		<?php if($this->ion_auth->user()->row()->id !== $user->id): ?>
						            	<a class='activate_toggle_po' title="<?= lang('index_inactive_link'); ?>" data-content="<a class='btn btn-danger activate_toggle' href='<?= base_url();?>panel/auth/deactivate/<?= $user->id ?>'>Yes</a> <button class='btn activate_toggle_po-close'>No</button>" href="<?= base_url();?>panel/auth/deactivate/<?= $user->id ?>"><span class="label label-success"><i class="fa fa-check"></i> <?= lang('index_active_link')?></span></a>
						            <?php else: ?>
						            	<span class="label label-success"><i class="fa fa-check"></i> <?= lang('index_active_link')?></span>
						            <?php endif; ?>
						        <?php else: ?>
						        	<a href="<?= base_url();?>panel/auth/activate/<?= $user->id ?>"><span class="label label-danger"><i class="fa fa-check"></i> <?= lang('index_inactive_link')?></span></a>
						        <?php endif; ?>
							</td>

							<td><?php echo anchor("panel/auth/edit_user/".$user->id, '<i class="fa fa-edit"></i>', 'class="btn btn-sm btn-default"') ;?>
								<?php if($this->ion_auth->user()->row()->id !== $user->id): ?>
					              <a href="<?= base_url(); ?>panel/auth/delete_user/<?= $user->id; ?>" type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
					            <?php endif; ?>
							</td>
						</tr>
					<?php endforeach;?>
				</table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>




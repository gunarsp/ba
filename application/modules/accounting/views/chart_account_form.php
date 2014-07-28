<?php $this->load->view('dashboard/header'); ?>

	<div class="grid_10" id="content_wrapper">

		<div class="section_wrapper">
		
			<h3 class="title_black"><?php echo $this->lang->line('edit') . ' ' . $this->lang->line('account'); ?></h3>
			
			<?php $this->load->view('dashboard/system_messages'); ?>
			
			<div class="content toggle">

				<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

					<div id="tab_client">

							<dl>
								<dt><?php echo $this->lang->line('account'); ?>: </dt>
								<dd><input type="text" name="account" id="account" value="<?php echo $this->mdl_chart->form_value('account');?>" /></dd>
							</dl>

							<dl>
								<dt><?php echo $this->lang->line('name'); ?>: </dt>
								<dd><input type="text" name="name" id="name" value="<?php echo $this->mdl_chart->form_value('name'); ?>" /></dd>
							</dl>
							
							<dl>
								<dt><?php echo $this->lang->line('level'); ?>: </dt>
								<dd>
									<select name="level" id="level">
										
										<?php foreach ($account_levels as $level) { ?>
										<option value="<?php echo $level->value; ?>" <?php if($level->value == $this->mdl_chart->form_value('level')) { ?>selected="selected"<?php } ?>><?php echo $level->name; ?></option>
										<?php } ?>
									</select>
								</dd>
							</dl>
	
							<dl>
								<dt><?php echo $this->lang->line('type'); ?>: </dt>
								<dd>
									<select name="type" id="type">
										
										<?php foreach ($account_types as $type) { ?>
										<option value="<?php echo $type->value; ?>" <?php if($type->value == $this->mdl_chart->form_value('type')) { ?>selected="selected"<?php } ?>><?php echo $type->value; ?></option>
										<?php } ?>
									</select>
								</dd>
							</dl>
							
							<dl>
								<dt><?php echo $this->lang->line('sum_from'); ?>: </dt>
								<dd><input type="text" name="sum_from" id="sum_from" value="<?php echo $this->mdl_chart->form_value('sum_from'); ?>" /></dd>
							</dl>

							<dl>
								<dt><?php echo $this->lang->line('sum_to'); ?>: </dt>
								<dd><input type="text" name="sum_to" id="sum_to" value="<?php echo $this->mdl_chart->form_value('sum_to'); ?>" /></dd>
							</dl>
							
							<dl>
								<dt></dt>
								<dd><input type="submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" /> <input type="submit" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" /></dd>
							</dl>
						

					</div>

			</form>
				
			</div>

		</div>
		
		</form>
		
	</div>

<?php $this->load->view('dashboard/footer'); ?>
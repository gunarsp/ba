<?php $this->load->view('dashboard/header'); ?>

<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('edit') . ' ' . $this->lang->line('classifier'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				
				<input type="hidden" name="type" id="type" value="<?php echo $current_type; ?>" />
				
				<dl>
					<dt><label> <?php echo $this->lang->line('name'); ?>: </label></dt>
					<dd><input type="text" name="name" id="name" value="<?php echo $this->mdl_classifiers->form_value('name'); ?>" /></dd>
				</dl>

				<dl>
					<dt><label> <?php echo $this->lang->line('value'); ?>: </label></dt>
					<dd><input type="text" name="value" id="value" value="<?php echo $this->mdl_classifiers->form_value('value'); ?>" /></dd>
				</dl>

                <div style="clear: both;">&nbsp;</div>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>
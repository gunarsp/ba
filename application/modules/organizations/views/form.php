<?php 
$this->load->view('dashboard/header'); 

?>



<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('edit') . ' ' . $this->lang->line('organization'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				
				<dl>
					<dt><label> <?php echo $this->lang->line('name'); ?>: </label></dt>
					<dd><input type="text" name="name" id="name" value="<?php echo $this->mdl_organizations->form_value('name'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('organization_type'); ?>: </label></dt>
					<dd>
						<select name="org_type" id="org_type">
					
							<?php foreach ($org_types as $type) { ?>
							<option value="<?php echo $type->id; ?>" <?php if($type->id == $this->mdl_organizations->form_value('org_type')) { ?>selected="selected"<?php } ?>><?php echo $type->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('registration_nr'); ?>: </label></dt>
					<dd><input type="text" name="registration_nr" id="registration_nr" value="<?php echo $this->mdl_organizations->form_value('registration_nr'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('tax_nr'); ?>: </label></dt>
					<dd><input type="text" name="tax_number" id="tax_number" value="<?php echo $this->mdl_organizations->form_value('tax_number'); ?>" /></dd>
				</dl>
					
				<dl>
					<dt><label> <?php echo $this->lang->line('notes'); ?>: </label></dt>
					<dd><input type="text" name="notes" id="notes" value="<?php echo $this->mdl_organizations->form_value('notes'); ?>" /></dd>
				</dl>
				
                <div style="clear: both;">&nbsp;</div>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>
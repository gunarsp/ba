<?php 
$this->load->view('dashboard/header'); 
$this->load->view('dashboard/jquery_date_picker');
?>



<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('edit') . ' ' . $this->lang->line('partner'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				
				<dl>
					<dt><label> <?php echo $this->lang->line('date_from'); ?>: </label></dt>
					<dd><input type="text" name="date_from" class="datepicker" value="<?php echo $this->mdl_partners->form_value('date_from'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('date_to'); ?>: </label></dt>
					<dd><input type="text" name="date_to" class="datepicker" value="<?php echo $this->mdl_partners->form_value('date_to'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('organization'); ?>: </label></dt>
					<dd>
						<select name="organization_id" id="organization_id">
							<option value="0" ></option>
							<?php foreach ($organizations as $organization) { ?>
							<option value="<?php echo $organization->id; ?>" <?php if($organization->id == $this->mdl_partners->form_value('organization_id')) { ?>selected="selected"<?php } ?>><?php echo $organization->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('person'); ?>: </label></dt>
					<dd>
						<select name="person_id" id="person_id">
							<option value="0" ></option>
							<?php foreach ($persons as $person) { ?>
							<option value="<?php echo $person->id; ?>" <?php if($person->id == $this->mdl_partners->form_value('person_id')) { ?>selected="selected"<?php } ?>><?php echo $person->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
				
				<fieldset>
					<legend>Partnership types</legend>
					
					<?php foreach ($partnership_types as $partner_type) { ?>
					<dl>
	                    <dt><label><?php echo $partner_type->name; ?></label></dt>
	                    <dd><input type="checkbox" name="<?php echo $partner_type->value; ?>" id="<?php echo $partner_type->value; ?>" value="1" <?php echo (1 == $this->mdl_partners->form_value($partner_type->value) ? 'checked' : ''); ?> /></dd>
	                </dl>
					<?php } ?>
					
				</fieldset>
                
				
				<dl>
					<dt><label> <?php echo $this->lang->line('notes'); ?>: </label></dt>
					<dd><input type="text" name="notes" id="notes" value="<?php echo $this->mdl_partners->form_value('notes'); ?>" /></dd>
				</dl>
				
                <div style="clear: both;">&nbsp;</div>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>
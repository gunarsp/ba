<?php 
$this->load->view('dashboard/header'); 
$this->load->view('dashboard/jquery_date_picker');
?>



<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('edit') . ' ' . $this->lang->line('person'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				
				<dl>
					<dt><label> <?php echo $this->lang->line('name'); ?>: </label></dt>
					<dd><input type="text" name="name" id="name" value="<?php echo $this->mdl_persons->form_value('name'); ?>" /></dd>
				</dl>

				<dl>
					<dt><label> <?php echo $this->lang->line('surname'); ?>: </label></dt>
					<dd><input type="text" name="surname" id="surname" value="<?php echo $this->mdl_persons->form_value('surname'); ?>" /></dd>
				</dl>

				<dl>
					<dt><label> <?php echo $this->lang->line('personal_code'); ?>: </label></dt>
					<dd><input type="text" name="personal_code" id="personal_code" value="<?php echo $this->mdl_persons->form_value('personal_code'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label> <?php echo $this->lang->line('birth_date'); ?>: </label></dt>
					<dd><input type="text" name="birthdate" class="datepicker" value="<?php echo $this->mdl_persons->form_value('birthdate'); ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('gender'); ?>: </label></dt>
					<dd>
						<select name="gender" id="gender">
					
							<?php foreach ($genders as $gender) { ?>
							<option value="<?php echo $gender->id; ?>" <?php if($gender->id == $this->mdl_persons->form_value('gender')) { ?>selected="selected"<?php } ?>><?php echo $gender->name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>
							
				<dl>
					<dt><label> <?php echo $this->lang->line('notes'); ?>: </label></dt>
					<dd><input type="text" name="notes" id="notes" value="<?php echo $this->mdl_persons->form_value('notes'); ?>" /></dd>
				</dl>
				
                <div style="clear: both;">&nbsp;</div>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>
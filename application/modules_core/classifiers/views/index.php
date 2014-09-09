<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('classifiers'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<form id="classifier_form" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
				<dl>
					<dt><?php echo $this->lang->line('type'); ?>: </dt>
					<dd>
						<select name="type" id="type" onChange='document.forms["classifier_form"].submit();'>
							<?php if(!empty($classifiers_types)) {
								foreach ($classifiers_types as $type) { ?>
									<option value="<?php echo $type->type; ?>" <?php if($current_type == $type->type) { ?>selected="selected"<?php } ?>><?php echo $type->type; ?></option>
							<?php }
								}?>
						</select>
					</dd>
				</dl>
			</form>
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('id'); ?></th>
					<th scope="col"><?php echo $this->lang->line('name'); ?></th>
					<th scope="col"><?php echo $this->lang->line('value'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($classifiers as $classifier_item) { ?>
				<tr class="hoverall">
					<td class="first"><?php echo $classifier_item->id; ?></td>
					<td><?php echo $classifier_item->name; ?></td>
					<td><?php echo $classifier_item->value; ?></td>
					<td class="last">
						<a href="<?php echo site_url('classifiers/form/id/' . $classifier_item->id . '/type/' . $current_type); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('classifiers/delete/id/' . $classifier_item->id . '/type/' . $current_type); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_classifiers->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_classifiers->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('classifiers/sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>
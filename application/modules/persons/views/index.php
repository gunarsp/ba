<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('persons'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('name'); ?></th>
					<th scope="col"><?php echo $this->lang->line('surname'); ?></th>
					<th scope="col"><?php echo $this->lang->line('personal_code'); ?></th>
					<th scope="col"><?php echo $this->lang->line('birth_date'); ?></th>
					<th scope="col"><?php echo $this->lang->line('gender'); ?></th>
					<th scope="col"><?php echo $this->lang->line('notes'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($persons as $person) { ?>
				<tr class="hoverall">
					<td class="first"><?php echo $person->name; ?></td>
					<td><?php echo $person->surname; ?></td>
					<td><?php echo $person->personal_code; ?></td>
					<td><?php echo format_date($person->birthdate); ?></td>
					<td><?php echo $this->mdl_classifiers->getNameById($person->gender); ?></td>
					<td><?php echo $person->notes; ?></td>
					<td class="last">
						<a href="<?php echo site_url('persons/form/id/' . $person->id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('persons/delete/id/' . $person->id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_persons->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_persons->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('persons/sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>
<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('organizations'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('name'); ?></th>
					<th scope="col"><?php echo $this->lang->line('organization_type'); ?></th>
					<th scope="col"><?php echo $this->lang->line('registration_nr'); ?></th>
					<th scope="col"><?php echo $this->lang->line('tax_nr'); ?></th>
					<th scope="col"><?php echo $this->lang->line('notes'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($organizations as $organization) { ?>
				<tr class="hoverall">
					<td class="first"><?php echo $organization->name; ?></td>
					<td><?php echo $this->mdl_classifiers->getNameById($organization->org_type); ?></td>
					<td><?php echo $organization->registration_nr; ?></td>
					<td><?php echo $organization->tax_number; ?></td>
					<td><?php echo $organization->notes; ?></td>
					<td class="last">
						<a href="<?php echo site_url('organizations/form/id/' . $organization->id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('organizations/delete/id/' . $organization->id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_organizations->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_organizations->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('organizations/sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>
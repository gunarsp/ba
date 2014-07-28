<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('chart'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('account'); ?></th>
					<th scope="col"><?php echo $this->lang->line('name'); ?></th>
					<th scope="col"><?php echo $this->lang->line('level'); ?></th>
					<th scope="col"><?php echo $this->lang->line('type'); ?></th>
					<th scope="col"><?php echo $this->lang->line('sum_from'); ?></th>
					<th scope="col"><?php echo $this->lang->line('sum_to'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($chart as $account) { ?>
				<tr class="hoverall">
					<td class="first"><?php echo $account->account; ?></td>
					<td><?php echo $account->name; ?></td>
					<td><?php echo $account->level; ?></td>
					<td><?php echo $account->type; ?></td>
					<td><?php echo $account->sum_from; ?></td>
					<td><?php echo $account->sum_to; ?></td>
					<td class="last">
						<a href="<?php echo site_url('accounting/chart/chart_account_form/id/' . $account->id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('accounting/chart/delete/id/' . $account->id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_chart->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_chart->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('accounting/chart_sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>
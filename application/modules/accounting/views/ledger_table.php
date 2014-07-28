<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('ledger'); ?>
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">
			
			<table>
				<tr>
					<th scope="col" class="first"><?php echo $this->lang->line('account'); ?></th>
					<th scope="col"><?php echo $this->lang->line('name'); ?></th>
					<th scope="col"><?php echo $this->lang->line('level'); ?></th>
					<th scope="col"><?php echo $this->lang->line('type'); ?></th>
					<th scope="col"><?php echo $this->lang->line('start_credit'); ?></th>
					<th scope="col"><?php echo $this->lang->line('start_debit'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('credit'); ?></th>
				</tr>
				<?php foreach ($ledger as $key => $account) { ?>
				<tr class="hoverall <?php echo ($account['level']=='10'?'header_level':''); ?>">
					<td class="first"><?php echo $account['account']; ?></td>
					<td><?php echo $account['name']; ?></td>
					<td><?php echo $account['level']; ?></td>
					<td><?php echo $account['type']; ?></td>
					<td><?php echo $account['start_credit']; ?></td>
					<td><?php echo $account['start_debit']; ?></td>
					<td class="last"><?php echo $account['credit']; ?></td>
				</tr>
				<?php } ?>
			</table>
			
		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>array('accounting/ledger_sidebar'))); ?>

<?php $this->load->view('dashboard/footer'); ?>
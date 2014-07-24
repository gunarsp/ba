<?php $this->load->view('dashboard/header'); ?>

	<div class="grid_10" id="content_wrapper">

		<div class="section_wrapper">
		
			<h3 class="title_black">view fidavista</h3>
			
			<?php $this->load->view('dashboard/system_messages'); ?>
			
			<div class="content toggle">

				<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data">

					<div id="tab_client">

							<dl>
								<dt><?php echo $this->lang->line('file'); ?>: </dt>
								<dd><input type="file" name="file" id="file" value="<?php echo $this->input->post('file');?>" /></dd>
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
	
	<?php 
	
	
	if(!empty($data))
	{
		//print_r($data);
		$CI =& get_instance();
		
		$header	= $data->Header;
		$period	= $data->Statement->Period;
		$bank	= $data->Statement->BankSet;
		$client = $data->Statement->ClientSet;
		//$accountsSet = $data->Statement->AccountSet;
		//print_r($accountsSet);
		
		foreach($data->Statement->AccountSet as $key => $account)
		{
			//print_r($account);
			echo '<br>'.$this->lang->line('account').': '.$account->IBAN.'<br>';
			echo 'open bal'.$account->CcyStmt->OpenBal.'<br>';
			echo 'close bal'.$account->CcyStmt->CloseBal.'<br>';
			echo '<br>';
	
			$value = floatval($account->CcyStmt->OpenBal);
	
			if(!empty($account->CcyStmt->TrxSet))
			{
				$CI->table->set_heading('', $this->lang->line('date'), $this->lang->line('nr'), $this->lang->line('sum'), $this->lang->line('notes'),
						$this->lang->line('contra_account'), $this->lang->line('contra_name'), $this->lang->line('contra_id'), $this->lang->line('balance'));
				$tmpl = array ( 'table_open'  => '<table class="chart" border="0" cellpadding="0" cellspacing="1">' );
				$CI->table->set_template($tmpl);
				$counter = 1;
	
				foreach($account->CcyStmt->TrxSet as $key => $transaction)
				{
					//print_r($transaction);
					if("C" == $transaction->CorD)
					{
						$prefix = '<span class="credit">';
						$value += floatval($transaction->AccAmt);
						$postfix = '</span>';
					} else {
						$prefix = '<span class="debit">-';
						$value -= floatval($transaction->AccAmt);
						$postfix = '</span>';
					}
	
					if(!empty($transaction->CPartySet->AccNo))
					{
						$cAccount	= $transaction->CPartySet->AccNo;
						$cName		= $transaction->CPartySet->AccHolder->Name;
						$cLegalId	= $transaction->CPartySet->AccHolder->LegalID;
					} else {
						$cAccount	= "";
						$cName		= "";
						$cLegalId	= "";
					}
	
					$CI->table->add_row($counter,
							$transaction->BookDate,
							$transaction->DocNo,
							$prefix.$transaction->AccAmt,
							$transaction->PmtInfo,
							$cAccount,
							$cName,
							$cLegalId,
							$value
					);
	
					$counter++;
				}
				echo $this->table->generate();
			}
		}
	}
	
	?>
		
	</div>

<?php $this->load->view('dashboard/footer'); ?>
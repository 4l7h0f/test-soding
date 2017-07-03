<table border="0" cellpadding="0" cellspacing="1" style="width:100%">
 <tr>
		<?php foreach($fields as $field): ?>
		<th><?php echo ucwords(str_replace("_", " ", $field)); ?></th>
		<?php endforeach; ?>
		<th width="35"><?php echo $this->lang->line('scaff_edit'); ?></th>
		<th width="45"><?php echo $this->lang->line('scaff_delete'); ?></th>
	</tr>

	<?php foreach($query->result() as $row): ?>
 <tr>	
 <?php foreach($fields as $field): ?>	
		<td>
			<?php
				//print_r($row);
				//print_r(form_prep($field));
				if($field == 'id'){
						echo ++$start;
				}elseif($field == 'date_created' || $field == 'date_updated' ){
					echo date("F d, Y : H:m:s", strtotime(form_prep($row->$field)));	
				}else{
					echo form_prep($row->$field);
				}
				
			?>
		</td>
		<?php endforeach; ?>
		<td>&nbsp;<?php echo anchor('tasks/edit/'.$row->$primary.$table_url, $this->lang->line('scaff_edit')); ?>&nbsp;</td>
 	<td><?php echo anchor('tasks/delete/'.$row->$primary.$table_url, $this->lang->line('scaff_delete')); ?></td>
 </tr>
	<?php endforeach; ?>
</table>

<?php echo $paginate; 

/* End of file view.php */
/* Location: ./application/views/scaffolding/view.php */
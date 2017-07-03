<p><?php echo anchor('tasks'.$table_url, '&lt; '.$this->lang->line('scaff_view_all'));?></p>

<?php echo form_open('tasks/update/'.$this->uri->segment(3).$table_url); ?>

<table border="0" cellpadding="3" cellspacing="1">
	<?php foreach($fields as $field): ?>
	
	<?php if ($field->primary_key == 1) continue; ?>

	<tr>
		<td>
			<?php
				if ($field->type != 'datetime'){
					echo $field->name; echo ' '.$field->default; 
				}
			?>
		</td>
		
		<?php if ($field->type == 'text'): ?>
		<td>
			<textarea class="textarea" name="<?php echo $field->name;?>" cols="60" rows="10" ><?php $f = $field->name; echo form_prep($query->$f); ?></textarea>
		</td>
		<?php elseif ($field->name == 'date_created'): ?>
		<td></td>
		<?php elseif ($field->name == 'date_updated'): ?>
		<td>
			<input type="hidden" name="<?php echo $field->name; ?>" value="<?php echo $dateUpdated; ?>" />
		</td>
		<?php else : ?>
		<td>
			<input class="input" value="<?php $f = $field->name; echo form_prep($query->$f); ?>" name="<?php echo $field->name; ?>" size="60" />
		</td>
		<?php endif; ?>
		
	</tr>
	<?php endforeach; ?>
</table>

<input type="submit" class="submit" value="Update" />

<?php echo form_close(); 

/* End of file edit.php */
/* Location: ./application/views/scaffolding/edit.php */
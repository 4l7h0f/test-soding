<p><?php echo anchor('tasks'.$table_url, '&lt; '.$this->lang->line('scaff_view_all')); ?></p>

<?php echo form_open('tasks/insert'.$table_url); ?>

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
			<textarea class="textarea" name="<?php echo $field->name; ?>" cols="60" rows="10" ><?php echo form_prep($field->default); ?></textarea>
		</td>
		<?php elseif ($field->type == 'datetime'): ?>
		<td>
			<input type="hidden" name="<?php echo $field->name; ?>" value="<?php echo $dateCreated; ?>" />
		</td>
		<?php else : ?>
		<td>
			<input class="input" name="<?php echo $field->name; ?>" value="<?php echo form_prep($field->default); ?>" size="60" />
		</td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
</table>

<input type="submit" class="submit" value="Insert" />

<?php echo form_close(); ?>

<?php

/* End of file add.php */
/* Location: ./application/views/scaffolding/add.php */
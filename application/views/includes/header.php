<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title><?php echo $title; ?></title>

<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/scaffolding/stylesheet.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv='pragma' content='no-cache' />

</head>
<body>

	<div id="header">		
		<div id="header_left">
			<h3><?php echo $title; ?></h3>
		</div>
		<div id="header_right">
			<?php echo anchor('tasks/add'.$table_url,  $this->lang->line('scaff_create_record')); ?>
		</div>
	</div>
	<br clear="all">
	<div id="outer">
	<?php

/* End of file header.php */
/* Location: ./application/views/scaffolding/header.php */
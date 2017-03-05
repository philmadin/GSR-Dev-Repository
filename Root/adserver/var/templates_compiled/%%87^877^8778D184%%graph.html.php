<?php /* Smarty version 2.6.18, created on 2016-05-22 22:42:34
         compiled from dashboard/graph.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'dashboard/graph.html', 21, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>OpenX Dashboard</title>
  <link rel='stylesheet' type='text/css' href='<?php echo $this->_tpl_vars['assetPath']; ?>
/css/dashboard-widget.css'>
</head>

<body>
<?php if ($this->_tpl_vars['extensionLoaded']): ?>
<img id="graph" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['imageSrc'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
<?php else: ?>
<p style="margin-top: 1em; text-align: justify">
    Sorry, you cannot see this graph because the GD graphics extension is missing
    from your PHP installation.
</p>
<p>
    Please contact your system administrator to have it installed.
</p>
<?php endif; ?>
</body>
</html>
<?php /* Smarty version 2.6.18, created on 2016-05-22 22:42:46
         compiled from advertiser-index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'view_before_content', 'advertiser-index.html', 12, false),array('function', 'view_after_content', 'advertiser-index.html', 14, false),)), $this); ?>
<?php echo $this->_plugins['function']['view_before_content'][0][0]->beforeContent(array(), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "advertiser-index-list.html", 'smarty_include_vars' => array('from' => $this->_tpl_vars['aAdvertisers'],'aCount' => $this->_tpl_vars['aCount'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_plugins['function']['view_after_content'][0][0]->afterContent(array(), $this);?>

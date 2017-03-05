<?php /* Smarty version 2.6.18, created on 2016-05-22 22:42:34
         compiled from dashboard/audit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'dashboard/audit.html', 15, false),array('modifier', 'count', 'dashboard/audit.html', 25, false),array('modifier', 'escape', 'dashboard/audit.html', 33, false),array('modifier', 'date_format', 'dashboard/audit.html', 37, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo OA_Admin_Template::_function_t(array('str' => 'AuditTrail'), $this);?>
</title>
  <link rel='stylesheet' type='text/css' href='<?php echo $this->_tpl_vars['assetPath']; ?>
/css/dashboard-widget.css'>
  <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assetPath']; ?>
/css/dashboard-widget-ie.css" />
  <![endif]-->
</head>

<body>

<?php if ($this->_tpl_vars['screen'] == 'enabled'): ?>
    <?php if (count($this->_tpl_vars['aAuditData']) > 0): ?>
    <div class="widgetListWrapper widgetContainer">
        <!-- normal view -->
        <ul class="widgetList auditList">
           <?php $_from = $this->_tpl_vars['aAuditData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aValue']):
?>
            <li>
                <div class="title">
                    <a target="_top" href="userlog-audit-detailed.php?auditId=<?php echo $this->_tpl_vars['aValue']['auditid']; ?>
">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['aValue']['desc'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                    </a>
                </div>
                <div>
                    <span class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['aValue']['updated'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d %b %Y") : smarty_modifier_date_format($_tmp, "%d %b %Y")); ?>
</span>
                </div>
            </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
    <div><a class="site-link" target="_top" href="<?php echo $this->_tpl_vars['siteUrl']; ?>
"><?php echo $this->_tpl_vars['siteTitle']; ?>
</a></div>
    <?php else: ?>
    <div class="widgetListWrapper widgetContainer">
      <ul class="widgetList auditList">
        <li><?php echo $this->_tpl_vars['noData']; ?>
</li>
      </ul>
    </div>
    <?php endif; ?>
<?php else: ?>
    <div class="widgetListWrapper widgetContainer">
        <ul class="widgetList auditList">
            <?php echo OA_Admin_Template::_function_t(array('str' => 'AuditTrailNotEnabled'), $this);?>

        </ul>
    </div>
    <div><a class="site-link" target="_top" href="<?php echo $this->_tpl_vars['siteUrl']; ?>
"><?php echo $this->_tpl_vars['siteTitle']; ?>
</a></div>
    <?php endif; ?>
</body>
</html>
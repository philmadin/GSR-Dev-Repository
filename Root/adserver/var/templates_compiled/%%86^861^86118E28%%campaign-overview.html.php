<?php /* Smarty version 2.6.18, created on 2016-05-22 22:42:34
         compiled from dashboard/campaign-overview.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'dashboard/campaign-overview.html', 15, false),array('modifier', 'count', 'dashboard/campaign-overview.html', 25, false),array('modifier', 'escape', 'dashboard/campaign-overview.html', 32, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignOverview'), $this);?>
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
    <?php if (count($this->_tpl_vars['aCampaign']) > 0): ?>
    <div class="widgetContainer widgetListWrapper">
        <!-- normal view -->
        <ul class="widgetList campaignList">
           <?php $_from = $this->_tpl_vars['aCampaign']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aValue']):
?>
           <li><div class="title">
              <?php if ($this->_tpl_vars['aValue']['campaignid'] != ""): ?>
                 <a target="_top" href="<?php echo $this->_tpl_vars['baseUrl']; ?>
?clientid=<?php echo $this->_tpl_vars['aValue']['clientid']; ?>
&campaignid=<?php echo $this->_tpl_vars['aValue']['campaignid']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['aValue']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['aValue']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
           	  <?php else: ?>
           	     <?php echo ((is_array($_tmp=$this->_tpl_vars['aValue']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

           	  <?php endif; ?>
           	</div><div class="campaign-<?php echo $this->_tpl_vars['aValue']['action']; ?>
"><?php echo $this->_tpl_vars['aValue']['actionDesc']; ?>
</div></li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
    <div><a class="site-link" target="_top" href="<?php echo $this->_tpl_vars['siteUrl']; ?>
"><?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignGoTo'), $this);?>
</a></div>
    <!-- end of normal view -->
    <?php else: ?>
        <?php if ($this->_tpl_vars['hasCampaigns']): ?>
	<!-- no items view  -->
	<div class="widgetListWrapper widgetContainer">
	    <ul class="widgetList campaignNoItems">
	        <li><?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignNoDataTimeSpan'), $this);?>
</li>
	    </ul>
	</div>
	<div><a class="site-link" target="_top" href="<?php echo $this->_tpl_vars['siteUrl']; ?>
"><?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignSetUp'), $this);?>
</a></div>
	<!-- end of no items view  -->
	<?php else: ?>
    <!-- no campaigns view -->
    <div class="widgetListWrapper widgetContainer">
        <ul class="widgetList campaignList">
            <?php if ($this->_tpl_vars['isAdmin'] == true): ?>
                <?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignNoRecordsAdmin'), $this);?>

            <?php else: ?>
                <?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignNoRecords'), $this);?>

            <?php endif; ?>
        </ul>
    </div>
    <?php if ($this->_tpl_vars['isAdmin'] != true): ?>
    <div><a class="site-link" target="_top" href="<?php echo $this->_tpl_vars['siteUrl']; ?>
"><?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignSetUp'), $this);?>
</a></div>
    <?php endif; ?>
    <!-- end of no campaigns view -->
    <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
	<!-- Audit Trail inactive view -->
	<div class="widgetListWrapper widgetContainer">
	    <ul class="widgetList campaignAuditNotActivated">
	       <?php echo OA_Admin_Template::_function_t(array('str' => 'CampaignAuditNotActivated'), $this);?>

	    </ul>
	</div>
	<div><a class="site-link" target="_top" href="<?php echo $this->_tpl_vars['siteUrl']; ?>
"><?php echo $this->_tpl_vars['siteTitle']; ?>
</div>
	<!-- end of Audit Trail inactive view-->
<?php endif; ?>

</body>
</html>
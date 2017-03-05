<?php /* Smarty version 2.6.18, created on 2016-05-22 22:42:32
         compiled from account-switch-search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'account-switch-search.html', 15, false),array('function', 'boldSearchPhrase', 'account-switch-search.html', 18, false),array('function', 't', 'account-switch-search.html', 30, false),)), $this); ?>

<div>
<ul id="accounts">
  <li style="display: none"><?php echo ((is_array($_tmp=$this->_tpl_vars['query'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</li>
  <?php $_from = $this->_tpl_vars['adminAccounts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['accountId'] => $this->_tpl_vars['accountName']):
?>
    <li>
      <a href="<?php echo $this->_tpl_vars['adminWebPath']; ?>
account-switch.php?account_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['accountId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo OA_Admin_Template::_function_boldSearchPhrase(array('text' => $this->_tpl_vars['accountName'],'search' => $this->_tpl_vars['query']), $this);?>
</a>
    </li>
  <?php endforeach; endif; unset($_from); ?>
  
  <?php $_from = $this->_tpl_vars['otherAccounts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['groupName'] => $this->_tpl_vars['accounts']):
?>
    <li class="opt"><?php echo ((is_array($_tmp=$this->_tpl_vars['groupName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</li>
    <?php $_from = $this->_tpl_vars['accounts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['accountId'] => $this->_tpl_vars['accountName']):
?>
      <li class="inopt">
        <a href="<?php echo $this->_tpl_vars['adminWebPath']; ?>
account-switch.php?account_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['accountId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo OA_Admin_Template::_function_boldSearchPhrase(array('text' => $this->_tpl_vars['accountName'],'search' => $this->_tpl_vars['query']), $this);?>
</a>
      </li>      
    <?php endforeach; endif; unset($_from); ?>
    <?php if (isset ( $this->_tpl_vars['remainingCounts'][$this->_tpl_vars['groupName']] )): ?>
      <li class="inopt more" title="<?php echo OA_Admin_Template::_function_t(array('str' => 'UseSearchBoxToFindMoreAccounts'), $this);?>
">... <?php echo ((is_array($_tmp=$this->_tpl_vars['remainingCounts'][$this->_tpl_vars['groupName']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</li>
    <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>
  
  <?php if (empty ( $this->_tpl_vars['otherAccounts'] ) && empty ( $this->_tpl_vars['adminAccounts'] )): ?>
    <li class="opt"><?php echo ((is_array($_tmp=$this->_tpl_vars['noAccountsMessage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</li>
  <?php endif; ?>
</ul>
</div>
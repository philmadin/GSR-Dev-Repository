<?php /* Smarty version 2.6.18, created on 2016-05-22 18:34:14
         compiled from messages.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'messages.html', 16, false),)), $this); ?>
<?php if ($this->_tpl_vars['aMessages']['error'] || $this->_tpl_vars['forceRender']): ?>
    <div class="messagePlaceholder messagePlaceholderStatic <?php if ($this->_tpl_vars['class']): ?><?php echo $this->_tpl_vars['class']; ?>
<?php endif; ?>" <?php if ($this->_tpl_vars['id']): ?>id=<?php echo $this->_tpl_vars['id']; ?>
<?php endif; ?>>
      <div class="message localMessage">
        <div class="panel error">
          <div class="icon"></div>
          <div class="body">
            <?php if ($this->_tpl_vars['showSkipSsoForm']): ?>
				<div id="skipsso-form-container" style="margin-left:10px">
				<p>
				We were unable to reach the OpenX Market account registration service at this time.
				In order to continue with the installation process, you may continue without registering 
				or you may try registering again on the form below.
				<br/><br/>
				Note: if you continue without registering, you will need to register with OpenX later in 
				order to be able to serve ads from OpenX Market.
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=$this->_tpl_vars['oaTemplateDir'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'form/form.html') : smarty_modifier_cat($_tmp, 'form/form.html')), 'smarty_include_vars' => array('form' => $this->_tpl_vars['skipSsoForm'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				
				<a id='moreDetails'>More details about the error &#8250;</a>
				<br/><br/>
				</p>
				</div>
			<?php endif; ?>
			<span id='errorMessages'>
            <?php $_from = $this->_tpl_vars['aMessages']['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['messagesLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['messagesLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['error']):
        $this->_foreach['messagesLoop']['iteration']++;
?>
              <?php echo $this->_tpl_vars['error']; ?>
 <?php if (! ($this->_foreach['messagesLoop']['iteration'] == $this->_foreach['messagesLoop']['total'])): ?><br/><?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </span>
          </div>
          <div class="topleft"></div>
          <div class="topright"></div>
          <div class="bottomleft"></div>
          <div class="bottomright"></div>
        </div>
      </div>
    </div>    
<?php endif; ?>

<?php if ($this->_tpl_vars['showSkipSsoForm']): ?>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$(\'#errorMessages\').hide(); 
	$(\'#moreDetails\').click( function() {
		$(\'#errorMessages\').toggle(); 
	});
});
</script>
'; ?>

<?php endif; ?>
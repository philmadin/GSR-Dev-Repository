<?php /* Smarty version 2.6.18, created on 2016-05-22 18:34:14
         compiled from finish-step.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ox_wizard_steps', 'finish-step.html', 3, false),array('function', 't', 'finish-step.html', 9, false),)), $this); ?>
<div class="install-wizard">
  <div class="finishStep">
    <?php echo $this->_plugins['function']['ox_wizard_steps'][0][0]->wizardSteps(array('steps' => $this->_tpl_vars['oWizard']->getSteps(),'current' => $this->_tpl_vars['oWizard']->getCurrentStep()), $this);?>


    <div class="content">
      <h2>
      <?php if ($this->_tpl_vars['isUpgrade']): ?>
        <?php if (empty ( $this->_tpl_vars['aStatuses'] )): ?>
            <?php echo OA_Admin_Template::_function_t(array('str' => 'FinishUpgradeTitle'), $this);?>

        <?php else: ?>
            <?php echo OA_Admin_Template::_function_t(array('str' => 'FinishUpgradeWithErrorsTitle'), $this);?>

        <?php endif; ?>
      <?php else: ?>
        <?php if (empty ( $this->_tpl_vars['aStatuses'] )): ?>
            <?php echo OA_Admin_Template::_function_t(array('str' => 'FinishInstallTitle'), $this);?>

        <?php else: ?>
            <?php echo OA_Admin_Template::_function_t(array('str' => 'FinishInstallWithErrorsTitle'), $this);?>

        <?php endif; ?>
      <?php endif; ?>
      </h2>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'messages.html', 'smarty_include_vars' => array('aMessages' => $this->_tpl_vars['aMessages'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

      <?php if ($this->_tpl_vars['aStatuses']): ?>
        <div class="messagePlaceholder messagePlaceholderStatic">
          <div class="message localMessage">
            <div class="panel warning">
              <div class="icon"></div>
              <div class="body">
                <?php echo OA_Admin_Template::_function_t(array('str' => 'InstallNonBlockingErrors','values' => $this->_tpl_vars['logPath']), $this);?>

              </div>
              <div class="topleft"></div>
              <div class="topright"></div>
              <div class="bottomleft"></div>
              <div class="bottomright"></div>
            </div>
          </div>
        </div>

        <div id="error-details" class="hide">
          <ul class="syscheck">
            <li class="checkSection hasError">
              <h4 class="header error"><span class="inlineIcon iconCheckErr"><?php echo OA_Admin_Template::_function_t(array('str' => 'DetailedTaskErrorList'), $this);?>
</span></h4>
              <ul class="check-list">
                            <?php $_from = $this->_tpl_vars['aStatuses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aStatus']):
?>
                <li class="section-error hasError">
                  <div class="messageContainer">
                    <div class="body error">
                      <h4>
                      <?php if ($this->_tpl_vars['aStatus']['type'] == 'plugin'): ?>
                        <?php echo OA_Admin_Template::_function_t(array('str' => 'PluginInstallFailed','values' => $this->_tpl_vars['aStatus']['name']), $this);?>

                      <?php else: ?>
                        <?php echo OA_Admin_Template::_function_t(array('str' => 'TaskInstallFailed','values' => $this->_tpl_vars['aStatus']['name']), $this);?>

                      <?php endif; ?>
                      </h4>
                      <ol>
                      <?php $_from = $this->_tpl_vars['aStatus']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
                        <li><?php echo $this->_tpl_vars['message']; ?>
</li>
                      <?php endforeach; endif; unset($_from); ?>
                      </ol>
                    </div>
                  </div>
                </li>
              <?php endforeach; endif; unset($_from); ?>
              </ul>
            </li>
          </ul>
        </div>
      <?php endif; ?>

      <p><?php echo OA_Admin_Template::_function_t(array('str' => 'ContinueToLogin'), $this);?>
</p>

      <form action="" method="post">
          <input type="hidden" name="action" value="finish" >
          <div class="controls">
            <input type="submit" id="continue" value="<?php echo OA_Admin_Template::_function_t(array('str' => 'BtnContinue'), $this);?>
" name="continue"/>
          </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
<!--
<?php echo '
  $(document).ready(function() {
    $(".finishStep").finishStep({
        '; ?>

        <?php echo '
    });
  });
'; ?>

-->
</script>
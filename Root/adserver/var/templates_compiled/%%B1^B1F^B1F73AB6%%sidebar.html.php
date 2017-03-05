<?php /* Smarty version 2.6.18, created on 2016-05-23 02:42:27
         compiled from layout/sidebar.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'layout/sidebar.html', 12, false),array('modifier', 'escape', 'layout/sidebar.html', 27, false),)), $this); ?>
<?php if (count($this->_tpl_vars['aLeftMenuNav'])): ?>
<div id="secondLevelNavigation">
  <?php unset($this->_sections['n']);
$this->_sections['n']['name'] = 'n';
$this->_sections['n']['loop'] = is_array($_loop=$this->_tpl_vars['aLeftMenuNav']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['n']['show'] = true;
$this->_sections['n']['max'] = $this->_sections['n']['loop'];
$this->_sections['n']['step'] = 1;
$this->_sections['n']['start'] = $this->_sections['n']['step'] > 0 ? 0 : $this->_sections['n']['loop']-1;
if ($this->_sections['n']['show']) {
    $this->_sections['n']['total'] = $this->_sections['n']['loop'];
    if ($this->_sections['n']['total'] == 0)
        $this->_sections['n']['show'] = false;
} else
    $this->_sections['n']['total'] = 0;
if ($this->_sections['n']['show']):

            for ($this->_sections['n']['index'] = $this->_sections['n']['start'], $this->_sections['n']['iteration'] = 1;
                 $this->_sections['n']['iteration'] <= $this->_sections['n']['total'];
                 $this->_sections['n']['index'] += $this->_sections['n']['step'], $this->_sections['n']['iteration']++):
$this->_sections['n']['rownum'] = $this->_sections['n']['iteration'];
$this->_sections['n']['index_prev'] = $this->_sections['n']['index'] - $this->_sections['n']['step'];
$this->_sections['n']['index_next'] = $this->_sections['n']['index'] + $this->_sections['n']['step'];
$this->_sections['n']['first']      = ($this->_sections['n']['iteration'] == 1);
$this->_sections['n']['last']       = ($this->_sections['n']['iteration'] == $this->_sections['n']['total']);
?>
    <?php if ($this->_sections['n']['first']): ?>         <ul class="navigation first">
    <?php elseif ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['first']): ?>         </ul>
        <ul class="navigation">
    <?php endif; ?>

    <?php if ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['selected']): ?>
      <li class="active <?php if ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['first']): ?> first<?php endif; ?><?php if ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['last']): ?> last<?php endif; ?>">
    <?php else: ?>
      <li class="passive <?php if ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['first']): ?> first<?php endif; ?><?php if ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['last']): ?> last<?php endif; ?><?php if ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['single']): ?> single<?php endif; ?><?php if (! $this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['first'] && $this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index_prev']]['selected']): ?> after-active<?php endif; ?>">
    <?php endif; ?>
          <a href="<?php echo $this->_tpl_vars['adminBaseURL']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['filename'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

            <span class="top"></span>
            <span class="bottom"></span>
          </a>

          <?php if ($this->_tpl_vars['aLeftMenuNav'][$this->_sections['n']['index']]['selected'] && count($this->_tpl_vars['aLeftMenuSubNav'])): ?>
          <ul class="navigation">
            <?php unset($this->_sections['sub']);
$this->_sections['sub']['name'] = 'sub';
$this->_sections['sub']['loop'] = is_array($_loop=$this->_tpl_vars['aLeftMenuSubNav']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sub']['show'] = true;
$this->_sections['sub']['max'] = $this->_sections['sub']['loop'];
$this->_sections['sub']['step'] = 1;
$this->_sections['sub']['start'] = $this->_sections['sub']['step'] > 0 ? 0 : $this->_sections['sub']['loop']-1;
if ($this->_sections['sub']['show']) {
    $this->_sections['sub']['total'] = $this->_sections['sub']['loop'];
    if ($this->_sections['sub']['total'] == 0)
        $this->_sections['sub']['show'] = false;
} else
    $this->_sections['sub']['total'] = 0;
if ($this->_sections['sub']['show']):

            for ($this->_sections['sub']['index'] = $this->_sections['sub']['start'], $this->_sections['sub']['iteration'] = 1;
                 $this->_sections['sub']['iteration'] <= $this->_sections['sub']['total'];
                 $this->_sections['sub']['index'] += $this->_sections['sub']['step'], $this->_sections['sub']['iteration']++):
$this->_sections['sub']['rownum'] = $this->_sections['sub']['iteration'];
$this->_sections['sub']['index_prev'] = $this->_sections['sub']['index'] - $this->_sections['sub']['step'];
$this->_sections['sub']['index_next'] = $this->_sections['sub']['index'] + $this->_sections['sub']['step'];
$this->_sections['sub']['first']      = ($this->_sections['sub']['iteration'] == 1);
$this->_sections['sub']['last']       = ($this->_sections['sub']['iteration'] == $this->_sections['sub']['total']);
?>
              <?php if ($this->_tpl_vars['aLeftMenuSubNav'][$this->_sections['sub']['index']]['selected']): ?>
              <li class="active <?php if ($this->_sections['sub']['first']): ?> first<?php endif; ?><?php if ($this->_sections['sub']['last']): ?> last <?php endif; ?>">
              <?php else: ?>
              <li class="passive <?php if ($this->_sections['sub']['first']): ?> first<?php else: ?><?php if ($this->_sections['sub']['last']): ?> last <?php endif; ?><?php endif; ?><?php if ($this->_tpl_vars['aLeftMenuSubNav'][$this->_sections['sub']['index_prev']]['selected']): ?> after-active<?php endif; ?>">
              <?php endif; ?>
                <a href="<?php echo $this->_tpl_vars['adminBaseURL']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['aLeftMenuSubNav'][$this->_sections['sub']['index']]['filename'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                  <?php echo ((is_array($_tmp=$this->_tpl_vars['aLeftMenuSubNav'][$this->_sections['sub']['index']]['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                  <span class="top"></span>
                  <span class="bottom"></span>
                </a>
              </li>
            <?php endfor; endif; ?>
          </ul>
          <?php endif; ?>

      </li>
    <?php if ($this->_sections['n']['last']): ?>     </ul>
    <?php endif; ?>
  <?php endfor; endif; ?>

<?php if (isset ( $this->_tpl_vars['aNotificationQueue'] )): ?>
  <div class="notificationPlaceholder">
    <div class="message">
    <?php $_from = $this->_tpl_vars['aNotificationQueue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['notification']):
?>
      <div class="panel <?php echo $this->_tpl_vars['notification']['type']; ?>
">
        <div class='icon'></div>
        <p>
          <?php echo $this->_tpl_vars['notification']['text']; ?>

        </p>
        <div class='topleft'></div><div class='topright'></div><div class='bottomleft'></div><div class='bottomright'></div>
      </div>
    <?php endforeach; endif; unset($_from); ?>
    </div>
  </div>
<?php endif; ?>


</div>
<?php endif; ?>

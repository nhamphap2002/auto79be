<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Auto79
 * @author     Thang Tran <trantrongthang1207@gmail.com>
 * @copyright  2017 Thang Tran
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_auto79/css/form.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function () {

        js('input:hidden.link').each(function () {
            var name = js(this).attr('name');
            if (name.indexOf('linkhidden')) {
                js('#jform_link option[value="' + js(this).val() + '"]').attr('selected', true);
            }
        });
        js("#jform_link").trigger("liszt:updated");
        js('input:hidden.adcategories').each(function () {
            var name = js(this).attr('name');
            if (name.indexOf('adcategorieshidden')) {
                js('#jform_adcategories option[value="' + js(this).val() + '"]').attr('selected', true);
            }
        });
        js("#jform_adcategories").trigger("liszt:updated");
    });

    Joomla.submitbutton = function (task) {
        if (task == 'cron.cancel') {
            Joomla.submitform(task, document.getElementById('cron-form'));
        } else {

            if (task != 'cron.cancel' && document.formvalidator.isValid(document.id('cron-form'))) {

                Joomla.submitform(task, document.getElementById('cron-form'));
            } else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form
    action="<?php echo JRoute::_('index.php?option=com_auto79&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" enctype="multipart/form-data" name="adminForm" id="cron-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_AUTO79_TITLE_CRON', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
                    <input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
                    <input type="hidden" name="jform[iscomplete]" value="0" />
                    <input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
                    <input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
                    <input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

                    <?php echo $this->form->renderField('created_by'); ?>
                    <?php echo $this->form->renderField('modified_by'); ?>
                    <?php echo $this->form->renderField('title'); ?>
                    <?php echo $this->form->renderField('link'); ?>
                    <?php echo $this->form->renderField('type_news'); ?>
                    <?php echo $this->form->renderField('adcategories'); ?>
                    <?php
                    foreach ((array) $this->item->link as $value):
                        if (!is_array($value)):
                            $link = $value;
                            echo '<input type="hidden" class="link" name="jform[linkhidden][' . $value . ']" value="' . $value . '" />';
                        endif;
                    endforeach;
                    ?>				
                    <?php
                    foreach ((array) $this->item->adcategories as $value):
                        if (!is_array($value)):
                            $adcategories = $value;
                            echo '<input type="hidden" class="adcategories" name="jform[adcategorieshidden][' . $value . ']" value="' . $value . '" />';
                        endif;
                    endforeach;
                    ?>		
                    <?php echo $this->form->renderField('elemid'); ?>
                    <?php echo $this->form->renderField('province'); ?>
                    <?php echo $this->form->renderField('approval'); ?>
                    <?php echo $this->form->renderField('timeapproval'); ?>
                    <?php echo $this->form->renderField('userid'); ?>
                    <?php echo $this->form->renderField('numbernews'); ?>
                    <?php echo $this->form->renderField('pageto'); ?>
                    <?php echo $this->form->renderField('pagestep'); ?>
                    <?php echo $this->form->renderField('pagefrom'); ?>


                    <?php if ($this->state->params->get('save_history', 1)) : ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
                            <div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->item->id > 0): ?>
                        <?php if ($this->item->type_news == 1): ?>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>Link cron get link bai viet</label>
                                </div>
                                <div class="controls">
                                    <textarea cols="60" rows="10"><?php echo str_replace('administrator/', '', JUri::base()); ?>index.php?option=com_auto79&view=cron&task=cron.cronlinkpost&id=<?php echo $this->item->id; ?></textarea>
                                </div>
                                <!--                            <div class="controls">
                                <?php //echo str_replace('administrator/', '', JUri::base()); ?>index.php?option=com_auto79&view=cron&task=cron.cronpost&link=<?php //echo $value; ?>&cate=<?php //echo $adcategories; ?>&pr=<?php //echo $this->item->province; ?>&to=<?php //echo $this->item->pageto; ?>&from=<?php //echo $this->item->pagefrom; ?>
                                                            </div>-->
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>Link cron lay noi dung tin</label>
                                </div>
                                <div class="controls">
                                    <textarea cols="60" rows="10"><?php echo str_replace('administrator/', '', JUri::base()); ?>index.php?option=com_auto79&view=cron&task=cron.cronpost&id=<?php echo $this->item->id; ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>Link cron Tu dong phe duyet</label>
                                </div>
                                <div class="controls">
                                    <textarea cols="60" rows="10"><?php echo str_replace('administrator/', '', JUri::base()); ?>index.php?option=com_auto79&view=cron&task=cron.autoApproval&id=<?php echo $this->item->id; ?></textarea>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>Lay link tuyen dung</label>
                                </div>
                                <div class="controls">
                                    <textarea cols="60" rows="10"><?php echo str_replace('administrator/', '', JUri::base()); ?>index.php?option=com_auto79&view=cronjob&task=cronjob.cronlinkjob&id=<?php echo $this->item->id; ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>Lay tin tuyen dung</label>
                                </div>
                                <div class="controls">
                                    <textarea cols="60" rows="10"><?php echo str_replace('administrator/', '', JUri::base()); ?>index.php?option=com_auto79&view=cronjob&task=cronjob.cronjob&id=<?php echo $this->item->id; ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>Tu dong phe duyet</label>
                                </div>
                                <div class="controls">
                                    <textarea cols="60" rows="10"><?php echo str_replace('administrator/', '', JUri::base()); ?>index.php?option=com_auto79&view=cronjob&task=cronjob.autojob&id=<?php echo $this->item->id; ?></textarea>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>



        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value=""/>
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>
<script>
    jQuery(document).ready(function ($) {
        $("#jform_type_news").chosen().change(function () {
            var $type = $(this).val();
            if ($type == 2) {
                $(this).closest('.control-group').next('.control-group').hide();
                $(this).closest('.control-group').next('.control-group').find('#jform_adcategories').removeClass('required').removeAttr('required');
            } else {
                $(this).closest('.control-group').next('.control-group').show();
                $(this).closest('.control-group').next('.control-group').find('#jform_adcategories').addClass('required').attr('required', 'true');
            }
        })
        var $type = $("#jform_type_news option:selected").val();
        if ($type == 2) {
            $("#jform_type_news").closest('.control-group').next('.control-group').hide();
            $("#jform_type_news").closest('.control-group').next('.control-group').find('#jform_adcategories').removeClass('required').removeAttr('required');
        } else {
            $("#jform_type_news").closest('.control-group').next('.control-group').show();
            $("#jform_type_news").closest('.control-group').next('.control-group').find('#jform_adcategories').addClass('required').attr('required', 'true');
        }
    })
</script>
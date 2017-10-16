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
		
	js('input:hidden.link').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('linkhidden')){
			js('#jform_link option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_link").trigger("liszt:updated");
	js('input:hidden.category_id').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('category_idhidden')){
			js('#jform_category_id option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_category_id").trigger("liszt:updated");
	js('input:hidden.province').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('provincehidden')){
			js('#jform_province option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_province").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'articles.cancel') {
			Joomla.submitform(task, document.getElementById('articles-form'));
		}
		else {
			
			if (task != 'articles.cancel' && document.formvalidator.isValid(document.id('articles-form'))) {
				
				Joomla.submitform(task, document.getElementById('articles-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_auto79&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="articles-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_AUTO79_TITLE_ARTICLES', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('link'); ?>

			<?php
				foreach((array)$this->item->link as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="link" name="jform[linkhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('category_id'); ?>

			<?php
				foreach((array)$this->item->category_id as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="category_id" name="jform[category_idhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('province'); ?>

			<?php
				foreach((array)$this->item->province as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="province" name="jform[provincehidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('approval'); ?>
				<?php echo $this->form->renderField('timeapproval'); ?>
				<?php echo $this->form->renderField('hasget'); ?>
				<?php echo $this->form->renderField('hasapproval'); ?>
				<?php echo $this->form->renderField('time_created'); ?>
				<?php echo $this->form->renderField('cronid'); ?>
				<?php echo $this->form->renderField('postid'); ?>
				<?php echo $this->form->renderField('user_approval'); ?>


					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
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

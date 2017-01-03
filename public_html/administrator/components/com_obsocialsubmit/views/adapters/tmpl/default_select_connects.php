<?php
/**
 * @package 	obSocialSubmit
 * @author 		foobla.com.
 * @copyright	Copyright (C) 2007-2014 foobla.com. All rights reserved.
 * @license		GNU/GPL
 */

defined( '_JEXEC' ) or die;
global $isJ25;
JHtml::addIncludePath( JPATH_COMPONENT . '/helpers/html' );

$class = '';
if ( ! $isJ25 ) {
	JHtml::_( 'bootstrap.popover' );
	$class = 'hide';
}
$document = JFactory::getDocument();
$class_modal = $isJ25 ? '' : 'modal ' . $class . ' fade';
?>
<?php if ($isJ25): ?>
<div style="display:none;">
	<?php endif; ?>
	<div class="<?php echo $class_modal; ?>" id="selectModalconnect">
		<div class="modal-header">
			<h2><?php echo JText::_( 'COM_OBSOCIALSUBMIT_CONNECTION_TYPE_CHOOSE' ) ?></h2>
		</div>
		<div class="modal-body">
			<ul id="new-modules-list" class="list list-striped">

				<?php
				/*Return url*/
				$redirectUrl = JFactory::getURI();
				$redirectUrl = $redirectUrl->toString();

				$session = JFactory::getSession();
				$session->set( 'return', $redirectUrl );

				foreach ( $this->conections as $conection ) : ?>
					<?php
					// Prepare variables for the link.
					$link       = 'index.php?option=com_obsocialsubmit&task=connection.add&addon=' . $conection->element;
					$name       = $this->escape( $conection->name );
					$desc       = JHTML::_( 'string.truncate', ( $this->escape( $conection->desc ) ), 200 );
					$short_desc = JHTML::_( 'string.truncate', ( $this->escape( $conection->desc ) ), 90 );
					?>
					<?php if ( $document->direction != "rtl" ) : ?>
						<li>
							<a href="<?php echo JRoute::_( $link ); ?>">
								<strong><?php echo $name; ?></strong>
							</a>
							<small class="hasPopover" data-placement="right" title="<?php echo $name; ?>" data-content="<?php echo $desc; ?>"><?php echo $short_desc; ?></small>
						</li>
					<?php else : ?>
						<li>
							<small rel="popover" data-placement="left" title="<?php echo $name; ?>" data-content="<?php echo $desc; ?>"><?php echo $short_desc; ?></small>
							<a href="<?php echo JRoute::_( $link ); ?>">
								<strong><?php echo $name; ?></strong>
							</a>
						</li>
					<?php endif ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<?php if ($isJ25): ?>
</div>
<?php endif; ?>
<div class="clr"></div>

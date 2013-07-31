<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Project Manager:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
                echo $this->Html->css('jqueryui-themes/base/jquery.ui.all.css');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
                
                echo $this->Html->script('jquery');
                echo $this->Html->script('jqueryui/jquery.ui.core.min');
                echo $this->Html->script('jqueryui/jquery.ui.widget.min');
                echo $this->Html->script('jqueryui/jquery.ui.datepicker.min');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
                    <h1><?php echo __("Project Manager") ?></h1>
                    <?php echo $this->element('menu'); ?>
                    <?php echo $this->element('infoDiv'); ?>
 		</div>
		<div id="content">
                        <?php echo $this->Html->getCrumbs(' > ', 'Home'); ?>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
        <?php echo $this->Js->writeBuffer(); ?>
</body>
</html>

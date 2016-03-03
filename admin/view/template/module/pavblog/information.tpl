<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
			</div>
			<h1>Информация</h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div><!-- end div .page-header -->
	<div id="page-content" class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php if( is_array($error_warning) ) { echo implode("<br>",$error_warning); } else { echo $error_warning; } ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>

		<div id="ajaxloading" class="hide">
			<div class="alert alert-warning" role="alert"><?php echo $objlang->get('text_process_request'); ?></div>
		</div>

		<div class="toolbar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
		<!-- tools bar blog -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i>Информация</h3>
			</div>
			<div class="panel-body">

				<div class="content">
						
					<div id="tab-support">
						<h4>Pavo Blogs 2 для Ocstore 2.1.0.1</h4>

						<h4>О модуле</h4>
						<div>
							<p class="pavo-copyright">Это бесплатный модуль для русской сборки Ocstore 2.1.0.1 публикуемый по лицензии GPL/V2. Разработчик <a href="http://www.pavothemes.com" title="PavoThemes - Opencart Theme Clubs">PavoThemes</a></p>
						</div>
						<div>
						<h4>Автор</h4>
							<ul>
							    <li><a href="http://www.pavothemes.com">Офф. сайт Pav Blog</a></li>
								<li>Email: <a href="mailto:pavothemes@gmail.com">pavothemes@gmail.com</a> </li>
								<li>Skype Support: hatuhn</li>
								</ul>
								<h4>Русский перевод,адаптация,программирование</h4>
								<ul>
								<li><a href="http://opencartforum.ru/user/18938-tom/" target="_blank">Русский перевод TOM</a></li>
								<li><a href="https://opencartforum.com/user/20213-krumax/" target="_blank">Програмирование Krumax</a></li>
							    <li>Skype: <a href="skype:mersedes71?add">Юрий Том</a></li>
								<li>Skype: <a href="skype:krumax.ya?add">Krumax</a></li>
								<li><a href="https://opencartforum.com/">Форум Ocstore</a></li>
							</ul>
							<p>Все вопросы по настройке,работе и проблемах только в теме обсуждения <a href="https://opencartforum.com/">Будет ссылка</a>.</p>
							<p>По всем вопросам индивидуальных правок и дополнения функционала блога <b>только на платной основе</b>, направлять по указаным выше реквизитам.</p>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div><!-- end div #page-content -->
</div><!-- end div #content -->
<script type="text/javascript">
	$(".pavhtabs a").tabs();
	$(".pavmodshtabs a").tabs();
	function __submit( val ){
		$("#action_mode").val( val );
		$("#form").submit();
	}
</script>
<?php echo $footer; ?>
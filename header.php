<!DOCTYPE html>
<html lang="ja" prefix="og: http://ogp.me/ns#">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
    <?php wp_head(); ?>
	<link rel="icon" href=" <?php echo get_template_directory_uri();?>/img/icon-home.png">
</head>

<body>

	<!-- header -->
	<header id="header">
		<div class="inner">
			<?php if(is_home() || is_front_page()): ?>
				<h1 class="header-logo"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1><!-- /header-logo -->
			<?php else : ?>
			<div class="header-logo"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></div>
			<?php endif; ?>
			<div class="header-sub"><?php bloginfo('description'); //ブログのdescriptionを表示 ?></div><!-- /header-sub -->
			<!-- drawer -->
			<div class="drawer">
				<div class="drawer-icon">
					<span class="drawer-open"><i class="fas fa-bars"></i></span><!-- /drawer-open -->
					<span class="drawer-close"><i class="fas fa-times"></i></span><!-- drawer-close -->
				</div><!-- /drawer-icon -->

				<!-- drawer-content -->
				<div class="drawer-content">
				<?php
				//.drawer-navを置き換えて、スマホ用メニューを動的に表示する
				wp_nav_menu(
				array(
				'depth' => 1,
				'theme_location' => 'drawer', //ドロワーメニューをここに表示すると指定
				'container' => 'nav',
				'container_class' => 'drawer-nav',
				'menu_class' => 'drawer-list',
				)
				);
				?> 
				</div><!-- /drawer-content -->
			</div><!-- /drawer -->

		</div><!-- /inner -->
	</header><!-- /header -->

	<!-- header-nav -->
	<nav class="header-nav">
	<div class="inner">
	<?php
	wp_nav_menu(
	//.header-listを置き換えて、PC用メニューを動的に表示する
	array(
	'depth' => 1,
	'theme_location' => 'global', //グローバルメニューをここに表示すると指定
	'container' => 'false',
	'menu_class' => 'header-list',
	)
	);
	?>
	</div><!-- /inner -->
	</nav><!-- header-nav -->

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php elegant_titles(); ?></title>
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css'/>
	<link href='http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="http://protezynig.com.ua/wp-content/uploads/2016/08/animate.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"


	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
		<script type="text/javascript">DD_belatedPNG.fix('img#logo, span.overlay, a.zoom-icon, a.more-icon, #menu, #menu-right, #menu-content, ul#top-menu ul, #menu-bar, .footer-widget ul li, span.post-overlay, #content-area, .avatar-overlay, .comment-arrow, .testimonials-item-bottom, #quote, #bottom-shadow, #quote .container');</script>
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7style.css" />
	<![endif]-->
	<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie8style.css" />
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
		<link rel="stylesheet" type="text/css" href="http://test.protezynog.pl/wp-content/themes/Protezy/epanel/shortcodes/css/shortcodes.css">
</head>
<body <?php body_class(); ?>>
	<div id="page-wrap">
		<header id="main">
			<div class="container top-info">
				<div id="akcijaBlok">
					<p>До кінця 2016 року <span id="spanWord">АКЦІЯ!</span></p>
					<p>Ми використовуємо німецькі деталі найвищої якості "Отто-Бок".</p>
					<p>ГОМІЛКОВИЙ протез: <span class="price">від 750 євро</span></p>
					<p>СТЕГНОВИЙ протез: <span class="price">від 1500 євро</span></p>
					<p>Додаткову інформацію можна отримати тут:</p>
					<p>тел. моб. +48 608-591-481</p>
					<p>email: biuro@protezynog.pl</p>
					<button id="close"> Закрити </button>
				</div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php $logo = (get_option('evolution_logo') <> '') ? esc_attr(get_option('evolution_logo')) : get_template_directory_uri() . 'http://test.protezynog.pl/images/logo.png'; ?>
					<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/><!--</a><img src="http://test.protezynog.pl/images/nfz.png">-->

					<a href="#">
						<img id="akcijaProtez" width="55" height="55" src="http://protezynig.com.ua/wp-content/uploads/2016/08/akcijaProtez.png"/>
					</a>
					<a href="#" id="containerText">
						<span class="animated infinite tada" id="spanTekst">АКЦІЯ</span>
					</a>

<a href="#"><img id="ukrFlag" width="30" height="30" src="http://protezynig.com.ua/wp-content/uploads/2016/02/flags/Ukraine.png"/></a>
<a href="http://protezynog.pl"><img id="polFlag" width="30" height="30" src="http://protezynig.com.ua/wp-content/uploads/2016/02/flags/Poland.png"/></a>

				<?php do_action('et_header_top'); ?>
			</div> <!-- end .container -->
			<div id="navigation">
				<div class="container clearfix">
					<nav id="top-menu">
						<?php
							$menuClass = 'nav';
							if ( get_option('evolution_disable_toptier') == 'on' ) $menuClass .= ' et_disable_top_tier';
							$primaryNav = '';
							if (function_exists('wp_nav_menu')) {
								$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
							}
							if ($primaryNav == '') { ?>
								<ul class="<?php echo esc_attr( $menuClass ); ?>">
									<?php if (get_option('evolution_home_link') == 'on') { ?>
										<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','Evolution') ?></a></li>
									<?php }; ?>

									<?php show_page_menu($menuClass,false,false); ?>
									<?php show_categories_menu($menuClass,false); ?>
								</ul>
							<?php }
							else echo($primaryNav);
						?>
					</nav>
					<a href="#" id="mobile_nav" class="closed"><?php esc_html_e( 'Navigation', 'Evolution' ); ?><span></span></a>

					<div id="search-form">
						<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
							<input type="text" value="<?php esc_attr_e('Search this site...', 'Evolution'); ?>" name="s" id="searchinput" />
							<?php
								global $default_colorscheme;
								$colorSchemePath = '';
								$colorScheme = get_option( 'evolution_color_scheme' );
								if ( $colorScheme <> $default_colorscheme ) $colorSchemePath = strtolower( $colorScheme ) . '/';
							?>
							<input type="image" alt="<?php echo esc_attr( 'Submit', 'Evolution' ); ?>" src="<?php echo esc_attr( get_template_directory_uri() . '/images/' . $colorSchemePath . 'search_btn.png' ); ?>" id="searchsubmit" />
						</form>
					</div> <!-- end #search-form -->
					<div id="top-menu-shadow"></div>
					<div id="bottom-menu-shadow"></div>
				</div> <!-- end .container -->
			</div> <!-- end #navigation -->
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
				<script type="text/javascript" src="http://protezynig.com.ua/wp-content/uploads/2016/08/scripts.js"></script>
		</header> <!-- end #main -->

		<div id="main-area">
			<div class="container">
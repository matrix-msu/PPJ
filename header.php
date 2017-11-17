<?php
    require_once('config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php the_title(); ?> | <?php bloginfo('name'); ?></title>

    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <link rel="SHORTCUT ICON" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
    <link rel="icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" type="image/ico" />
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css">

    <!-- - - - - - - - - - - - - - - - SCRIPTS - - - - - - - - - - - - - - - - - -->
    <script src="<?php bloginfo('template_url'); ?>/js/jquery-1.9.1.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery-1.11.1.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery-ui-1.11.4.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.sumoselect.js"></script>
<!--    <script src="<?php bloginfo('template_url'); ?>/js/header.js"></script>-->
</head>

<body>
<!--
	<div id="loginBar">
			<div id="innerLoginBar">
				<nav>
					<ul id="loginNav">
						 links must be in one line to avoid spacing issues in rendered code in browser 
						<li><a href=''>community</a></li>
                     </ul>
				</nav>
			</div>
		</div>
-->

	<header>
		<div id="header">
            <ul id="logoNav">
                <a href="http://publicphilosophyjournal.org">
                    <img class="logo" src="<?php bloginfo('template_url'); ?>/images/logos/logo-Regular.svg" alt="Public Philosophy Journal Logo"/>
                </a>
<!--                <div class="mobileIco">&#9776;</div>-->
            </ul>
			<nav id="mainNav">
				<ul class="navigation">

                    <li><a href="http://publicphilosophyjournal.org/about/">about</a></li>
                    <li id='hamburger'><div id="dropHeader"><button class="dropButton"></button><div id="dropContent">
                        <a href="http://publications.publicphilosophyjournal.org/volumes/">journal</a>
                        <a href="http://publicphilosophyjournal.org/current">current</a>
                        <a href="http://publicphilosophyjournal.org/people">people</a></div></div> </li>
				</ul>
			</nav>
			</div>
	</header>

    <?php if (is_page_template('submissions.php') || is_page_template('index.php')) {
    ?>
        <div id="journalTopBar">
            <div class="innerBar">
                <div class="journalSelectLeft">
                    <select id="originalFormat" placeholder="FORMAT">
                        <option value="Article">Articles</option>
                        <option value="Image">Images</option>
                        <option value="Audio">Audio</option>
                        <option value="Video">Video</option>
                    </select>
                </div>

                <div class="journalSelectRight">
                    <select id="dateDigital" placeholder="DATE">
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                        <option value="2013">2013</option>
                        <option value="2012">2012</option>
                        <option value="2011">2011</option>
                    </select>
                </div>
            </div>
        </div>
    <?php

} ?>

	<?php print globaljsvars; ?>

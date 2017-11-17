<?php
    /**
     * Template Name: Editors
     */

    get_header();

    require_once(BASE_PATH_KORA.'/api/orm-includes.php');
    require_once(BASE_PATH_KORA.'/includes/koraSearch.php');
    require_once('functions/get-sidebar.php');

    $issue_kid = $_GET['kid'];
    $issue = KORA_Search(token, projectID, Issue, new \KORA_Clause('KID', '=', $issue_kid), array('Editors'), array());

    getSidebar('issue', $issue_kid);
?>

<script src="<?php bloginfo('template_url'); ?>/js/record.js"></script>

<div id="main" class="journalSingleVolume">
    <div id="content">
	<?php echo $post->post_content; ?>
        <div id="volumeContent">
            <br/><br/><br/>

            <h1>The Editors</h1>
            <p id="editors_text"><?php echo $issue[$issue_kid]['Editors']; ?></p>
        </div>

    </div>
</div>

<?php get_footer(); ?>

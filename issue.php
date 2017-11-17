<?php
    /**
     * Template Name: Issue
     */

    get_header();

    require_once(BASE_PATH_KORA.'/api/orm-includes.php');
    require_once(BASE_PATH_KORA.'/includes/koraSearch.php');
    require_once('functions/get-sidebar.php');

    $kid = $_GET['kid'];
    $issues = KORA_search(token, projectID, Issue, new \KORA_Clause('KID', '=', $kid), array('Volume', 'Issue', 'File', 'Year', 'Period', 'Cover', 'Introduction', 'Editors'), array());

    $issue = $issues[$kid];
    //Clause declarations
    $issueClause = new \KORA_Clause('Issue Associator', '=', $kid);
    $articleClause = new \KORA_Clause('Object Type', '=', 'Article');
    $imageClause = new \KORA_Clause('Object Type', '=', 'Image');
    $audioClause = new \KORA_Clause('Object Type', '=', 'Audio');
    $videoClause = new \KORA_Clause('Object Type', '=', 'Video');

    //Get an array of objects that correspond to the issue and object type
    $articles = KORA_search(token, projectID, Object, new \KORA_Clause($issueClause, 'AND', $articleClause), array('Title','Creator', 'Description'), array());
    $images = KORA_search(token, projectID, Object, new \KORA_Clause($issueClause, 'AND', $imageClause), array('Title','Creator', 'Description', 'Image'), array());
    $audio = KORA_search(token, projectID, Object, new \KORA_Clause($issueClause, 'AND', $audioClause), array('Title','Creator', 'Description'), array());
    $videos = KORA_search(token, projectID, Object, new \KORA_Clause($issueClause, 'AND', $videoClause), array('Title','Creator', 'Description', 'Image'), array());

?>

<div id="main" class="journalSingleVolume">
  <?php getSidebar('issue', $kid, $issue); ?>
	<div class="content" id="issue-wrap">
	<?php echo $post->post_content; ?>
        <div id="volumeContent">
            <h1 class="content-header" id="intro">Introduction</h1>
            <p class="content-body"><?php echo $issue['Introduction']; ?></p>

            <h1 class="content-header" id="editors">Editors</h1>
            <p class="content-body"><?php echo $issue['Editors']; ?></p>

            <?php
            if (!empty($articles)) {
                ?>
                <h1 class="content-header" id="article-header">Articles</h1>
                <?php
                foreach ($articles as $article) {
                    ?>
                	<h2 class="title-of-content"><?php echo $article['Title']; ?></h2>
                	<p class="authors-names"> <?php echo implode($article['Creator']); ?></p>
                  <p class="content-description"> <?php echo $article['Description']; ?></p>
                  <a class="view-content" href="<?php bloginfo('wpurl'); ?>/record/?issue=<?php echo $kid; ?>&kid=<?php echo $article['kid']; ?>">View Article</a>
                  <p class="divider-line"></p>
                <?php

                } ?>
            <?php

            }

            if (!empty($images)) {
                ?>
                <h1 class="content-header" id="images">Images</h1>
                <?php
                foreach ($images as $image) {
                    $img_URL = BASE_URL_KORA . 'files/' . projectID . '/' . Object . '/' . $image['Image']['localName']; ?>
                    <div class="issue-image-wrap">
                      <img src="<?php echo $img_URL?>" height="168"/>
                      <div class="issue-image-info">
                        <h2 class="image-title-of-content"><?php echo $image['Title']; ?></h2>
                      	<p class="authors-names"> <?php echo implode($image['Creator']); ?></p>
                        <p class="content-description"> <?php echo $image['Description']; ?></p>
                        <a class="view-content" href="<?php bloginfo('wpurl'); ?>/record/?issue=<?php echo $kid; ?>&kid=<?php echo $image['kid']; ?>">View Image</a>
                      </div>
                    </div>
                    <p class="divider-line"></p>
                <?php

                } ?><br/>
            <?php

            }

            if (!empty($audio)) {
                ?>
                <h1 class="content-header" id="audios">Audio</h1>
                <?php
                foreach ($audio as $aud) {
                    ?>
                    <h2 class="title-of-content"><?php echo $aud['Title']; ?></h2>
                  	<p class="authors-names"> <?php echo implode($aud['Creator']); ?></p>
                    <p class="content-description"> <?php echo $aud['Description']; ?></p>
                    <a class="view-content" href="<?php bloginfo('wpurl'); ?>/record/?issue=<?php echo $kid; ?>&kid=<?php echo $aud['kid']; ?>">Listen to Audio</a>
                    <p class="divider-line"></p>
                <?php

                } ?><br/>
            <?php

            }

            if (!empty($videos)) {
                ?>
                <h1 class="content-header" id="videos">Video</h1>
                <?php
                foreach ($videos as $video) {
                    $img_URL = BASE_URL_KORA . 'files/' . projectID . '/' . Object . '/' . $video['Image']['localName']; ?>
                    <div class="issue-image-wrap">
                      <img src="<?php echo $img_URL?>" height="168"/>
                      <div class="issue-image-info">
                        <h2 class="image-title-of-content"><?php echo $video['Title']; ?></h2>
                        <p class="authors-names"> <?php echo implode($video['Creator']); ?></p>
                        <p class="content-description"> <?php echo $video['Description']; ?></p>
                        <a class="view-content" href="<?php bloginfo('wpurl'); ?>/record/?issue=<?php echo $kid; ?>&kid=<?php echo $video['kid']; ?>">Watch Video</a>
                      </div>
                    </div>
                    <p class="divider-line"></p>
                <?php

                } ?><br/>
            <?php

            } ?>
        </div>

	</div>
  <script src="<?php bloginfo('template_url'); ?>/js/record.js"></script>
</div>
<?php get_footer(); ?>

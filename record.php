<?php
     /**
      * Template Name: Record
      */

    get_header();

    require_once(BASE_PATH_KORA.'/api/orm-includes.php');
    require_once(BASE_PATH_KORA.'/includes/koraSearch.php');
    require_once('functions/get-sidebar.php');

    $kid = $_GET['kid'];

    $object = KORA_search(token, projectID, Object, new \KORA_Clause('KID', '=', $kid), array('Credit Line', 'Issue Associator', 'Creator', 'Title', 'Date Original', 'Description', 'Transcript', 'Rights Management', 'Contributing Institution', 'Comments', 'Image', 'Audio File', 'Video File','Text File', 'HTML File'), array());
    if (isset($_GET['issue'])) {
        $iss_kid = $_GET['issue'];
        $issue = KORA_Search(token, projectID, Issue, new \KORA_Clause('KID', '=', $iss_kid), array('Volume', 'Issue', 'Period', 'Year'), array());
    }
?>

<script src="<?php bloginfo('template_url'); ?>/js/record.js"></script>
<script>var issue = <?php echo json_encode($issue[$iss_kid]) ?></script>

<div id="main" class="journalSingleVolume">
  <?php
      if ($object[$kid]['Issue Associator'][0] != '') {
          getSidebarRecord('kid', $kid, $object[$kid], $issue[$iss_kid]);
      }
   ?>
	<div class="content" id="article-wrap">
	<?php echo $post->post_content; ?>
        <div id="volumeContent">
          <?php
            if ($object[$kid]['Image'] != '' && $object[$kid]['Video File'] == '') {
                if ($object[$kid]['Image']['localName'] != '') {
                    ?>
                    <img id="record-image" src="<?php echo BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $object[$kid]['Image']['localName']; ?>" alt="Image"/>
            <?php

                }
            } elseif ($object[$kid]['Audio File'] != '') {
                if ($object[$kid]['Audio File']['localName'] != '') {
                    ?>
                  <audio id="record-audio" controls>
                    <source id="record-audio" src="<?php echo BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $object[$kid]['Audio File']['localName']; ?>"/>\
                  </audio>
          <?php

                }
            } elseif ($object[$kid]['Video File'] != '') {
                if ($object[$kid]['Video File']['localName'] != '') {
                    ?>
                  <video id="record-video" controls>
                    <source id="record-video" src="<?php echo BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $object[$kid]['Video File']['localName']; ?>"/>
                  </video>
          <?php

                }
            }

           ?>
            <?php echo '<script>console.log(file_get_contents($path))</script>'; ?>

			 <h2 id="record-title" class="content-header <?php echo ($object[$kid]['Image'] != '' || $object[$kid]['Audio File'] != '' || $object[$kid]['Video File'] != '') ? 'alt-record-title' : null; ?>"><?php echo $object[$kid]['Title']; ?></h2>
			 <h3 id="record-author" class="authors-names"><?php echo implode($object[$kid]['Creator']); ?></h3>
            <?php
              if ($object[$kid]['HTML File'] != '') {
                  if ($object[$kid]['HTML File']['localName'] != '') {
                      $path=BASE_PATH_KORA . "files/" . projectID . "/" . Object . "/" . $object[$kid]['HTML File']['localName']; ?>
                    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/article.css">
                    <div class="article-content" style=""><?php print file_get_contents($path); ?></div>
                    <script src="<?php bloginfo('template_url'); ?>/js/article.js"></script>
                    <script>
                      constructArticle();
                    </script>

            <?php
                      
                  }
              }?>


            <p id="record-description"><?php echo $object[$kid]['Description']; ?></p>
            <!-- <p id="record-transcript"><?php echo $object[$kid]['Transcript']; ?></p>-->

            <p class="divider-line"></p>
            <div id="record-comments">
                <h2 id="comments-header">Comments</h2>
                <?php
                if (!empty($object[$kid]['Comments'])) {
                    foreach ($object[$kid]['Comments'] as $comment_kid) {
                        $comment = KORA_search(token, projectID, Comments, new \KORA_Clause('KID', '=', $comment_kid), array('Comment', 'Contributor'), array()); ?>

                      <h3 class="record-contributor"><?php echo $comment[$comment_kid]['Contributor']; ?></h3>
                      <p class="record-comment"><?php echo $comment[$comment_kid]['Comment']; ?></p>
                  <?php

                    }
                } else {
                    ?>
                  <p class="record-contributor">No comments available to display.</p>
                <?php

                }?>

                <?php
                    if ($result[0]->{Community} != '') {
                        ?>
                    <p id="ppj-link">
                        <a href="<?php echo $object[$kid]['Community']; ?>">Join the discussion within the PPJ Community</a>
                    </p>
                <?php

                    } ?>
            </div>
            <p class="divider-line"></p>
            <div id="educational-use">
              <p><?php echo $object[$kid]['Rights Management']; ?></p>
              <p><?php echo $object[$kid]['Contributing Institution']; ?></p>
            </div>
        </div>

	</div>
</div>

<?php get_footer(); ?>

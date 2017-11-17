<?php
    /**
     * Template Name: Browse
     */
    get_header();

    require_once(BASE_PATH_KORA.'/api/orm-includes.php');
    require_once(BASE_PATH_KORA.'/includes/koraSearch.php');


    $sort_order = $_REQUEST['sort'] == 'oldest' ? SORT_ASC : SORT_DESC;

    $issueSeason = array();
    $issueYear = array();

    $objects;

    if (isset($_REQUEST['search'])) {
        $search_term = filter_var($_REQUEST['search'], FILTER_SANITIZE_STRING);
        $clause1 = new KORA_Clause('Title', 'LIKE', '%'.$search_term.'%');
        $clause2 = new KORA_Clause('Creator', 'LIKE', '%'.$search_term.'%');

        $clause3 = new KORA_Clause($clause1, 'OR', $clause2);
        $clause4 = new \KORA_Clause('KID', '!=', '');

        $objects = KORA_search(token, projectID, Object, new \KORA_Clause($clause3, 'AND', $clause4), array('Issue Associator', 'Title', 'Creator', 'Date Original', 'Image','Cover', 'Object Type'), array(array('field'=>'Date Original', 'direction'=>$sort_order)));
    } else {
        $objects = KORA_search(token, projectID, Object, new \KORA_Clause('KID', '!=', ''), array('Issue Associator', 'Title', 'Creator', 'Date Original', 'Image','Cover', 'Object Type'), array(array('field'=>'Date Original', 'direction'=>$sort_order)));
    }
    $issues = KORA_search(token, projectID, Issue, new \KORA_Clause('KID', '!=', ''), array('Volume', 'Issue', 'Year', 'Period'), array(array('field'=>'Volume', 'direction'=>$sort_order), array('field'=>'Issue', 'direction'=>$sort_order)));

    //Make two associative arrays so that we can get the year and season by issue KID
    $years = [];
    foreach ($issues as $issue) {
        $issueSeason[$issue['kid']] = $issue['Period'][0];
        $issueYear[$issue['kid']] = $issue['Year']['year'];
        array_push($years, intval($issue['Year']['year']));
    }

    $years = array_unique($years);
    rsort($years);

    function compareByTitle($a, $b)
    {
        return strcmp($a["Title"], $b["Title"]);
    }

    function compareByAuthor($a, $b)
    {
        return strcmp($a["Creator"][0], $b["Creator"][0]);
    }

    if ($_REQUEST['sort'] == 'azTitle') {
        usort($objects, 'compareByTitle');
    } elseif ($_REQUEST['sort'] == 'azAuthor') {
        usort($objects, 'compareByAuthor');
    }

?>

<div id="main" class="">
	<div id="content" class="browsing">
    <aside class="volumesAside" id="browseAside" style="margin-top:23px;">
      <div class="asideHeading">Sort By</div>
      <div class="items">
        <a href= "browse?<?php
          echo $_REQUEST['format'] ? 'format=' . $_REQUEST['format'] : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['sort'] == '' ? 'selected' : ''?>" >Most Recent</a>
        <a href= "browse?sort=oldest<?php
          echo $_REQUEST['format'] ? '&format=' . $_REQUEST['format'] : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['sort'] == 'oldest' ? 'selected' : ''?>" >Oldest</a>
        <a href= "browse?sort=azTitle<?php
          echo $_REQUEST['format'] ? '&format=' . $_REQUEST['format'] : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['sort'] == 'azTitle' ? 'selected' : ''?>" >Title (A-Z)</a>
        <a href= "browse?sort=azAuthor<?php
          echo $_REQUEST['format'] ? '&format=' . $_REQUEST['format'] : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['sort'] == 'azAuthor' ? 'selected' : ''?>" >Author (A-Z)</a>
      </div>
      <div class="asideHeading">Format</div>
      <div class="items">
        <a href= "browse?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] . '&' : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : '';?>"
          class="sort <?php echo $_REQUEST['format'] == '' ? 'selected' : ''?>" >All</a>
        <?php
        $formats = ['article', 'image', 'video', 'audio'];
        foreach ($formats as $format) {
            ?>
        <a href= "browse?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] . '&' : '';
            echo 'format=' . $format;
            echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['format'] == $format ? 'selected' : ''?>" >
          <?php echo ucfirst($format); ?>
        </a>
        <?php

        } ?>
      </div>
      <div class="asideHeading">Date</div>
      <div class="items">
        <a href= "browse?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] : '';
          echo $_REQUEST['format'] ? '&format=' . $_REQUEST['format'] : '' ?>"
          class="sort <?php echo $_REQUEST['date'] == $year ? 'selected' : ''?>" >Any</a>
      <?php
       foreach ($years as $year) {
           ?>
        <a href= "browse?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] . '&' : '';
           echo $_REQUEST['format'] ? 'format=' . $_REQUEST['format'] . '&' : '';
           echo 'date=' . $year ?>" class="sort <?php echo $_REQUEST['date'] == $year ? 'selected' : ''?>" ><?php echo $year; ?></a>
      <?php

       } ?>
      </div>

    </aside>
		<?php echo $post->post_content; ?>
    <div id="content-wrap">
      <form id="searchForm" action="" method="post">
        <input type="text" id="search" name="search" >
        <img id="searchImg" src="<?php bloginfo('template_url'); ?>/images/Search.png">
      </form>
  		<div class="browse"><?php
              foreach ($objects as $object) {
                  $objectSeason = $issueSeason[$object['Issue Associator'][0]];
                  $objectYear = $issueYear[$object['Issue Associator'][0]];
                  $title = $object['Title'];
                  $objectImage = $object['Image'];

                  if ($_REQUEST['format'] != null) {
                      if ($object['Object Type'] == 'Image' && $_REQUEST['format'] != 'image') {
                          continue;
                      } elseif ($object['Object Type'] == 'Video' && $_REQUEST['format'] != 'video') {
                          continue;
                      } elseif ($object['Object Type'] == 'Article' && $_REQUEST['format'] != 'article') {
                          continue;
                      } elseif ($object['Object Type'] == 'Audio' && $_REQUEST['format'] != 'audio') {
                          continue;
                      }
                  }

                  if ($_REQUEST['date'] != null && $_REQUEST['date'] != $objectYear) {
                      continue;
                  } ?>
  				<div class="contentBlock"><?php
                      if ($object['Image'] != '') {
                          ?>
                          <a href="<?php bloginfo('wpurl'); ?>/record/?kid=<?php echo $object['kid']; ?>&issue=<?php echo $object['Issue Associator'][0]?>">
                              <img src="<?php echo BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $object['Image']['localName']; ?>" alt="Journal Volume Image"/>
                          </a><?php

                      } else {
                          if ($object['Cover']!='') { // possibly article or video
                              ?>
                							<a href="<?php bloginfo('wpurl'); ?>/record/?kid=<?php echo $object['kid']; ?>&issue=<?php echo $object['Issue Associator'][0]?>">
                								<img src="<?php echo BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $object['Cover']['localName']; ?>" alt="Record"/>
                							</a><?php

                          } else {
                              ?>
                							<a href="<?php bloginfo('wpurl'); ?>/record/?kid=<?php echo $object['kid']; ?>&issue=<?php echo $object['Issue Associator'][0]?>">
                								<img src="<?php bloginfo('template_url'); ?>/images/journal/defaultImage.svg" alt="Record"/>
                							</a><?php

                          }
                      } ?>

           <a href="<?php bloginfo('wpurl'); ?>/record/?kid=<?php echo $object['kid']; ?>&issue=<?php echo $object['Issue Associator'][0]?>">
            <div class="text">
              <p class="title"><?php echo $title; ?></p><?php
                      if ($objectSeason != '' && $objectYear != '') {
                          ?>
              <p class="season"><?php echo $objectSeason; ?> <?php echo $objectYear; ?></p><?php

                      } else {
                          ?>
              <p class="season">Season Not Available</p><?php

                      }

                  if ($object['Creator'][0] != '') {
                      ?>
              <p class="author"><?php echo implode($object['Creator']); ?></p><?php

                  } else {
                      ?>
              <p class="author">Author Not Available</p>
          <?php

                  } ?>
            </div>
          </a>
  				</div><?php

              } ?>
  		</div>
    </div>
	</div>
</div>

<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
  $('.browse').masonry({
    // options
    itemSelector: '.contentBlock',
    colomnWidth: 229,
    fitWidth: false,
    horizontalOrder: true
  });

  $(window).resize(function() {
    $("#searchForm").width($(".browse").width()-50);
  });
  $("#searchForm").width($(".browse").width()-50);

  $("#searchImg").click(function() {
    $("#searchForm").submit();
  });
</script>

<?php get_footer(); ?>

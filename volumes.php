<?php
    /**
     * Template Name: Volumes
     */

    get_header();

    require_once(BASE_PATH_KORA.'/api/orm-includes.php');
    require_once(BASE_PATH_KORA.'/includes/koraSearch.php');


    $sort_order = $_REQUEST['sort'] == 'oldest' ? SORT_ASC : SORT_DESC;

    $issues = KORA_search(token, projectID, Issue, new \KORA_Clause('KID', '!=', ''), array('Volume', 'Issue', 'Year', 'Period', 'Cover'), array(array('field'=>'Volume', 'direction'=>$sort_order), array('field'=>'Issue', 'direction'=>$sort_order)));

    $years = [];
    $indexes_to_remove = [];
    foreach ($issues as $key=>$issue) {
        array_push($years, intval($issue['Year']['year']));
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != $issue['Year']['year']) {
            array_push($indexes_to_remove, $key);
        }
    }

    foreach ($indexes_to_remove as $key) {
        unset($issues[$key]);
    }


    $years = array_unique($years);
    rsort($years);
?>
<script src="<?php bloginfo('template_url'); ?>/js/record.js"></script>
<div id="main">
	<div id="content" class="volumes">
    <aside class="volumesAside">
      <div class="Search"><div class="boxSearch" contenteditable="true"></div><a href="#" class="searchText">Search</a><a class="searchIcon" href="#"><img src="<?php bloginfo('template_url'); ?>/images/Search.png"/></a></div>
      <div class="Browse"><a href="http://publications.publicphilosophyjournal.org/browse">Browse</a></div>
      <div class="asideHeading" style="margin-bottom:25px;text-decoration:underline;">Sort By</div>
      <div class="asideHeading">Volumes:</div>
      <div class="items">
        <a href= "volumes?<?php
          echo $_REQUEST['format'] ? 'format=' . $_REQUEST['format'] : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['sort'] == '' ? 'selected' : ''?>" >Most Recent</a>
        <a href= "volumes?sort=oldest<?php
          echo $_REQUEST['format'] ? '&format=' . $_REQUEST['format'] : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['sort'] == 'oldest' ? 'selected' : ''?>" >Oldest</a>
      </div>
      <div class="asideHeading">Format:</div>
      <div class="items">
        <a href= "volumes?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] . '&' : '';
          echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : '';?>"
          class="sort <?php echo $_REQUEST['format'] == '' ? 'selected' : ''?>" >All</a>
        <?php
        $formats = ['text', 'image', 'video', 'audio'];
        foreach ($formats as $format) {
            ?>
        <a href= "volumes?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] . '&' : '';
            echo 'format=' . $format;
            echo $_REQUEST['date'] ? '&date=' . $_REQUEST['date'] : ''; ?>"
          class="sort <?php echo $_REQUEST['format'] == $format ? 'selected' : ''?>" >
          <?php echo ucfirst($format); ?>
        </a>
        <?php

        } ?>
      </div>
      <div class="asideHeading">Date:</div>
      <div class="items">
        <a href= "volumes?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] : '';
          echo $_REQUEST['format'] ? '&format=' . $_REQUEST['format'] : '' ?>"
          class="sort <?php echo $_REQUEST['date'] == $year ? 'selected' : ''?>" >Any</a>
      <?php
      foreach ($years as $year) {
          ?>
        <a href= "volumes?<?php
          echo $_REQUEST['sort'] ? 'sort=' . $_REQUEST['sort'] . '&' : '';
          echo $_REQUEST['format'] ? 'format=' . $_REQUEST['format'] . '&' : '';
          echo 'date=' . $year ?>" class="sort <?php echo $_REQUEST['date'] == $year ? 'selected' : ''?>" ><?php echo $year; ?></a>
      <?php

      } ?>
    </div>

    </aside>
		<div id="volumesContent">
      <ul class="volumes-ul">
			<?php
                foreach ($issues as $issue) {
                    $volumeNumber = $issue['Volume'];
                    $issueNumber = $issue['Issue'];
                    $issueCoverURL = BASE_URL_KORA . 'files/' . projectID . '/' . Issue . '/' . $issue['Cover']['localName'];
                    $period = $issue['Period'][0];
                    $year = $issue['Year']['year']; ?>

            <li class="volumes-li">
                <a href="<?php bloginfo('wpurl'); ?>/issue?kid=<?php echo $issue['kid']; ?>">
                    <img src="<?php echo $issueCoverURL ?>" width="580" height="388" alt="Record"/>
                </a>

                <div class="volumes-title">Volume <?php echo $volumeNumber; ?>, <?php echo $issueNumber; ?></div>
                <p class="volumes-subtext"><?php echo $period; ?> <?php echo $year; ?></p>
             </li>
			<?php

                } ?>
      </ul>
		</div>
	</div>
</div>
<script>
  function adjustResultsCenter() {
  	if (parseInt($(window).width()) <= 459) {
  		$("#volumesContent > .volumes-ul").css("margin", "0");
  	}
  	else {
  		var ul = $("#volumesContent > .volumes-ul");
  		var totalWidth = ul.outerWidth(true) - (ul.outerWidth() - ul.width());
  		var li = $("#volumesContent .volumes-li");
  		var recordWidth = li.outerWidth(true);
  		var margin = ((totalWidth % recordWidth) / 2);
  		ul.css("margin", ("0 " + Math.floor(margin) + "px"));
  	}
  }

  $(window).resize(function () {
    adjustResultsCenter();
  });
  adjustResultsCenter();
</script>

<?php get_footer(); ?>

<?php
function getSidebar($type, $kid, $issue)
{

    //Clauses for KORA Search
    if ($type != 'issue') {
        $issue_kid = KORA_Search(token, projectID, Object, new \KORA_Clause('KID', '=', $kid), array('Issue Associator'), array());
        $issue_kid = $issue_kid[$kid]['Issue Associator'][0];
    } else {
        $issue_kid = $kid;
    }

    $volume_cover_URL = BASE_URL_KORA . 'files/' . projectID . '/' . Issue . '/' . $issue['Cover']['localName'];
    $volumeNumber = $issue['Volume'];
    $issueNumber = $issue['Issue'];
    if ($issue['File']) {
        $pdf = BASE_URL_KORA . "files/" . projectID . "/" . Issue . "/" . $issue['File']['localName'];
    }

    $period = $issue['Period'][0];
    $year = $issue['Year']['year'];
    // $issue_file_URL = BASE_URL_KORA . 'files/' . projectID . '/' . Issue . '/' . $issue['File']["localName"];

    $issue_clause = new \KORA_Clause('Issue Associator', '=', $issue_kid);
    $article_clause = new \KORA_Clause('Object Type', '=', 'Article');
    $image_clause = new \KORA_Clause('Object Type', '=', 'Image');
    $audio_clause = new \KORA_Clause('Object Type', '=', 'Audio');
    $video_clause = new \KORA_Clause('Object Type', '=', 'Video');

    //Search for each object type
    $article_arr = KORA_Search(token, projectID, Object, new \KORA_Clause($issue_clause, 'AND', $article_clause), array('Title'), array());
    $image_arr = KORA_Search(token, projectID, Object, new \KORA_Clause($issue_clause, 'AND', $image_clause), array('Title'), array());
    $audio_arr = KORA_Search(token, projectID, Object, new \KORA_Clause($issue_clause, 'AND', $audio_clause), array('Title'), array());
    $video_arr = KORA_Search(token, projectID, Object, new \KORA_Clause($issue_clause, 'AND', $video_clause), array('Title'), array()); ?>

    <aside class="volumesAside" id="issueSideBar">
        <a id="backToVolumes" href="<?php echo BASE_URL; ?>volumes">&lt;&nbsp;Back to All Volumes</a>
        <img src="<?php echo $volume_cover_URL ?>" alt="Record"/>
        <div class="volumes-title">Volume <?php echo $volumeNumber; ?>, <?php echo $issueNumber; ?></div>
        <p class="volumes-subtext" id="issue-aside-subtext"><?php echo $period; ?> <?php echo $year; ?></p>
        <?php if ($issue['File']) { ?>
            <a class="pdf-download" href = "<?php echo $pdf ?>" download > Download PDF </a >
         <?php } ?>



            <?php
            if ($type == 'editors') {
                ?>
                <p><a href="<?php echo BASE_URL; ?>introduction/?kid=<?php echo $issue_kid; ?>">Introduction</a></p>
                <p>Editors</p><?php

            } elseif ($type == 'introduction') {
                ?>
                <p>Introduction</p>
                <p><a href="<?php echo BASE_URL; ?>editors/?kid=<?php echo $issue_kid; ?>">Editors</a></p><?php

            } else {
                ?>
                <p class="sidebar-text" id="introduction_link">Introduction</p>
                <p class="sidebar-text" id="editors_link">Editors</p><?php

            }

    if (!empty($article_arr)) {
        buildContainer('article', $article_arr, $kid);
    }

    if (!empty($image_arr)) {
        buildContainer('image', $image_arr, $kid);
    }

    if (!empty($audio_arr)) {
        buildContainer('audio', $audio_arr, $kid);
    }

    if (!empty($video_arr)) {
        buildContainer('video', $video_arr, $kid);
    } ?>
            <br/>


    </aside>
<?php

}

function getSidebarRecord($type, $kid, $obj, $iss)
{
    $year = $iss['Year']['year'];
    $period = $iss['Period'][0];
    ?>

    <aside class="volumesAside" id="issueSideBar">
        <a id="backToVolumes" href="<?php echo BASE_URL; ?>issue/?kid=<?php echo $iss['kid']?>">&lt;&nbsp;Back to Issue</a>
        <h2 class="title-article-aside"><?php echo $obj['Title']; ?></h2>
        <p class="authors-aside"><?php echo implode($obj['Creator']); ?></p>
        <p class="volumes-subtext" id="issue-aside-subtext"><?php echo $period; ?> <?php echo $year; ?></p>
    <?php if ($obj['Image'] != '' && $obj['Video File'] == '') {
        $issue_file_URL = BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $obj['Image']['localName'];
        ; ?>
          <a target="_blank" class="pdf-download" id="pdf-record" href="<?php echo $issue_file_URL ?>">Download Image</a>
    <?php

    } elseif ($obj['HTML File'] != '' || $obj['Text File']) {
        $issue_file_URL = BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $obj['Text File']['localName'];
        if (pathinfo($issue_file_URL)['extension'] == "pdf"){?>
          <a class="pdf-download" id="pdf-record" href="<?php echo $issue_file_URL ?>" download>Download PDF</a>
  <?php }

    } elseif ($obj['Audio File'] != '') {
        $issue_file_URL = BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $obj['Audio File']['localName']; ?>
          <a target="_blank" class="pdf-download" id="pdf-record" href="<?php echo $issue_file_URL ?>">Download Audio</a>
    <?php

    } elseif ($obj['Video File'] != '') {
        $issue_file_URL = BASE_URL_KORA . "files/" . projectID . "/" . Object . "/" . $obj['Video File']['localName']; ?>
          <a target="_blank" class="pdf-download" id="pdf-record" href="<?php echo $issue_file_URL ?>">Download Video</a>
    <?php

    } ?>
    </aside>
<?php

}

//builds object containers
function buildContainer($type, $object_arr, $kid)
{
    $html = '';

    if ($type == 'article') {
        $html = 'Articles';
    } elseif ($type == 'image') {
        $html = 'Images';
    } elseif ($type == 'audio') {
        $html = 'Audio';
    } elseif ($type == 'video') {
        $html = 'Video';
    } ?>

    <div class="<?php echo $type; ?>_container">
		<p class="sidebar-text" id="<?php echo $type; ?>_dropdown">
            <?php echo $html; ?> <!--<i class="fa fa-chevron-down fa-1" style="font-size:12px" aria-hidden="true"></i>-->
        </p>
	</div><?php

} ?>

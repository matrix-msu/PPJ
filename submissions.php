<?php 
    /**
     * Template Name: Submissions
     */
    get_header();

/*
    require_once(BASE_PATH_KORA.'/api/orm-includes.php');
    require_once(BASE_PATH_KORA.'/includes/koraSearch.php');

    $issueSeason = array();
    $issueYear = array();

    $objects = KORA_search(token, projectID, Object, new \KORA_Clause('KID', '!=', ''), array('Issue Associator', 'Title', 'Creator', 'Date Original', 'Image'), array(array('field'=>'Date Original', 'direction'=>SORT_DESC)));
    $issues = KORA_search(token, projectID, Issue, new \KORA_Clause('KID', '!=', ''), array('Volume', 'Issue', 'Year', 'Period'), array(array('field'=>'Volume', 'direction'=>SORT_DESC), array('field'=>'Issue', 'direction'=>SORT_DESC)));

    //Make two associative arrays so that we can get the year and season by issue KID
    foreach($issues as $issue){
        $issueSeason[$issue['kid']] = $issue['Period'][0];
        $issueYear[$issue['kid']] = $issue['Year']['year'];
    }
*/
?>

<div id="main">
	<div id="content">
			<?php echo $post->post_content; ?>
	</div>
</div>

<?php get_footer(); ?>

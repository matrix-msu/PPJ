<?php 
require_once('../config.php');
require_once(BASE_PATH_KORA.'/api/orm-includes.php');
require_once(BASE_PATH_KORA.'/includes/koraSearch.php');

$objectArray = array();
$issueSeason = array();
$issueYear = array();
$result = array();
$associators = array();

$issues = KORA_search(token, projectID, Issue, new \KORA_Clause('KID', '!=', ''), array('Volume', 'Issue', 'Year', 'Period'), array(array('field'=>'Volume', 'direction'=>SORT_DESC), array('field'=>'Issue', 'direction'=>SORT_DESC)));

//Find the issues which contain the digital year we are filtering by and
//make an two associative arrays so that we can get the year and season by issue KID
foreach($issues as $issue){
	if(isset($_POST['dateDigital'])){
		if($issue['Year']['year'] == $_POST['dateDigital'])
			array_push($associators, $issue['kid']); 
	}
	
	$issueSeason[$issue['kid']] = $issue['Period'][0];
	$issueYear[$issue['kid']] = $issue['Year']['year'];
}

$objectClause = new \KORA_Clause('KID', '!=', '');
if(isset($_POST['originalFormat'])){
	$filterClause = new \KORA_Clause('Object Type', '=', $_POST['originalFormat']);
	$objects = KORA_search(token, projectID, Object, new \KORA_Clause($objectClause, 'AND', $filterClause), array('Issue Associator', 'Title', 'Creator', 'Date Original', 'Image'), array(array('field'=>'Date Original', 'direction'=>SORT_DESC)));
	$objectArray = $objects;
}

if(isset($_POST['dateDigital'])){
	$objects = KORA_search(token, projectID, Object, new \KORA_Clause('KID', '!=', ''), array('Issue Associator', 'Title', 'Creator', 'Date Original', 'Image'), array(array('field'=>'Date Original', 'direction'=>SORT_DESC)));
	foreach($objects as $object){
		if(!empty($object['Issue Associator'][0])){
			if(in_array($object['Issue Associator'][0], $associators)){
				$objectArray[$object['kid']] = $object;		
			}
		}
	}
}

array_push($result, $objectArray);
array_push($result, $issueSeason);
array_push($result, $issueYear);

echo json_encode($result);

?>


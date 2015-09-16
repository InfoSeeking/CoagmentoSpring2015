<?php


session_start();
require_once('../core/Base.class.php');
require_once('../core/Util.class.php');
require_once('../core/Connection.class.php');
require_once('../core/Questionnaires.class.php');






function commitanswer_intention(){
	$base = Base::getInstance();
	$cxn = Connection::getInstance();
	$userID = $base->getUserID();
	$projectID = $base->getProjectID();
	$stageID = $base->getStageID();
	$questionID = $base->getQuestionID();
	$timestamp = $base->getTimestamp();
	$date = $base->getDate();
	$time = $base->getTime();

	$id_start = 0;
	$id_more = 0;
	$learn_feature = 0;
	$learn_structure = 0;
	$learn_domain = 0;
	$learn_database = 0;
	$find_known = 0;
	$find_specific = 0;
	$find_common = 0;
	$find_without = 0;
	$locate_specific = 0;
	$locate_common = 0;
	$locate_area = 0;
	$keep_bibliographical = 0;
	$keep_link = 0;
	$keep_item = 0;
	$access_item = 0;
	$access_common = 0;
	$access_area = 0;
	$evaluate_correctness = 0;
	$evaluate_specificity = 0;
	$evaluate_usefulness = 0;
	$evaluate_best = 0;
	$evaluate_duplication = 0;
	$obtain_specific = 0;
	$obtain_part = 0;
	$obtain_whole = 0;




	$id_start_radio = '';
	$id_more_radio = '';
	$learn_feature_radio = '';
	$learn_structure_radio = '';
	$learn_domain_radio = '';
	$learn_database_radio = '';
	$find_known_radio = '';
	$find_specific_radio = '';
	$find_common_radio = '';
	$find_without_radio = '';
	$locate_specific_radio = '';
	$locate_common_radio = '';
	$locate_area_radio = '';
	$keep_bibliographical_radio = '';
	$keep_link_radio = '';
	$keep_item_radio = '';
	$access_item_radio = '';
	$access_common_radio = '';
	$access_area_radio = '';
	$evaluate_correctness_radio = '';
	$evaluate_specificity_radio = '';
	$evaluate_usefulness_radio = '';
	$evaluate_best_radio = '';
	$evaluate_duplication_radio = '';
	$obtain_specific_radio = '';
	$obtain_part_radio = '';
	$obtain_whole_radio = '';




	$id_start_text = '';
	$id_more_text = '';
	$learn_feature_text = '';
	$learn_structure_text = '';
	$learn_domain_text = '';
	$learn_database_text = '';
	$find_known_text = '';
	$find_specific_text = '';
	$find_common_text = '';
	$find_without_text = '';
	$locate_specific_text = '';
	$locate_common_text = '';
	$locate_area_text = '';
	$keep_bibliographical_text = '';
	$keep_link_text = '';
	$keep_item_text = '';
	$access_item_text = '';
	$access_common_text = '';
	$access_area_text = '';
	$evaluate_correctness_text = '';
	$evaluate_specificity_text = '';
	$evaluate_usefulness_text = '';
	$evaluate_best_text = '';
	$evaluate_duplication_text = '';
	$obtain_specific_text = '';
	$obtain_part_text = '';
	$obtain_whole_text = '';



	if(isset($_POST[ "id_start"])){
		$id_start = 1;
	}
	if(isset($_POST[ "id_more"])){
		$id_more = 1;
	}
	if(isset($_POST[ "learn_feature"])){
		$learn_feature = 1;
	}
	if(isset($_POST[ "learn_structure"])){
		$learn_structure = 1;
	}
	if(isset($_POST[ "learn_domain"])){
		$learn_domain = 1;
	}
	if(isset($_POST[ "learn_database"])){
		$learn_database = 1;
	}
	if(isset($_POST[ "find_known"])){
		$find_known = 1;
	}
	if(isset($_POST[ "find_specific"])){
		$find_specific = 1;
	}
	if(isset($_POST[ "find_common"])){
		$find_common = 1;
	}
	if(isset($_POST[ "find_without"])){
		$find_without = 1;
	}
	if(isset($_POST[ "locate_specific"])){
		$locate_specific = 1;
	}
	if(isset($_POST[ "locate_common"])){
		$locate_common = 1;
	}
	if(isset($_POST[ "locate_area"])){
		$locate_area = 1;
	}
	if(isset($_POST[ "keep_bibliographical"])){
		$keep_bibliographical = 1;
	}
	if(isset($_POST[ "keep_link"])){
		$keep_link = 1;
	}
	if(isset($_POST[ "keep_item"])){
		$keep_item = 1;
	}
	if(isset($_POST[ "access_item"])){
		$access_item = 1;
	}
	if(isset($_POST[ "access_common"])){
		$access_common = 1;
	}
	if(isset($_POST[ "access_area"])){
		$access_area = 1;
	}
	if(isset($_POST[ "evaluate_correctness"])){
		$evaluate_correctness = 1;
	}
	if(isset($_POST[ "evaluate_specificity"])){
		$evaluate_specificity = 1;
	}
	if(isset($_POST[ "evaluate_usefulness"])){
		$evaluate_usefulness = 1;
	}
	if(isset($_POST[ "evaluate_best"])){
		$evaluate_best = 1;
	}
	if(isset($_POST[ "evaluate_duplication"])){
		$evaluate_duplication = 1;
	}
	if(isset($_POST[ "obtain_specific"])){
		$obtain_specific = 1;
	}
	if(isset($_POST[ "obtain_part"])){
		$obtain_part = 1;
	}
	if(isset($_POST[ "obtain_whole"])){
		$obtain_whole = 1;
	}




	if(isset($_POST[ "id_start_radio"])){
		$id_start_radio = $_POST["id_start_radio"];
	}
	if(isset($_POST[ "id_more_radio"])){
		$id_more_radio = $_POST["id_more_radio"];
	}
	if(isset($_POST[ "learn_feature_radio"])){
		$learn_feature_radio = $_POST["learn_feature_radio"];
	}
	if(isset($_POST[ "learn_structure_radio"])){
		$learn_structure_radio = $_POST["learn_structure_radio"];
	}
	if(isset($_POST[ "learn_domain_radio"])){
		$learn_domain_radio = $_POST["learn_domain_radio"];
	}
	if(isset($_POST[ "learn_database_radio"])){
		$learn_database_radio = $_POST["learn_database_radio"];
	}
	if(isset($_POST[ "find_known_radio"])){
		$find_known_radio = $_POST["find_known_radio"];
	}
	if(isset($_POST[ "find_specific_radio"])){
		$find_specific_radio = $_POST["find_specific_radio"];
	}
	if(isset($_POST[ "find_common_radio"])){
		$find_common_radio = $_POST["find_common_radio"];
	}
	if(isset($_POST[ "find_without_radio"])){
		$find_without_radio = $_POST["find_without_radio"];
	}
	if(isset($_POST[ "locate_specific_radio"])){
		$locate_specific_radio = $_POST["locate_specific_radio"];
	}
	if(isset($_POST[ "locate_common_radio"])){
		$locate_common_radio = $_POST["locate_common_radio"];
	}
	if(isset($_POST[ "locate_area_radio"])){
		$locate_area_radio = $_POST["locate_area_radio"];
	}
	if(isset($_POST[ "keep_bibliographical_radio"])){
		$keep_bibliographical_radio = $_POST["keep_bibliographical_radio"];
	}
	if(isset($_POST[ "keep_link_radio"])){
		$keep_link_radio = $_POST["keep_link_radio"];
	}
	if(isset($_POST[ "keep_item_radio"])){
		$keep_item_radio = $_POST["keep_item_radio"];
	}
	if(isset($_POST[ "access_item_radio"])){
		$access_item_radio = $_POST["access_item_radio"];
	}
	if(isset($_POST[ "access_common_radio"])){
		$access_common_radio = $_POST["access_common_radio"];
	}
	if(isset($_POST[ "access_area_radio"])){
		$access_area_radio = $_POST["access_area_radio"];
	}
	if(isset($_POST[ "evaluate_correctness_radio"])){
		$evaluate_correctness_radio = $_POST["evaluate_correctness_radio"];
	}
	if(isset($_POST[ "evaluate_specificity_radio"])){
		$evaluate_specificity_radio = $_POST["evaluate_specificity_radio"];
	}
	if(isset($_POST[ "evaluate_usefulness_radio"])){
		$evaluate_usefulness_radio = $_POST["evaluate_usefulness_radio"];
	}
	if(isset($_POST[ "evaluate_best_radio"])){
		$evaluate_best_radio = $_POST["evaluate_best_radio"];
	}
	if(isset($_POST[ "evaluate_duplication_radio"])){
		$evaluate_duplication_radio = $_POST["evaluate_duplication_radio"];
	}
	if(isset($_POST[ "obtain_specific_radio"])){
		$obtain_specific_radio = $_POST["obtain_specific_radio"];
	}
	if(isset($_POST[ "obtain_part_radio"])){
		$obtain_part_radio = $_POST["obtain_part_radio"];
	}
	if(isset($_POST[ "obtain_whole_radio"])){
		$obtain_whole_radio = $_POST["obtain_whole_radio"];
	}




	if(isset($_POST[ "id_start_text"])){
		$id_start_text = mysql_escape_string($_POST["id_start_text"]);
	}
	if(isset($_POST[ "id_more_text"])){
		$id_more_text = mysql_escape_string($_POST["id_more_text"]);
	}
	if(isset($_POST[ "learn_feature_text"])){
		$learn_feature_text = mysql_escape_string($_POST["learn_feature_text"]);
	}
	if(isset($_POST[ "learn_structure_text"])){
		$learn_structure_text = mysql_escape_string($_POST["learn_structure_text"]);
	}
	if(isset($_POST[ "learn_domain_text"])){
		$learn_domain_text = mysql_escape_string($_POST["learn_domain_text"]);
	}
	if(isset($_POST[ "learn_database_text"])){
		$learn_database_text = mysql_escape_string($_POST["learn_database_text"]);
	}
	if(isset($_POST[ "find_known_text"])){
		$find_known_text = mysql_escape_string($_POST["find_known_text"]);
	}
	if(isset($_POST[ "find_specific_text"])){
		$find_specific_text = mysql_escape_string($_POST["find_specific_text"]);
	}
	if(isset($_POST[ "find_common_text"])){
		$find_common_text = mysql_escape_string($_POST["find_common_text"]);
	}
	if(isset($_POST[ "find_without_text"])){
		$find_without_text = mysql_escape_string($_POST["find_without_text"]);
	}
	if(isset($_POST[ "locate_specific_text"])){
		$locate_specific_text = mysql_escape_string($_POST["locate_specific_text"]);
	}
	if(isset($_POST[ "locate_common_text"])){
		$locate_common_text = mysql_escape_string($_POST["locate_common_text"]);
	}
	if(isset($_POST[ "locate_area_text"])){
		$locate_area_text = mysql_escape_string($_POST["locate_area_text"]);
	}
	if(isset($_POST[ "keep_bibliographical_text"])){
		$keep_bibliographical_text = mysql_escape_string($_POST["keep_bibliographical_text"]);
	}
	if(isset($_POST[ "keep_link_text"])){
		$keep_link_text = mysql_escape_string($_POST["keep_link_text"]);
	}
	if(isset($_POST[ "keep_item_text"])){
		$keep_item_text = mysql_escape_string($_POST["keep_item_text"]);
	}
	if(isset($_POST[ "access_item_text"])){
		$access_item_text = mysql_escape_string($_POST["access_item_text"]);
	}
	if(isset($_POST[ "access_common_text"])){
		$access_common_text = mysql_escape_string($_POST["access_common_text"]);
	}
	if(isset($_POST[ "access_area_text"])){
		$access_area_text = mysql_escape_string($_POST["access_area_text"]);
	}
	if(isset($_POST[ "evaluate_correctness_text"])){
		$evaluate_correctness_text = mysql_escape_string($_POST["evaluate_correctness_text"]);
	}
	if(isset($_POST[ "evaluate_specificity_text"])){
		$evaluate_specificity_text = mysql_escape_string($_POST["evaluate_specificity_text"]);
	}
	if(isset($_POST[ "evaluate_usefulness_text"])){
		$evaluate_usefulness_text = mysql_escape_string($_POST["evaluate_usefulness_text"]);
	}
	if(isset($_POST[ "evaluate_best_text"])){
		$evaluate_best_text = mysql_escape_string($_POST["evaluate_best_text"]);
	}
	if(isset($_POST[ "evaluate_duplication_text"])){
		$evaluate_duplication_text = mysql_escape_string($_POST["evaluate_duplication_text"]);
	}
	if(isset($_POST[ "obtain_specific_text"])){
		$obtain_specific_text = mysql_escape_string($_POST["obtain_specific_text"]);
	}
	if(isset($_POST[ "obtain_part_text"])){
		$obtain_part_text = mysql_escape_string($_POST["obtain_part_text"]);
	}
	if(isset($_POST[ "obtain_whole_text"])){
		$obtain_whole_text = mysql_escape_string($_POST["obtain_whole_text"]);
	}

	$time_start = $_POST['time_start'];

	$cxn->commit("INSERT INTO video_intent_assignments (userID,projectID,stageID,questionID,time_start,`id_start`,
		`id_more`,`learn_feature`,`learn_structure`,`learn_domain`,`learn_database`,
		`find_known`,`find_specific`,`find_common`,`find_without`,`locate_specific`,
		`locate_common`,`locate_area`,`keep_bibliographical`,`keep_link`,`keep_item`,
		`access_item`,`access_common`,`access_area`,`evaluate_correctness`,`evaluate_specificity`,`evaluate_usefulness`,
		`evaluate_best`,`evaluate_duplication`,`obtain_specific`,`obtain_part`,`obtain_whole`,

		`id_start_radio`,
			`id_more_radio`,`learn_feature_radio`,`learn_structure_radio`,`learn_domain_radio`,`learn_database_radio`,
			`find_known_radio`,`find_specific_radio`,`find_common_radio`,`find_without_radio`,`locate_specific_radio`,
			`locate_common_radio`,`locate_area_radio`,`keep_bibliographical_radio`,`keep_link_radio`,`keep_item_radio`,
			`access_item_radio`,`access_common_radio`,`access_area_radio`,`evaluate_correctness_radio`,`evaluate_specificity_radio`,`evaluate_usefulness_radio`,
			`evaluate_best_radio`,`evaluate_duplication_radio`,`obtain_specific_radio`,`obtain_part_radio`,`obtain_whole_radio`,

			`id_start_text`,
				`id_more_text`,`learn_feature_text`,`learn_structure_text`,`learn_domain_text`,`learn_database_text`,
				`find_known_text`,`find_specific_text`,`find_common_text`,`find_without_text`,`locate_specific_text`,
				`locate_common_text`,`locate_area_text`,`keep_bibliographical_text`,`keep_link_text`,`keep_item_text`,
				`access_item_text`,`access_common_text`,`access_area_text`,`evaluate_correctness_text`,`evaluate_specificity_text`,`evaluate_usefulness_text`,
				`evaluate_best_text`,`evaluate_duplication_text`,`obtain_specific_text`,`obtain_part_text`,`obtain_whole_text`,`date`,`time`,`timestamp`


	) VALUES ('$userID','$projectID','$stageID','$questionID','$time_start','$id_start',
		'$id_more','$learn_feature','$learn_structure','$learn_domain','$learn_database',
		'$find_known','$find_specific','$find_common','$find_without','$locate_specific',
		'$locate_common','$locate_area','$keep_bibliographical','$keep_link','$keep_item',
		'$access_item','$access_common','$access_area','$evaluate_correctness','$evaluate_specificity','$evaluate_usefulness',
		'$evaluate_best','$evaluate_duplication','$obtain_specific','$obtain_part','$obtain_whole',

		'$id_start_radio',
			'$id_more_radio','$learn_feature_radio','$learn_structure_radio','$learn_domain_radio','$learn_database_radio',
			'$find_known_radio','$find_specific_radio','$find_common_radio','$find_without_radio','$locate_specific_radio',
			'$locate_common_radio','$locate_area_radio','$keep_bibliographical_radio','$keep_link_radio','$keep_item_radio',
			'$access_item_radio','$access_common_radio','$access_area_radio','$evaluate_correctness_radio','$evaluate_specificity_radio','$evaluate_usefulness_radio',
			'$evaluate_best_radio','$evaluate_duplication_radio','$obtain_specific_radio','$obtain_part_radio','$obtain_whole_radio',

			'$id_start_text',
				'$id_more_text','$learn_feature_text','$learn_structure_text','$learn_domain_text','$learn_database_text',
				'$find_known_text','$find_specific_text','$find_common_text','$find_without_text','$locate_specific_text',
				'$locate_common_text','$locate_area_text','$keep_bibliographical_text','$keep_link_text','$keep_item_text',
				'$access_item_text','$access_common_text','$access_area_text','$evaluate_correctness_text','$evaluate_specificity_text','$evaluate_usefulness_text',
				'$evaluate_best_text','$evaluate_duplication_text','$obtain_specific_text','$obtain_part_text','$obtain_whole_text','$date','$time','$timestamp'


	)");

}

function commitanswer_reformulation(){
	$base = Base::getInstance();
	$cxn = Connection::getInstance();
	$userID = $base->getUserID();
	$projectID = $base->getProjectID();
	$stageID = $base->getStageID();
	$questionID = $base->getQuestionID();
	$timestamp = $base->getTimestamp();
	$date = $base->getDate();
	$time = $base->getTime();
	$reformulation_reason = mysql_escape_string($_POST["reformulation_reason"]);

	$time_start = $_POST['time_start'];

	$cxn->commit("INSERT INTO video_reformulation_history (userID,projectID,stageID,questionID,time_start,`reformulation_reason`,`date`,`time`,`timestamp`

	) VALUES ('$userID','$projectID','$stageID','$questionID','$time_start','$reformulation_reason','$date','$time','$timestamp'

	)");

}


function commitanswer_save(){
	$base = Base::getInstance();
	$cxn = Connection::getInstance();
	$userID = $base->getUserID();
	$projectID = $base->getProjectID();
	$stageID = $base->getStageID();
	$questionID = $base->getQuestionID();
	$timestamp = $base->getTimestamp();
	$date = $base->getDate();
	$time = $base->getTime();

	$ninputs = intval($_POST["ninputs"]);


	for($x = 1; $x <= $ninputs; $x+=1){
		$useful = $_POST["useful_$x"];
		$confident = $_POST["confident_$x"];
		$time_start = $_POST["time_start_$x"];
		$cxn->commit("INSERT INTO video_save_history (userID,projectID,stageID,questionID,time_start,`useful`,`confident`,`date`,`time`,`timestamp`

		) VALUES ('$userID','$projectID','$stageID','$questionID','$time_start','$useful','$confident','$date','$time','$timestamp'

		)");
	}
}


function commitanswer_unsave(){
	$base = Base::getInstance();
	$cxn = Connection::getInstance();
	$userID = $base->getUserID();
	$projectID = $base->getProjectID();
	$stageID = $base->getStageID();
	$questionID = $base->getQuestionID();
	$timestamp = $base->getTimestamp();
	$date = $base->getDate();
	$time = $base->getTime();

	$ninputs = intval($_POST["ninputs"]);

	for($x = 1; $x <= $ninputs; $x+=1){
		$unsave_reason = mysql_escape_string($_POST["unsave_reason_$x"]);
		$time_start = $_POST["time_start_$x"];

		$cxn->commit("INSERT INTO video_unsave_history (userID,projectID,stageID,questionID,time_start,`unsave_reason`,`date`,`time`,`timestamp`

		) VALUES ('$userID','$projectID','$stageID','$questionID','$time_start','$unsave_reason','$date','$time','$timestamp'

		)");
	}

}


$question_data = array();
$questiontype_values = array();
$questiontype_values['query'] = 'Q (query)';
$questiontype_values['save'] = 'S (save)';
$questiontype_values['unsave'] = 'U (unsave)';



function clean_timestr($start_string){
	return preg_replace('/[[:^print:]]/', '', $start_string);
}

function timestrToInt($start_string){
	$start_time = preg_replace('/[[:^print:]]/', '', $start_string);

	if(substr_count($start_time,":")<2){
		while(substr_count($start_time,":") != 2){
			$start_time = "00:". $start_time;
		}
	}

	$start_time = substr($start_time, 0, strpos($start_time, "."));
	// $start_time = substr($start_time,0,-2);
	$start_time = strtotime($start_time) - strtotime('TODAY');

	return $start_time;
}

function intToPHPTime($seconds){
	$t = round($seconds);
  return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}

function typeMatch($detailkey,$detailvalue){
	$detailkey = preg_replace('/[[:^print:]]/', '', $detailkey);
	$detailvalue = preg_replace('/[[:^print:]]/', '', $detailvalue);
	return $detailkey==$detailvalue;
}
function makeTaskData(){
	global $question_data,$questiontype_values;
	$base = Base::getInstance();
	$connection = Connection::getInstance();
	$userID = $base->getUserID();
	$projectID = $base->getProjectID();
	$questionID = $base->getQuestionID();

	$restasks = $connection->commit("SELECT * FROM video_segments WHERE userID='$userID' AND projectID='$projectID' AND questionID='$questionID' ORDER BY segmentID ASC");

	$typekey = 'Details';
	$index = -1;
	$prev_query_stamp = '';
	$reformulation_query_stamp = '';
	while($line = mysql_fetch_array($restasks,MYSQL_ASSOC)){
		if(typeMatch($line[$typekey],$questiontype_values['query'])){
			// Reformulation
			$new_stamp = clean_timestr($line['Elapsed Time']);

			if($prev_query_stamp != ''){
				$question_data[$index]['intention']['stop_stamp'] = $new_stamp;
				$question_data[$index]['reformulation'] = array();
				$question_data[$index]['reformulation']['done'] = False;
				$question_data[$index]['reformulation']['start_stamp'] = $new_stamp;
				if($reformulation_query_stamp != ''){
					$question_data[$index-1]['reformulation']['stop_stamp'] = $new_stamp;
				}
			}


			// New query, new index
			$index += 1;
			$question_data[$index] = array();
			$question_data[$index]['intention'] = array();
			$question_data[$index]['intention']['done'] = False;
			$question_data[$index]['intention']['start_stamp'] = $new_stamp;



			$reformulation_query_stamp = $prev_query_stamp;
			$prev_query_stamp = $new_stamp;

		}else if(typeMatch($line[$typekey],$questiontype_values['save'])){

			if(!isset($question_data[$index]['save'])){
				$question_data[$index]['save'] = array();
				$question_data[$index]['save']['done'] = False;
				$question_data[$index]['save']['stamps'] = array();
			}

			array_push($question_data[$index]['save']['stamps'],clean_timestr($line['Elapsed Time']));
			$resresults = $connection->commit("SELECT * FROM video_save_history WHERE userID='$userID' AND projectID='$projectID' AND questionID='$questionID' AND time_start='".clean_timestr($line['Elapsed Time'])."'");
			if(mysql_num_rows($resresults) > 0){
				$question_data[$index]['save']['done'] = True;
			}

		}else if(typeMatch($line[$typekey],$questiontype_values['unsave'])){

			if(!isset($question_data[$index]['unsave'])){
				$question_data[$index]['unsave'] = array();
				$question_data[$index]['unsave']['done'] = False;
				$question_data[$index]['unsave']['stamps'] = array();
			}

			array_push($question_data[$index]['unsave']['stamps'],clean_timestr($line['Elapsed Time']));
			$resresults = $connection->commit("SELECT * FROM video_unsave_history WHERE userID='$userID' AND projectID='$projectID' AND questionID='$questionID' AND time_start='".clean_timestr($line['Elapsed Time'])."'");
			if(mysql_num_rows($resresults) > 0){
				$question_data[$index]['unsave']['done'] = True;
			}
		}

	}


	// TODO: Add stop data for last query

	$start_string = $question_data[$index]['intention']['start_stamp'];
	$time_add = 30;

	$start_time = timestrToInt($start_string);
	$start_time += $time_add;

	$question_data[$index]['intention']['stop_stamp'] = intToPHPTime($start_time);


	// TODO: Mark queries and reformulations as done
	for($x=0; $x<=$index;$x+=1){

		if(isset($question_data[$x]['intention'])){
			$resresults = $connection->commit("SELECT * FROM video_intent_assignments WHERE userID='$userID' AND projectID='$projectID' AND questionID='$questionID' AND time_start='".$question_data[$x]['intention']['start_stamp']."'");
			if(mysql_num_rows($resresults) > 0){
				$question_data[$x]['intention']['done'] = True;
			}
		}

		if(isset($question_data[$x]['reformulation'])){
			$resresults = $connection->commit("SELECT * FROM video_reformulation_history WHERE userID='$userID' AND projectID='$projectID' AND questionID='$questionID' AND time_start='".$question_data[$x]['reformulation']['start_stamp']."'");
			if(mysql_num_rows($resresults) > 0){
				$question_data[$x]['reformulation']['done'] = True;
			}
		}
	}


}

function getNextTask(){
	global $question_data;
	$retarr = array();
	// Outputs:
	// 'intention'
	// 'reformulation'
	// 'save'
	// 'unsave'
	// 'none'


	// print_r($question_data);
	foreach($question_data as $index => $data){
		if(isset($data['intention']) && isset($data['intention']['done']) && !$data['intention']['done']){
			$retarr['type'] = 'intention';
			$retarr['start_stamp'] = $data['intention']['start_stamp'];
			$retarr['stop_stamp'] = $data['intention']['stop_stamp'];
			return $retarr;
		}

		if(isset($data['reformulation']) && isset($data['reformulation']['done']) && !$data['reformulation']['done']){
			$retarr['type'] = 'reformulation';
			$retarr['start_stamp'] = $data['reformulation']['start_stamp'];
			$retarr['stop_stamp'] = $data['reformulation']['stop_stamp'];
			$retarr['start_stamp_prev'] = $data['intention']['start_stamp'];
			$retarr['stop_stamp_prev'] = $data['intention']['stop_stamp'];

			return $retarr;
		}

		if(isset($data['save']) && isset($data['save']['done']) && !$data['save']['done']){
			$retarr['type'] = 'save';
			$retarr['stamps'] = $data['save']['stamps'];
			return $retarr;
		}


		if(isset($data['unsave']) && isset($data['unsave']['done']) && !$data['unsave']['done']){
			$retarr['type'] = 'unsave';
			$retarr['stamps'] = $data['unsave']['stamps'];
			return $retarr;
		}

	}

	$retarr['type'] = 'none';
	return $retarr;

}


function getProgress(){
	global $question_data;
	$ret = array();
	// Outputs:
	// 'intention'
	// 'reformulation'
	// 'save'
	// 'unsave'
	// 'none'

	$total = 0;
	$ct = 0;
	$retarr = array();
	foreach($question_data as $index => $data){
		if(isset($data['intention']) and isset($data['intention']['done']) and $data['intention']['done']){
			$total += 1;
		}
		if(isset($data['intention'])){
				$ct += 1;
		}


		if(isset($data['save']) and isset($data['save']['done']) and $data['save']['done']){
			$total += 1;
		}
		if(isset($data['save'])){
				$ct += 1;
		}

		if(isset($data['unsave']) and isset($data['unsave']['done']) and $data['unsave']['done']){
			$total += 1;
		}
		if(isset($data['unsave'])){
				$ct += 1;
		}

		if(isset($data['reformulation']) and isset($data['reformulation']['done']) and $data['reformulation']['done']){
			$total += 1;
		}
		if(isset($data['reformulation'])){
				$ct += 1;
		}

	}

	$retarr['count'] = $total;
	$retarr['total'] = $ct;
	return $retarr;
}

$render = array();





$javascript_intention = "

function validate(){
	var retval = true;

	var l = $(\"#checkboxset\").find(\"input:checkbox:checked\").length;

	if (l > 0){
			$(\"#error_text\").css('display','none');
	}else{
			$(\"#error_text\").css('display','block');
	}

	retval = retval && (l > 0);

	$('input[type=checkbox]').each(function () {
		var tempret = true;
		if(this.checked){
			var radioname = $(this).attr('pref')+\"_radio\";
			tempret = tempret && ($(\"input[name=\"+radioname+\"]:checked\").length > 0);
			if(tempret && $(\"input[name=\"+radioname+\"]:checked\").val() == \"No\"){
					var textgroup = $(this).attr('pref')+\"_text\";
					tempret = tempret && ($.trim($(\"#\"+textgroup).val()).length > 0);
			}
		}
		retval = retval && tempret;
	});



	if(retval==false){
		$(\"#error_text\").css('display','block');
	}else{

		$(\"#error_text\").css('display','none');
	}
	return retval;
}

function shownext(){
	shownext_helper(parseInt($(\"#timeslice\").val()));
	var i = parseInt($(\"#timeslice\").val());
	playVideoHelper(parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}



var VIDEO;
var pausing_function;
var STOP_TIME = 0;
var START_TIME = 0;

function init(){
	VIDEO = document.getElementById(\"session_video\");
	pausing_function = function(){
		if(this.currentTime >= STOP_TIME) {

				this.pause();
		}
	};
	VIDEO.addEventListener(\"timeupdate\", pausing_function);

}





function scanToStart(start){
	document.getElementById(\"session_video\").currentTime = start;
	document.getElementById(\"session_video\").pause();
}
function playvideo(i){
		playVideoHelper(parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}

function playVideoHelper(start,stop){
	document.getElementById(\"session_video\").currentTime = start;
	STOP_TIME = stop;
	START_TIME = start;
	document.getElementById(\"session_video\").play();
}



function handleCheck(cb){
	var pref = $(cb).attr('pref');

	var radioname = pref+\"_radiogroup\";

	if(cb.checked){
		$(\"#\"+radioname).show();
	}else{
		$(\"#\"+radioname).hide();
	}
}

function handleRadio(rad){
	var pref = $(rad).attr('pref');

	var textname = pref+\"_textgroup\";
	if(rad.checked && rad.value ==\"Yes\"){
		$(\"#\"+textname).hide();
	}else if (rad.checked && rad.value ==\"No\"){
		$(\"#\"+textname).show();
	}
}


";

$javascript_reformulation = "

function validate(){
	var inp = $(\"#reformulation_reason\").val();
	if($.trim(inp).length > 0)
	{
	   $(\"#error_text\").css('display','none');
		 return true;
	}else{
		$(\"#error_text\").css('display','block');
		return false;

	}
}

function shownext(){
	shownext_helper(parseInt($(\"#timeslice\").val()));
	var i = parseInt($(\"#timeslice\").val());
	playVideoHelper(parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}



var VIDEO1;
var pausing_function1;
var STOP_TIME1 = 0;
var START_TIME1 = 0;

var VIDEO2;
var pausing_function2;
var STOP_TIME2 = 0;
var START_TIME2 = 0;

function init(){
	VIDEO1 = document.getElementById(\"session_video1\");
	VIDEO2 = document.getElementById(\"session_video2\");
	pausing_function1 = function(){
		if(this.currentTime >= STOP_TIME1) {
				this.pause();
		}
	};

	pausing_function2 = function(){
		if(this.currentTime >= STOP_TIME2) {
				this.pause();
		}
	};


	VIDEO1.addEventListener(\"timeupdate\", pausing_function1);
	VIDEO2.addEventListener(\"timeupdate\", pausing_function2);

}


function playvideo(which,i){
		playVideoHelper(which,parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}

function playVideoHelper(which,start,stop){
	var n = 1;


	if(which == \"prev\"){
		n=1;
		STOP_TIME1 = stop;
		START_TIME1 = start;
	}else if(which == \"next\"){
		n=2;
		STOP_TIME2 = stop;
		START_TIME2 = start;
	}
	document.getElementById(\"session_video\"+n).currentTime = start;

	document.getElementById(\"session_video\"+n).play();
}

";

$javascript_save = "

function validate(){
	var retval = true;
	for (x=1; x<=N_RESULTS;x+=1){


		retval = retval && ($(\"input[name=useful_\"+x+\"]:checked\").length > 0);
		retval = retval && ($(\"input[name=confident_\"+x+\"]:checked\").length > 0);

	}




	if(retval==false){
		$(\"#error_text\").css('display','block');
	}else{

		$(\"#error_text\").css('display','none');
	}
	return retval;
}

function shownext(){
	shownext_helper(parseInt($(\"#timeslice\").val()));
	var i = parseInt($(\"#timeslice\").val());
	playVideoHelper(parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}



var VIDEO;
var pausing_function;
var STOP_TIME = 0;
var START_TIME = 0;

function init(){
	VIDEO = document.getElementById(\"session_video\");
	pausing_function = function(){
		if(this.currentTime >= STOP_TIME) {
				this.pause();
		}
	};
	VIDEO.addEventListener(\"timeupdate\", pausing_function);

}





function scanToStart(start){
	document.getElementById(\"session_video\").currentTime = start;
	document.getElementById(\"session_video\").pause();
}
function playvideo(i){
		playVideoHelper(parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}

function playVideoHelper(start,stop){
	document.getElementById(\"session_video\").currentTime = start;
	STOP_TIME = stop;
	START_TIME = start;
	document.getElementById(\"session_video\").play();
}



";

$javascript_unsave = "



function validate(){
	var retval = true;
	for (x=1; x<=N_RESULTS;x+=1){
		var inp = $(\"#unsave_reason_\"+x).val();
		if($.trim(inp).length > 0)
		{
		   $(\"#error_text\").css('display','none');
			 retval = retval && true;
		}else{
			$(\"#error_text\").css('display','block');
			retval = retval && false;

		}
	}
	return retval;
}

function shownext(){
	shownext_helper(parseInt($(\"#timeslice\").val()));
	var i = parseInt($(\"#timeslice\").val());
	playVideoHelper(parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}



var VIDEO;
var pausing_function;
var STOP_TIME = 0;
var START_TIME = 0;

function init(){
	VIDEO = document.getElementById(\"session_video\");
	pausing_function = function(){
		if(this.currentTime >= STOP_TIME) {
				this.pause();
		}
	};
	VIDEO.addEventListener(\"timeupdate\", pausing_function);

}





function scanToStart(start){
	document.getElementById(\"session_video\").currentTime = start;
	document.getElementById(\"session_video\").pause();
}
function playvideo(i){
		playVideoHelper(parseInt($(\"#time_\"+i).attr(\"starttime\")),parseInt($(\"#time_\"+i).attr(\"stoptime\")));
}

function playVideoHelper(start,stop){
	document.getElementById(\"session_video\").currentTime = start;
	STOP_TIME = stop;
	START_TIME = start;
	document.getElementById(\"session_video\").play();
}

";

$intention_inputstring = "<button id='playpausebutton' style='color: white; background:rgb(28, 184, 65);text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);' class='pure-button' onclick='playvideo(1);return false;'><i id=\"playpauseicon\" class=\"fa fa-repeat\"></i> Replay Video</button>

<fieldset>
	<div class='pure-g'>
<div class='pure-u-1-1'>
	<label><h4><u>Identify search information</u></h4></label>

	<label for='id_start' class='pure-checkbox'>
				<input id='id_start' type='checkbox' name='id_start' pref='id_start'  onchange='handleCheck(this);'> Identify something to get started
	</label>

			<div id='id_start_radiogroup' style='display:none'>
			<label for='id_start_radio' class='pure-radio'>
			<input id='id_start_radio-Yes' type='radio' name='id_start_radio' pref='id_start'  value='Yes' onclick='handleRadio(this);'> Yes
			<input id='id_start_radio-No' type='radio' name='id_start_radio' pref='id_start'  value='No' onclick='handleRadio(this);'> No
			</label>
			</div>

			<div id='id_start_textgroup' style='display:none'>
			<label>Why not?</label>
			<textarea id='id_start_text' name='id_start_text' rows='5' cols='80' ></textarea>
			</div>


	<label for='id_more' class='pure-checkbox'>
				<input id='id_more' type='checkbox' name='id_more' pref='id_more'  onchange='handleCheck(this);'> Identify something more to search
	</label>

			<div id='id_more_radiogroup' style='display:none'>
			<label for='id_more_radio' class='pure-radio'>
			<input id='id_more_radio-Yes' type='radio' name='id_more_radio' pref='id_more'  value='Yes' onclick='handleRadio(this);'> Yes
			<input id='id_more_radio-No' type='radio' name='id_more_radio' pref='id_more'  value='No' onclick='handleRadio(this);'> No
			</label>
			</div>

			<div id='id_more_textgroup' style='display:none'>
			<label>Why not?</label>
			<textarea id='id_more_text' name='id_more_text' rows='5' cols='80' ></textarea>
			</div>
	</div>



<div class='pure-u-1-1'>
	<label><h4><u>Learning</u></h4></label>

	<label for='learn_feature' class='pure-checkbox'>
				<input id='learn_feature' type='checkbox' name='learn_feature' pref='learn_feature'  onchange='handleCheck(this);'> Learn system feature
	</label>

	<div id='learn_feature_radiogroup' style='display:none'>
	<label for='learn_feature_radio' class='pure-radio'>
	<input id='learn_feature_radio-Yes' type='radio' name='learn_feature_radio' pref='learn_feature'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='learn_feature_radio-No' type='radio' name='learn_feature_radio' pref='learn_feature'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='learn_feature_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='learn_feature_text' name='learn_feature_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='learn_structure' class='pure-checkbox'>
				<input id='learn_structure' type='checkbox' name='learn_structure' pref='learn_structure'  onchange='handleCheck(this);'> Learn system structure
	</label>

	<div id='learn_structure_radiogroup' style='display:none'>
	<label for='learn_structure_radio' class='pure-radio'>
	<input id='learn_structure_radio-Yes' type='radio' name='learn_structure_radio' pref='learn_structure'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='learn_structure_radio-No' type='radio' name='learn_structure_radio' pref='learn_structure'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='learn_structure_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='learn_structure_text' name='learn_structure_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='learn_domain' class='pure-checkbox'>
				<input id='learn_domain' type='checkbox' name='learn_domain' pref='learn_domain'  onchange='handleCheck(this);'> Learn domain knowledge
	</label>

	<div id='learn_domain_radiogroup' style='display:none'>
	<label for='learn_domain_radio' class='pure-radio'>
	<input id='learn_domain_radio-Yes' type='radio' name='learn_domain_radio' pref='learn_domain'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='learn_domain_radio-No' type='radio' name='learn_domain_radio' pref='learn_domain'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='learn_domain_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='learn_domain_text' name='learn_domain_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='learn_database' class='pure-checkbox'>
				<input id='learn_database' type='checkbox' name='learn_database' pref='learn_database'  onchange='handleCheck(this);'> Learn database content
	</label>

	<div id='learn_database_radiogroup' style='display:none'>
	<label for='learn_database_radio' class='pure-radio'>
	<input id='learn_database_radio-Yes' type='radio' name='learn_database_radio' pref='learn_database'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='learn_database_radio-No' type='radio' name='learn_database_radio' pref='learn_database'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='learn_database_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='learn_database_text' name='learn_database_text' rows='5' cols='80' ></textarea>
	</div>
</div>

</div>



<div class='pure-g'>

<div class='pure-u-1-1'>
	<label><h4><u>Finding</u></h4></label>

	<label for='find_known' class='pure-checkbox'>
				<input id='find_known' type='checkbox' name='find_known' pref='find_known'  onchange='handleCheck(this);'> Find a known item
	</label>

	<div id='find_known_radiogroup' style='display:none'>
	<label for='find_known_radio' class='pure-radio'>
	<input id='find_known_radio-Yes' type='radio' name='find_known_radio' pref='find_known'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='find_known_radio-No' type='radio' name='find_known_radio' pref='find_known'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='find_known_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='find_known_text' name='find_known_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='find_specific' class='pure-checkbox'>
				<input id='find_specific' type='checkbox' name='find_specific' pref='find_specific'  onchange='handleCheck(this);'> Find specific information
	</label>

	<div id='find_specific_radiogroup' style='display:none'>
	<label for='find_specific_radio' class='pure-radio'>
	<input id='find_specific_radio-Yes' type='radio' name='find_specific_radio' pref='find_specific'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='find_specific_radio-No' type='radio' name='find_specific_radio' pref='find_specific'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='find_specific_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='find_specific_text' name='find_specific_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='find_common' class='pure-checkbox'>
				<input id='find_common' type='checkbox' name='find_common' pref='find_common'  onchange='handleCheck(this);'> Find items with common characteristics
	</label>

	<div id='find_common_radiogroup' style='display:none'>
	<label for='find_common_radio' class='pure-radio'>
	<input id='find_common_radio-Yes' type='radio' name='find_common_radio' pref='find_common'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='find_common_radio-No' type='radio' name='find_common_radio' pref='find_common'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='find_common_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='find_common_text' name='find_common_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='find_without' class='pure-checkbox'>
				<input id='find_without' type='checkbox' name='find_without' pref='find_without'  onchange='handleCheck(this);'> Find items without predefined criteria
	</label>

	<div id='find_without_radiogroup' style='display:none'>
	<label for='find_without_radio' class='pure-radio'>
	<input id='find_without_radio-Yes' type='radio' name='find_without_radio' pref='find_without'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='find_without_radio-No' type='radio' name='find_without_radio' pref='find_without'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='find_without_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='find_without_text' name='find_without_text' rows='5' cols='80' ></textarea>
	</div>
</div>



<div class='pure-u-1-1'>
	<label><h4><u>Locate: Find out where a specific item is placed</u></h4></label>

	<label for='locate_specific' class='pure-checkbox'>
				<input id='locate_specific' type='checkbox' name='locate_specific' pref='locate_specific'  onchange='handleCheck(this);'> Locate a specific item
	</label>

	<div id='locate_specific_radiogroup' style='display:none'>
	<label for='locate_specific_radio' class='pure-radio'>
	<input id='locate_specific_radio-Yes' type='radio' name='locate_specific_radio' pref='locate_specific'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='locate_specific_radio-No' type='radio' name='locate_specific_radio' pref='locate_specific'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='locate_specific_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='locate_specific_text' name='locate_specific_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='locate_common' class='pure-checkbox'>
				<input id='locate_common' type='checkbox' name='locate_common' pref='locate_common'  onchange='handleCheck(this);'> Locate items with common characteristics
	</label>

	<div id='locate_common_radiogroup' style='display:none'>
	<label for='locate_common_radio' class='pure-radio'>
	<input id='locate_common_radio-Yes' type='radio' name='locate_common_radio' pref='locate_common'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='locate_common_radio-No' type='radio' name='locate_common_radio' pref='locate_common'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='locate_common_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='locate_common_text' name='locate_common_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='locate_area' class='pure-checkbox'>
				<input id='locate_area' type='checkbox' name='locate_area' pref='locate_area'  onchange='handleCheck(this);'> Locate an area/location
	</label>

	<div id='locate_area_radiogroup' style='display:none'>
	<label for='locate_area_radio' class='pure-radio'>
	<input id='locate_area_radio-Yes' type='radio' name='locate_area_radio' pref='locate_area'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='locate_area_radio-No' type='radio' name='locate_area_radio' pref='locate_area'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='locate_area_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='locate_area_text' name='locate_area_text' rows='5' cols='80' ></textarea>
	</div>
</div>
</div>



<div class='pure-g'>
<div class='pure-u-1-1'>
	<label><h4><u>Keep record</u></h4></label>

	<label for='keep_bibliographical' class='pure-checkbox'>
				<input id='keep_bibliographical' type='checkbox' name='keep_bibliographical' pref='keep_bibliographical'  onchange='handleCheck(this);'> Keep record of bibliographical information
	</label>

	<div id='keep_bibliographical_radiogroup' style='display:none'>
	<label for='keep_bibliographical_radio' class='pure-radio'>
	<input id='keep_bibliographical_radio-Yes' type='radio' name='keep_bibliographical_radio' pref='keep_bibliographical'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='keep_bibliographical_radio-No' type='radio' name='keep_bibliographical_radio' pref='keep_bibliographical'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='keep_bibliographical_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='keep_bibliographical_text' name='keep_bibliographical_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='keep_link' class='pure-checkbox'>
				<input id='keep_link' type='checkbox' name='keep_link' pref='keep_link'  onchange='handleCheck(this);'> Keep record of link
	</label>

	<div id='keep_link_radiogroup' style='display:none'>
	<label for='keep_link_radio' class='pure-radio'>
	<input id='keep_link_radio-Yes' type='radio' name='keep_link_radio' pref='keep_link'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='keep_link_radio-No' type='radio' name='keep_link_radio' pref='keep_link'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='keep_link_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='keep_link_text' name='keep_link_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='keep_item' class='pure-checkbox'>
				<input id='keep_item' type='checkbox' name='keep_item' pref='keep_item'  onchange='handleCheck(this);'> Note item for return
	</label>

	<div id='keep_item_radiogroup' style='display:none'>
	<label for='keep_item_radio' class='pure-radio'>
	<input id='keep_item_radio-Yes' type='radio' name='keep_item_radio' pref='keep_item'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='keep_item_radio-No' type='radio' name='keep_item_radio' pref='keep_item'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='keep_item_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='keep_item_text' name='keep_item_text' rows='5' cols='80' ></textarea>
	</div>
</div>




<div class='pure-u-1-1'>
	<label><h4><u>Access an item based on its location</u></h4></label>

	<label for='access_item' class='pure-checkbox'>
				<input id='access_item' type='checkbox' name='access_item' pref='access_item'  onchange='handleCheck(this);'> Access a specific item
	</label>

	<div id='access_item_radiogroup' style='display:none'>
	<label for='access_item_radio' class='pure-radio'>
	<input id='access_item_radio-Yes' type='radio' name='access_item_radio' pref='access_item'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='access_item_radio-No' type='radio' name='access_item_radio' pref='access_item'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='access_item_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='access_item_text' name='access_item_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='access_common' class='pure-checkbox'>
				<input id='access_common' type='checkbox' name='access_common' pref='access_common'  onchange='handleCheck(this);'> Access items with common characteristics
	</label>

	<div id='access_common_radiogroup' style='display:none'>
	<label for='access_common_radio' class='pure-radio'>
	<input id='access_common_radio-Yes' type='radio' name='access_common_radio' pref='access_common'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='access_common_radio-No' type='radio' name='access_common_radio' pref='access_common'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='access_common_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='access_common_text' name='access_common_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='access_area' class='pure-checkbox'>
				<input id='access_area' type='checkbox' name='access_area' pref='access_area'  onchange='handleCheck(this);'> Access an area/location
	</label>

	<div id='access_area_radiogroup' style='display:none'>
	<label for='access_area_radio' class='pure-radio'>
	<input id='access_area_radio-Yes' type='radio' name='access_area_radio' pref='access_area'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='access_area_radio-No' type='radio' name='access_area_radio' pref='access_area'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='access_area_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='access_area_text' name='access_area_text' rows='5' cols='80' ></textarea>
	</div>
</div>
</div>



<div class='pure-g'>
<div class='pure-u-1-1'>
	<label><h4><u>Evaluate</u></h4></label>

	<label for='evaluate_correctness' class='pure-checkbox'>
				<input id='evaluate_correctness' type='checkbox' name='evaluate_correctness' pref='evaluate_correctness'  onchange='handleCheck(this);'> Evaluate correctness of an item
	</label>

	<div id='evaluate_correctness_radiogroup' style='display:none'>
	<label for='evaluate_correctness_radio' class='pure-radio'>
	<input id='evaluate_correctness_radio-Yes' type='radio' name='evaluate_correctness_radio' pref='evaluate_correctness'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='evaluate_correctness_radio-No' type='radio' name='evaluate_correctness_radio' pref='evaluate_correctness'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='evaluate_correctness_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='evaluate_correctness_text' name='evaluate_correctness_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='evaluate_specificity' class='pure-checkbox'>
				<input id='evaluate_specificity' type='checkbox' name='evaluate_specificity' pref='evaluate_specificity'  onchange='handleCheck(this);'> Evaluate specificity of an item
	</label>

	<div id='evaluate_specificity_radiogroup' style='display:none'>
	<label for='evaluate_specificity_radio' class='pure-radio'>
	<input id='evaluate_specificity_radio-Yes' type='radio' name='evaluate_specificity_radio' pref='evaluate_specificity'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='evaluate_specificity_radio-No' type='radio' name='evaluate_specificity_radio' pref='evaluate_specificity'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='evaluate_specificity_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='evaluate_specificity_text' name='evaluate_specificity_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='evaluate_usefulness' class='pure-checkbox'>
				<input id='evaluate_usefulness' type='checkbox' name='evaluate_usefulness' pref='evaluate_usefulness'  onchange='handleCheck(this);'> Evaluate usefulness of an item
	</label>

	<div id='evaluate_usefulness_radiogroup' style='display:none'>
	<label for='evaluate_usefulness_radio' class='pure-radio'>
	<input id='evaluate_usefulness_radio-Yes' type='radio' name='evaluate_usefulness_radio' pref='evaluate_usefulness'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='evaluate_usefulness_radio-No' type='radio' name='evaluate_usefulness_radio' pref='evaluate_usefulness'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='evaluate_usefulness_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='evaluate_usefulness_text' name='evaluate_usefulness_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='evaluate_best' class='pure-checkbox'>
				<input id='evaluate_best' type='checkbox' name='evaluate_best' pref='evaluate_best'  onchange='handleCheck(this);'> Pick best item(s) from all the useful ones
	</label>

	<div id='evaluate_best_radiogroup' style='display:none'>
	<label for='evaluate_best_radio' class='pure-radio'>
	<input id='evaluate_best_radio-Yes' type='radio' name='evaluate_best_radio' pref='evaluate_best'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='evaluate_best_radio-No' type='radio' name='evaluate_best_radio' pref='evaluate_best'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='evaluate_best_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='evaluate_best_text' name='evaluate_best_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='evaluate_duplication' class='pure-checkbox'>
				<input id='evaluate_duplication' type='checkbox' name='evaluate_duplication' pref='evaluate_duplication'  onchange='handleCheck(this);'> Evaluate duplication of an item
	</label>

	<div id='evaluate_duplication_radiogroup' style='display:none'>
	<label for='evaluate_duplication_radio' class='pure-radio'>
	<input id='evaluate_duplication_radio-Yes' type='radio' name='evaluate_duplication_radio' pref='evaluate_duplication'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='evaluate_duplication_radio-No' type='radio' name='evaluate_duplication_radio' pref='evaluate_duplication'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='evaluate_duplication_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='evaluate_duplication_text' name='evaluate_duplication_text' rows='5' cols='80' ></textarea>
	</div>
</div>


<div class='pure-u-1-1'>
	<label><h4><u>Obtain</u></h4></label>

	<label for='obtain_specific' class='pure-checkbox'>
				<input id='obtain_specific' type='checkbox' name='obtain_specific' pref='obtain_specific'  onchange='handleCheck(this);'>  Obtain specific information
	</label>

	<div id='obtain_specific_radiogroup' style='display:none'>
	<label for='obtain_specific_radio' class='pure-radio'>
	<input id='obtain_specific_radio-Yes' type='radio' name='obtain_specific_radio' pref='obtain_specific'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='obtain_specific_radio-No' type='radio' name='obtain_specific_radio' pref='obtain_specific'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='obtain_specific_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='obtain_specific_text' name='obtain_specific_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='obtain_part' class='pure-checkbox'>
				<input id='obtain_part' type='checkbox' name='obtain_part' pref='obtain_part'  onchange='handleCheck(this);'> Obtain part of the item
	</label>

	<div id='obtain_part_radiogroup' style='display:none'>
	<label for='obtain_part_radio' class='pure-radio'>
	<input id='obtain_part_radio-Yes' type='radio' name='obtain_part_radio' pref='obtain_part'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='obtain_part_radio-No' type='radio' name='obtain_part_radio' pref='obtain_part'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='obtain_part_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='obtain_part_text' name='obtain_part_text' rows='5' cols='80' ></textarea>
	</div>

	<label for='obtain_whole' class='pure-checkbox'>
				<input id='obtain_whole' type='checkbox' name='obtain_whole' pref='obtain_whole'  onchange='handleCheck(this);'> Obtain a whole item(s)
	</label>

	<div id='obtain_whole_radiogroup' style='display:none'>
	<label for='obtain_whole_radio' class='pure-radio'>
	<input id='obtain_whole_radio-Yes' type='radio' name='obtain_whole_radio' pref='obtain_whole'  value='Yes' onclick='handleRadio(this);'> Yes
	<input id='obtain_whole_radio-No' type='radio' name='obtain_whole_radio' pref='obtain_whole'  value='No' onclick='handleRadio(this);'> No
	</label>
	</div>

	<div id='obtain_whole_textgroup' style='display:none'>
	<label>Why not?</label>
	<textarea id='obtain_whole_text' name='obtain_whole_text' rows='5' cols='80' ></textarea>
	</div>
</div>
</div>




</fieldset>";







$reformulation_inputstring = "<button id='playpausebutton_prev' style='color: white; background:rgb(28, 184, 65);text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);' class='pure-button' onclick=\"playvideo('prev',0);return false;\"><i id=\"playpauseicon\" class=\"fa fa-repeat\"></i> Replay Previous Query</button>
<br/><br/><button id='playpausebutton_next' style='color: white; background:rgb(28, 184, 65);text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);' class='pure-button' onclick=\"playvideo('next',1);return false;\"><i id=\"playpauseicon\" class=\"fa fa-repeat\"></i> Replay Next Query</button>

<fieldset>
<div id='reformulation_reason_textgroup' >
<label>Please explain why you entered this new query, <br/>and what you were hoping to accomplish by doing so.</label>
<textarea id='reformulation_reason' name='reformulation_reason' rows='5' cols='80' ></textarea>
</div>
</fieldset>";





Util::getInstance()->checkSession();

if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
{






	$collaborativeStudy = Base::getInstance()->getStudyID();

	$base = Base::getInstance();

	$base->populateQuestionID();
	$questionID = $base->getQuestionID();

	makeTaskData();

	if (isset($_POST['intent']))
	{
		$base = new Base();
		$stageID = $base->getStageID();

		$userID=$base->getUserID();
		$projectID=$base->getProjectID();

		$cxn = Connection::getInstance();

		$nexttask = getNextTask();
		if($nexttask['type'] == 'intention'){
			commitanswer_intention();
		}else if($nexttask['type'] == 'reformulation'){
			commitanswer_reformulation();
		}else if($nexttask['type'] == 'save'){
			commitanswer_save();
		}else if($nexttask['type'] == 'unsave'){
			commitanswer_unsave();
		}
		/*
			TODO: Save answers
		 */

		// $res = $cxn->commit("SELECT * FROM video_segments WHERE userID='$userID' and projectid='$projectID' and questionID='$questionID' AND marker_type='query'");





		header("Location: ../index.php");


		// Util::getInstance()->saveAction(basename( __FILE__ ),$stageID,$base);
		// Util::getInstance()->moveToNextStage();
	}
	else
	{
		$base = new Base();
		$userID = $base->getUserID();
		$stageID = $base->getStageID();
		$projectID = $base->getProjectID();
		$cxn = Connection::getInstance();
		$taskNum = $base->getTaskNum();

		$nexttask = getNextTask();
		$taskname = $nexttask['type'];
		$filedir = "/mnt/space/www/coagmento.org/htdocs/fall2015intent/data/videos/mp4/";
		$filename = "user$userID"."task$taskNum".".mp4";

		if(file_exists($filedir.$filename)){
			if($taskname=='intention'){
				$render['title'] = 'Intent Annotation';
				$render['preftext'] = "<p>Below is a video of a query you previously conducted.</p>
				<p><strong>What were you trying to accomplish (what was your intention) during this part of the search?
					Please choose one or more of the \"search intentions\" on the right; if none fits your goal at this point in the search, please
				choose \"Other\", and give a brief exlplanation.</strong></p>";

				$render['video']= "<center>
				<video id='session_video' width='100%'>
					<source id='mp4source' type='video/mp4' src='../data/videos/mp4/$filename#t=".$nexttask['start_stamp']."' >
				</video>
				</center>";
				$render['input']=$intention_inputstring;
				$render['hiddeninputs']="
					<input type=\"hidden\" name=\"time_start\" value=\"".clean_timestr($nexttask['start_stamp'])."\"/>
				";
				$render['javascript'] = $javascript_intention;

			}else if($taskname=='reformulation'){
				$render['title'] = 'Next Query';
				$render['preftext'] = "<p>After issuing the previous query, you issued another one.  Video of these two queries is below.</p>
				<p><strong>Please answer the question on the right-hand-side regarding the reformulation.</strong></p>";

				$render['video']= "<center><strong><u><h4>Previous Query</h4></u></strong>
				<video id='session_video1' width='85%'>
					<source id='mp4source1' type='video/mp4' src='../data/videos/mp4/$filename#t=".$nexttask['start_stamp_prev']."' >
				</video>
				</center>
				<center><strong><u><h4>Next Query</h4></u></strong>
				<video id='session_video2' width='85%'>
					<source id='mp4source2' type='video/mp4' src='../data/videos/mp4/$filename#t=".$nexttask['start_stamp']."' >
				</video>
				</center>";



				$render['input']=$reformulation_inputstring;



				$render['hiddeninputs']="
					<input type=\"hidden\" name=\"time_start\" value=\"".clean_timestr($nexttask['start_stamp'])."\"/>
				";
				$render['javascript'] = $javascript_reformulation;

			}else if($taskname=='save'){
				$render['title'] = 'Saved Page';
				$render['preftext'] = "<p>After issuing the query you just marked for intention, you saved a bookmark.  We show a video of your saving action below.</p>
				<p>Please answer the question on the right hand side about this save.</p>
				";

				$render['video']= "<center><video id='session_video' width='100%'>
					<source id='mp4source' type='video/mp4' src='../data/videos/mp4/$filename#t=".clean_timestr($nexttask['stamps'][0])."' >
				</video></center>";




				$render['input']="";


				for($x=1;$x<=count($nexttask['stamps']);$x+=1){
						$render['input'] .= "<button id='playpausebutton_$x' style='color: white; background:rgb(28, 184, 65);text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);' class='pure-button' onclick='playvideo($x);return false;'><i id=\"playpauseicon_$x\" class=\"fa fa-repeat\"></i> Replay Video</button>

						<fieldset>
						<div id='useful_div_$x' class='container'>
							How useful was this page in helping you to complete and/or understand your assignment?
						<div class='pure-g'>
						<div class='pure-u-1-8'><label for='useful_1_$x' class='pure-radio'><input id='useful_1_$x' type='radio' name='useful_$x' value='1'>1 (Not at all)</label></div>
						<div  style='background-color:#F2F2F2' class='pure-u-1-8'><label for='useful_2_$x' class='pure-radio'><input id='useful_2_$x' type='radio' name='useful_$x' value='2'>2</label></div>
						<div  class='pure-u-1-8'><label for='useful_3_$x' class='pure-radio'><input id='useful_3_$x' type='radio' name='useful_$x' value='3'>3</label></div>
						<div style='background-color:#F2F2F2' class='pure-u-1-8'><label for='useful_4_$x' class='pure-radio'><input id='useful_4_$x' type='radio' name='useful_$x' value='4'>4 (Somewhat)</label></div>
						<div  class='pure-u-1-8'><label for='useful_5_$x' class='pure-radio'><input id='useful_5_$x' type='radio' name='useful_$x' value='5'>5</label></div>
						<div style='background-color:#F2F2F2' class='pure-u-1-8'><label for='useful_6_$x' class='pure-radio'><input id='useful_6_$x' type='radio' name='useful_$x' value='6'>6</label></div>
						<div  class='pure-u-1-8'><label for='useful_7_$x' class='pure-radio'><input id='useful_7_$x' type='radio' name='useful_$x' value='7'>7 (Extremely)</label></div>
						</div>
						</div>

						<div id='confident_div_$x' class='container'>
							How confident are you in your usefulness rating?
						<div class='pure-g'>
						<div class='pure-u-1-8'><label for='confident_1_$x' class='pure-radio'><input id='confident_1_$x' type='radio' name='confident_$x' value='1'>1 (Not at all)</label></div>
						<div  style='background-color:#F2F2F2' class='pure-u-1-8'><label for='confident_2_$x' class='pure-radio'><input id='confident_2_$x' type='radio' name='confident_$x' value='2'>2</label></div>
						<div  class='pure-u-1-8'><label for='confident_3_$x' class='pure-radio'><input id='confident_3_$x' type='radio' name='confident_$x' value='3'>3</label></div>
						<div style='background-color:#F2F2F2' class='pure-u-1-8'><label for='confident_4_$x' class='pure-radio'><input id='confident_4_$x' type='radio' name='confident_$x' value='4'>4 (Somewhat)</label></div>
						<div  class='pure-u-1-8'><label for='confident_5_$x' class='pure-radio'><input id='confident_5_$x' type='radio' name='confident_$x' value='5'>5</label></div>
						<div style='background-color:#F2F2F2' class='pure-u-1-8'><label for='confident_6_$x' class='pure-radio'><input id='confident_6_$x' type='radio' name='confident_$x' value='6'>6</label></div>
						<div  class='pure-u-1-8'><label for='confident_7_$x' class='pure-radio'><input id='confident_7_$x' type='radio' name='confident_$x' value='7'>7 (Extremely)</label></div>
						</div>
						</div>

						</fieldset>";
				}
				$render['hiddeninputs']="

					<input type=\"hidden\" name=\"ninputs\" value=\"".count($nexttask['stamps'])."\"/>
				";
				for($x=1;$x<=count($nexttask['stamps']); $x+=1){
					$render['hiddeninputs'] = $render['hiddeninputs']."<input type=\"hidden\" name=\"time_start_$x\" value=\"".clean_timestr($nexttask['stamps'][$x-1])."\"/>";
				}
				$render['javascript'] = "

				var N_RESULTS = ".count($nexttask['stamps']).";
				".$javascript_save;


			}else if($taskname=='unsave'){
				$render['title'] = 'Unsaved Page';
				$render['preftext'] = "<p>After issuing the query you just marked for intention, you decided to undo a save action.  We show a video of your undo action below.</p>
				<p>Please answer the question on the right hand side about this undo action.</p>";

				$render['video']= "<center><video id='session_video' width='100%'>
					<source id='mp4source' type='video/mp4' src='../data/videos/mp4/$filename#t=".clean_timestr($nexttask['stamps'][0])."' >
				</video></center>";


				$render['input']="";

				for($x=1;$x<=count($nexttask['stamps']);$x+=1){
						$render['input'] .= "<button id='playpausebutton_$x' style='color: white; background:rgb(28, 184, 65);text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);' class='pure-button' onclick='playvideo($x);return false;'><i id=\"playpauseicon_$x\" class=\"fa fa-repeat\"></i> Replay Video</button>

						<fieldset>
						<div id='unsave_reason_textgroup_$x' >
						<label>You decided to unsave this document. <br/>Please say why you made this decision.</label>
						<textarea id='unsave_reason_$x' name='unsave_reason_$x' rows='5' cols='80' ></textarea>
						</div>
						</fieldset>";
				}


				$render['hiddeninputs']="

					<input type=\"hidden\" name=\"ninputs\" value=\"".count($nexttask['stamps'])."\"/>
				";
				for($x=1;$x<=count($nexttask['stamps']); $x+=1){
					$render['hiddeninputs'] = $render['hiddeninputs']."<input type=\"hidden\" name=\"time_start_$x\" value=\"".clean_timestr($nexttask['stamps'][$x-1])."\"/>";
				}
				$render['javascript'] = "

				var N_RESULTS = ".count($nexttask['stamps']).";
				".$javascript_unsave;

			}else if($taskname=='none'){
				Util::getInstance()->saveAction(basename( __FILE__ ),$stageID,$base);
				Util::getInstance()->moveToNextStage();
				exit();
			}


		}


		// $res = $cxn->commit("SELECT * FROM video_segments WHERE userID='$userID' and projectid='$projectID' and questionID='$questionID' AND marker_type='query'");




?>

<html>
<head>
	<link rel="stylesheet" href="../study_styles/custom/text.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="../study_styles/custom/background.css">
	<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/buttons.css">
	<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/forms.css">
	<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/grids-min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<script src="../lib/jquery-2.1.3.min.js"></script>
	<script src="../lib/validation/jquery-validation-1.13.1/dist/jquery.validate.js"></script>
	<script src="../lib/validation/validation.js"></script>
	<title>
		Research Study
    </title>




    <style>
    select {
      font-size:13px;
    }

		.left {
		  position:fixed; // keep fixed to window
		  padding: 10px;
			margin-left: 70%;

		  top: 0; left: 0; bottom: 0; // position to top left of window
			position: fixed;

    	overflow-y: scroll;


		  height:95%; //set dimensions
		  transition: width ease .5s; // fluid transition when resizing

		  /* Sass/Scss only:
		    Using a selector (.open-nav) with an "&" afterward is actually selecting
		  any parent selector. For instance, this outputs "body.open-nav .left { ... }"
		  More info: http://thesassway.com/intermediate/referencing-parent-selectors-using-ampersand
		  */
		  body.open-nav & {
		    width:250px;
		  }

		  ul {
		    list-style:none;
		    margin:0; padding:0;

		    li {
		      margin-bottom:25px;
		    }
		  }

		  a {
		    color:shade(darkslategray, 50%);
		    text-decoration:none;
		    border-bottom:1px solid transparent;
		    transition:
		      color ease .35s,
		      border-bottom-color ease .35s;

		    &:hover {
		       color:white;
		       border-bottom-color:white;
		    }

		    &.open {
		      font-size:1.75rem;
		      font-weight:700;
		      border:0;
		    }
		  }
		}
    </style>

    <script type="text/javascript">

		<?php
			echo $render['javascript'];
		 ?>
    </script>


<style type="text/css">
		.cursorType{
		cursor:pointer;
		cursor:hand;
		}
</style>

</head>



<?php

if(!file_exists($filedir.$filename)){
	?>

<body class="style1">
	<div style="width:90%; margin: 0 auto">

		<center><h2><?php echo $render['title'];?></h2></center>

		<p>Your lab proctor has not yet uploaded the necessary files to continue with the study.  Please wait momentarily to refresh this page.  We apologize for the inconvenience.</p>
	</div>
</body>
</html>
	<?php
		exit();
	}else{

		$base = Base::getInstance();
		$userID = $base->getUserID();
		$projectID = $base->getProjectID();
		$questionID = $base->getQuestionID();
		$stageID = 15;
		$query =  "UPDATE video_segments SET userID='$userID',projectID='$projectID',questionID='$questionID',stageID='$stageID' WHERE userID IS NULL AND projectID IS NULL AND `Elapsed Time` IS NOT NULL";
		$cxn = Connection::getInstance($query);
		$query = "DELETE FROM video_segments WHERE `Elapsed Time` IS NULL";
		$cxn->commit($query);
 ?>
<body class="style1" onload="init();">
<br/>
<div style="width:90%; margin: 0 auto">
	<div style="margin-right:30%">
	<center><h2><?php echo $render['title'];?></h2></center>

	<?php
		echo $render['preftext'];
		echo $render['video'];


	 ?>

</div>








	<form onSubmit="return validate();" class="pure-form pure-form-stacked" method=post>
		<div class='grayrect left'>

		<div style="display:none">
			<select id="timeslice" onchange="shownext();">
	<?php
		// $res = $cxn->commit("SELECT time_startstring,time_stopstring FROM video_segments WHERE userID='$userID' and projectid='$projectID' and questionID='$questionID' AND marker_type='query' ORDER BY segmentID ASC");


		$nexttask = getNextTask();
		$taskname = $nexttask['type'];
		if($taskname=='intention'){
			$start_stamp = $nexttask['start_stamp'];
			$start_int = timestrToInt($start_stamp);
			$start_int -= 2;
			$start_stamp = intToPHPTime($start_int);

			$stop_stamp = $nexttask['stop_stamp'];
			$stop_int = timestrToInt($stop_stamp);
			$stop_stamp = intToPHPTime($stop_int);

			echo "<option id='time_1' value='1' starttime='$start_int' stoptime='$stop_int'>".$start_stamp."-".$stop_stamp."</option>";
		}else if($taskname=='reformulation'){
			$start_stamp = $nexttask['start_stamp'];
			$start_int = timestrToInt($start_stamp);
			$start_int -= 2;
			$start_stamp = intToPHPTime($start_int);

			$stop_stamp = $nexttask['stop_stamp'];
			$stop_int = timestrToInt($stop_stamp);
			$stop_stamp = intToPHPTime($stop_int);

			echo "<option id='time_1' value='1' starttime='$start_int' stoptime='$stop_int'>".$start_stamp."-".$stop_stamp."</option>";

			$start_stamp = $nexttask['start_stamp_prev'];
			$start_int = timestrToInt($start_stamp);
			$start_int -= 2;
			$start_stamp = intToPHPTime($start_int);

			$stop_stamp = $nexttask['stop_stamp_prev'];
			$stop_int = timestrToInt($stop_stamp);
			$stop_stamp = intToPHPTime($stop_int);

			echo "
			<option id='time_0' value='0' starttime='$start_int' stoptime='$stop_int'>".$start_stamp."-".$stop_stamp."</option>";
		}else if($taskname=='save' or $taskname=='unsave'){
			$task = '';
			if($taskname=='save'){
				$task = 'save';
			}else{
				$task = 'unsave';
			}

			for($x=0;$x<count($nexttask['stamps']);$x+=1){
				$i = $x+1;
				$start_stamp = $nexttask['stamps'][$x];
				$start_int = timestrToInt($start_stamp);
				$start_int -= 5;
				$stop_int = $start_int + 10;
				$start_stamp = intToPHPTime($start_int);
				$stop_stamp = intToPHPTime($stop_int);
				echo "<option id='time_$i' value='$i' starttime='$start_int' stoptime='$stop_int'>".$start_stamp."-".$stop_stamp."</option>";
			}
		}


		// while($line = mysql_fetch_array($res,MYSQL_ASSOC)){
		// 	$x += 1;
		// 	$start_time = preg_replace('/[[:^print:]]/', '', $line['Elapsed Time']);
		//
		// 	if(substr_count($start_time,":")<2){
		// 		while(substr_count($start_time,":") != 2){
		// 			$start_time = "00:". $start_time;
		// 		}
		// 	}
		// 	$start_time = substr($start_time,0,-2);
		//
		//
		// 	$stop_time = preg_replace('/[[:^print:]]/', '', $line['time_stopstring']);
		// 	if(substr_count($stop_time,":")<2){
		// 		while(substr_count($stop_time,":") != 2){
		// 			$stop_time = "00:". $stop_time;
		// 		}
		// 	}
		//
		// 	$stop_time = substr($stop_time,0,-2);
		//
		// 	$start_time_string = $start_time;
		// 	$stop_time_string = $stop_time;
		//
		// 	$start_time = strtotime($start_time) - strtotime('TODAY');
		// 	$stop_time = strtotime($stop_time) - strtotime('TODAY');
		//
		//
		// 	$time_range[$x] = $start_time_string."-".$stop_time_string;
		// }

	 ?>
		</select>
	</div>

		<?php






		?>
	<div id='checkboxset' style='display:block'>
		<?php

		$progress = getProgress();
		$c = $progress['count'];
		$t = $progress['total'];
		echo "<p><h4><u>Progress: $c/$t </u></h4></p>";
		?>

		<p>Please complete the form below to the best of your ability.</p>
		<input type="hidden" name="intent" value="true"/>
		<?php
			echo $render['hiddeninputs'];
		 ?>
		  <button class="pure-button pure-button-primary" type="submit">Submit</button>
			<br/>
			<hr/>

		<div id='error_text' style='display:none'>
	 	 <p style='color:red'>Please complete the form below to the best of your ability.</p>
	  </div>

		<?php
		echo $render['input'];
		?>



	</div>



</div>





</form>
</div>
</body>
</html>


<?php
		}
	}
}
else {
	echo "Something went wrong. Please <a href=\"../index.php\">try again </a>.\n";
}

	?>

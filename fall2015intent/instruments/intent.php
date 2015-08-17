<?php


session_start();
require_once('../core/Base.class.php');
require_once('../core/Util.class.php');
require_once('../core/Connection.class.php');
require_once('../core/Questionnaires.class.php');


Util::getInstance()->checkSession();

if (Util::getInstance()->checkCurrentPage(basename( __FILE__ )))
{
	$collaborativeStudy = Base::getInstance()->getStudyID();

	if (isset($_POST['intent']))
	{
		$base = new Base();
		$stageID = $base->getStageID();

		$userID=$base->getUserID();
		$projectID=$base->getProjectID();

		$questionID='';

		$cxn = Connection::getInstance();

		if($stageID < 40){
			$questionID=2;
		}else{
			$questionID=3;
		}


		/*
			TODO: Save answers
		 */

		$res = $cxn->commit("SELECT * FROM video_segments WHERE userID='$userID' and projectid='$projectID' and questionID='$questionID'");
		$N_RESULTS = mysql_num_rows($res);
		print_r($_POST);


		for($x=1; $x <= $N_RESULTS; $x += 1){


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



			if(isset($_POST[ "id_start"."_$x"])){
				$id_start = 1;
			}
			if(isset($_POST[ "id_more"."_$x"])){
				$id_more = 1;
			}
			if(isset($_POST[ "learn_feature"."_$x"])){
				$learn_feature = 1;
			}
			if(isset($_POST[ "learn_structure"."_$x"])){
				$learn_structure = 1;
			}
			if(isset($_POST[ "learn_domain"."_$x"])){
				$learn_domain = 1;
			}
			if(isset($_POST[ "learn_database"."_$x"])){
				$learn_database = 1;
			}
			if(isset($_POST[ "find_known"."_$x"])){
				$find_known = 1;
			}
			if(isset($_POST[ "find_specific"."_$x"])){
				$find_specific = 1;
			}
			if(isset($_POST[ "find_common"."_$x"])){
				$find_common = 1;
			}
			if(isset($_POST[ "find_without"."_$x"])){
				$find_without = 1;
			}
			if(isset($_POST[ "locate_specific"."_$x"])){
				$locate_specific = 1;
			}
			if(isset($_POST[ "locate_common"."_$x"])){
				$locate_common = 1;
			}
			if(isset($_POST[ "locate_area"."_$x"])){
				$locate_area = 1;
			}
			if(isset($_POST[ "keep_bibliographical"."_$x"])){
				$keep_bibliographical = 1;
			}
			if(isset($_POST[ "keep_link"."_$x"])){
				$keep_link = 1;
			}
			if(isset($_POST[ "keep_item"."_$x"])){
				$keep_item = 1;
			}
			if(isset($_POST[ "access_item"."_$x"])){
				$access_item = 1;
			}
			if(isset($_POST[ "access_common"."_$x"])){
				$access_common = 1;
			}
			if(isset($_POST[ "access_area"."_$x"])){
				$access_area = 1;
			}
			if(isset($_POST[ "evaluate_correctness"."_$x"])){
				$evaluate_correctness = 1;
			}
			if(isset($_POST[ "evaluate_specificity"."_$x"])){
				$evaluate_specificity = 1;
			}
			if(isset($_POST[ "evaluate_usefulness"."_$x"])){
				$evaluate_usefulness = 1;
			}
			if(isset($_POST[ "evaluate_best"."_$x"])){
				$evaluate_best = 1;
			}
			if(isset($_POST[ "evaluate_duplication"."_$x"])){
				$evaluate_duplication = 1;
			}
			if(isset($_POST[ "obtain_specific"."_$x"])){
				$obtain_specific = 1;
			}
			if(isset($_POST[ "obtain_part"."_$x"])){
				$obtain_part = 1;
			}
			if(isset($_POST[ "obtain_whole"."_$x"])){
				$obtain_whole = 1;
			}


			$cxn->commit("INSERT INTO video_intent_assignments (userID,projectID,stageID,`id_start`,
				`id_more`,`learn_feature`,`learn_structure`,`learn_domain`,`learn_database`,
				`find_known`,`find_specific`,`find_common`,`find_without`,`locate_specific`,
				`locate_common`,`locate_area`,`keep_bibliographical`,`keep_link`,`keep_item`,
				`access_item`,`access_common`,`access_area`,`evaluate_correctness`,`evaluate_specificity`,`evaluate_usefulness`,
				`evaluate_best`,`evaluate_duplication`,`obtain_specific`,`obtain_part`,`obtain_whole`) VALUES ('$userID','$projectID','$stageID','$id_start',
				'$id_more','$learn_feature','$learn_structure','$learn_domain','$learn_database',
				'$find_known','$find_specific','$find_common','$find_without','$locate_specific',
				'$locate_common','$locate_area','$keep_bibliographical','$keep_link','$keep_item',
				'$access_item','$access_common','$access_area','$evaluate_correctness','$evaluate_specificity','$evaluate_usefulness',
				'$evaluate_best','$evaluate_duplication','$obtain_specific','$obtain_part','$obtain_whole')");

		}
		Util::getInstance()->saveAction(basename( __FILE__ ),$stageID,$base);
		Util::getInstance()->moveToNextStage();
	}
	else
	{
		$base = new Base();
		$userID = $base->getUserID();
		$stageID = $base->getStageID();
		$projectID = $base->getProjectID();
		$cxn = Connection::getInstance();
		$taskNum = $base->getTaskNum();

		$questionID='';

		if($stageID < 40){
			$questionID=2;
		}else{
			$questionID=3;
		}

		$res = $cxn->commit("SELECT * FROM video_segments WHERE userID='$userID' and projectid='$projectID' and questionID='$questionID'");
		$N_RESULTS = mysql_num_rows($res);


		$filename = "user$userID"."task$taskNum".".mp4";

?>

<html>
<head>
	<link rel="stylesheet" href="../study_styles/custom/text.css">
	<link rel="stylesheet" href="../study_styles/custom/background.css">
	<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/buttons.css">
	<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/forms.css">
	<link rel="stylesheet" href="../study_styles/pure-release-0.5.0/grids-min.css">
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
    </style>

    <script type="text/javascript">

		var N_RESULTS = <?php echo $N_RESULTS;?>;
		function validate(){
			var retval = true;
			for (x=1; x<=N_RESULTS;x+=1){
				var l = $("#checkboxset"+x).find("input:checked").length;

				if (l > 0){
						$("#error_text_"+x).css('display','none');
						$("#time_"+x).css('background-color','');
				}else{
						$("#error_text_"+x).css('display','block');
						$("#time_"+x).css('background-color','red');
				}

				retval = retval && (l > 0);
			}



			if(retval==false){

				$("#error_text").css('display','block');
			}else{

				$("#error_text").css('display','none');
			}
			return retval;
		}

		function shownext(){
			shownext_helper(parseInt($("#timeslice").val()));
			var i = parseInt($("#timeslice").val());
			playVideoHelper(parseInt($("#time_"+i).attr("starttime")),parseInt($("#time_"+i).attr("stoptime")));
		}



		var VIDEO;
		var pausing_function;
		var STOP_TIME = 0;
		var START_TIME = 0;

		function init(){
			VIDEO = document.getElementById("session_video");
			pausing_function = function(){
 		    if(this.currentTime >= STOP_TIME) {
 		        this.pause();
 		    }
 			};
			VIDEO.addEventListener("timeupdate", pausing_function);

		}






		function playvideo(i){
				playVideoHelper(parseInt($("#time_"+i).attr("starttime")),parseInt($("#time_"+i).attr("stoptime")));
		}

		function playVideoHelper(start,stop){
			// alert("START"+start);
			// alert("STOP"+stop);
			document.getElementById("session_video").currentTime = start;
			STOP_TIME = stop;
			START_TIME = start;
			$("#mp4source").attr("src","../data/videos/mp4/<?php echo $filename;?>#t="+start+","+stop);
			document.getElementById("session_video").play();
		}

		function shownext_helper(i){
			for (x=1; x<=N_RESULTS;x+=1){
				if(x==i){
						$("#checkboxset"+x).css('display','block');

				}else{
						$("#checkboxset"+x).css('display','none');

				}
			}
		}

    </script>


<style type="text/css">
		.cursorType{
		cursor:pointer;
		cursor:hand;
		}
</style>
</head>
<body class="style1" onload="init();">
<br/>
<div style="width:90%; margin: 0 auto">
	<center><h2>Pre-Task Questionnaire</h2></center>

	<p>The following is a video.  We have marked some of the below as query segments.</p>

	<p>Annotate the segments with intents!</p>
	<video id="session_video" width="100%">
		<source id="mp4source" type="video/mp4" src="../data/videos/mp4/<?php echo $filename;?>" >
	</video>

<hr>
<br>

<p><h4><u>Time slice</u></h4></p>

	<select id="timeslice" onchange="shownext();">
<?php
	$res = $cxn->commit("SELECT time_startstring,time_stopstring FROM video_segments WHERE userID='$userID' and projectid='$projectID' and questionID='$questionID' ORDER BY segmentID ASC");

	$x = 0;
	while($line = mysql_fetch_array($res,MYSQL_ASSOC)){
		$x += 1;
		$start_time = preg_replace('/[[:^print:]]/', '', $line['time_startstring']);

		if(substr_count($start_time,":")<2){
			while(substr_count($start_time,":") != 2){
				$start_time = "00:". $start_time;
			}
		}


		$stop_time = preg_replace('/[[:^print:]]/', '', $line['time_stopstring']);
		if(substr_count($stop_time,":")<2){
			while(substr_count($stop_time,":") != 2){
				$stop_time = "00:". $stop_time;
			}
		}
		$start_time = substr($start_time,0,-2);
		$stop_time = substr($stop_time,0,-2);

		$start_time_string = $start_time;
		$stop_time_string = $stop_time;

		$start_time = strtotime($start_time) - strtotime('TODAY');
		$stop_time = strtotime($stop_time) - strtotime('TODAY');
		echo "<option id='time_$x' value='$x' starttime='$start_time' stoptime='$stop_time'>".$start_time_string."-".$stop_time_string."</option>";
	}

 ?>
	</select>






	<form onSubmit="return validate();" class="pure-form pure-form-stacked" method=post>

<?php

	for($x=1;$x<=$N_RESULTS;$x+=1)
	{


		if($x==1){
				echo "<div id='checkboxset$x' class='grayrect' style='display:block'>";
		}else{
				echo "<div id='checkboxset$x' class='grayrect' style='display:none'>";
		}

		echo "<div id='error_text_$x' style='display:none'>
	 	 <p style='color:red'>Please mark the checkboxes below to the best of your ability.</p>
	  </div>";

		echo "<button  style='color: white; background:rgb(28, 184, 65);text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);' class='pure-button' onclick='playvideo($x);return false;'>Replay Video</button>
		<fieldset>
			<div class='pure-g'>
		<div class='pure-u-1-2'>
			<label><h4><u>Identify search information</u></h4></label>

			<label for='id_start_$x' class='pure-checkbox'>
            <input id='id_start_$x' type='checkbox' name='id_start_$x'> Identify something to get started
      </label>

			<label for='id_more_$x' class='pure-checkbox'>
            <input id='id_more_$x' type='checkbox' name='id_more_$x'> Identify something more to search
      </label>
		</div>



		<div class='pure-u-1-2'>
			<label><h4><u>Learning</u></h4></label>

			<label for='learn_feature_$x' class='pure-checkbox'>
            <input id='learn_feature_$x' type='checkbox' name='learn_feature_$x'> Learn system feature
      </label>

			<label for='learn_structure_$x' class='pure-checkbox'>
            <input id='learn_structure_$x' type='checkbox' name='learn_structure_$x'> Learn system structure
      </label>

			<label for='learn_domain_$x' class='pure-checkbox'>
            <input id='learn_domain_$x' type='checkbox' name='learn_domain_$x'> Learn domain knowledge
      </label>

			<label for='learn_database_$x' class='pure-checkbox'>
            <input id='learn_database_$x' type='checkbox' name='learn_database_$x'> Learn database content
      </label>
		</div>

	</div>



	<div class='pure-g'>

		<div class='pure-u-1-2'>
			<label><h4><u>Finding</u></h4></label>

			<label for='find_known_$x' class='pure-checkbox'>
            <input id='find_known_$x' type='checkbox' name='find_known_$x'> Find a known item
      </label>

			<label for='find_specific_$x' class='pure-checkbox'>
            <input id='find_specific_$x' type='checkbox' name='find_specific_$x'> Find specific information
      </label>

			<label for='find_common_$x' class='pure-checkbox'>
            <input id='find_common_$x' type='checkbox' name='find_common_$x'> Find items with common characteristics
      </label>

			<label for='find_without_$x' class='pure-checkbox'>
            <input id='find_without_$x' type='checkbox' name='find_without_$x'> Find items without predefined criteria
      </label>
		</div>



		<div class='pure-u-1-2'>
			<label><h4><u>Locate: Find out where a specific item is placed</u></h4></label>

			<label for='locate_specific_$x' class='pure-checkbox'>
            <input id='locate_specific_$x' type='checkbox' name='locate_specific_$x'> Locate a specific item
      </label>

			<label for='locate_common_$x' class='pure-checkbox'>
            <input id='locate_common_$x' type='checkbox' name='locate_common_$x'> Locate items with common characteristics
      </label>

			<label for='locate_area_$x' class='pure-checkbox'>
            <input id='locate_area_$x' type='checkbox' name='locate_area_$x'> Locate an area/location
      </label>
		</div>
	</div>



	<div class='pure-g'>
		<div class='pure-u-1-2'>
			<label><h4><u>Keep record</u></h4></label>

			<label for='keep_bibliographical_$x' class='pure-checkbox'>
            <input id='keep_bibliographical_$x' type='checkbox' name='keep_bibliographical_$x'> Keep record of bibliographical information
      </label>

			<label for='keep_link_$x' class='pure-checkbox'>
            <input id='keep_link_$x' type='checkbox' name='keep_link_$x'> Keep record of link
      </label>

			<label for='keep_item_$x' class='pure-checkbox'>
            <input id='keep_item_$x' type='checkbox' name='keep_item_$x'> Note item for return
      </label>
		</div>




		<div class='pure-u-1-2'>
			<label><h4><u>Access an item based on its location</u></h4></label>

			<label for='access_item_$x' class='pure-checkbox'>
            <input id='access_item_$x' type='checkbox' name='access_item_$x'> Access a specific item
      </label>

			<label for='access_common_$x' class='pure-checkbox'>
            <input id='access_common_$x' type='checkbox' name='access_common_$x'> Access items with common characteristics
      </label>

			<label for='access_area_$x' class='pure-checkbox'>
            <input id='access_area_$x' type='checkbox' name='access_area_$x'> Access an area/location
      </label>
		</div>
	</div>



	<div class='pure-g'>
		<div class='pure-u-1-2'>
			<label><h4><u>Evaluate</u></h4></label>

			<label for='evaluate_correctness_$x' class='pure-checkbox'>
            <input id='evaluate_correctness_$x' type='checkbox' name='evaluate_correctness_$x'> Evaluate correctness of an item
      </label>

			<label for='evaluate_specificity_$x' class='pure-checkbox'>
            <input id='evaluate_specificity_$x' type='checkbox' name='evaluate_specificity_$x'> Evaluate specificity of an item
      </label>

			<label for='evaluate_usefulness_$x' class='pure-checkbox'>
            <input id='evaluate_usefulness_$x' type='checkbox' name='evaluate_usefulness_$x'> Evaluate usefulness of an item
      </label>

			<label for='evaluate_best_$x' class='pure-checkbox'>
            <input id='evaluate_best_$x' type='checkbox' name='evaluate_best_$x'> Pick best item(s) from all the useful ones
      </label>

			<label for='evaluate_duplication_$x' class='pure-checkbox'>
            <input id='evaluate_duplication_$x' type='checkbox' name='evaluate_duplication_$x'> Evaluate duplication of an item
      </label>
		</div>


		<div class='pure-u-1-2'>
			<label><h4><u>Obtain</u></h4></label>

			<label for='obtain_specific_$x' class='pure-checkbox'>
            <input id='obtain_specific_$x' type='checkbox' name='obtain_specific_$x'>  Obtain specific information
      </label>

			<label for='obtain_part_$x' class='pure-checkbox'>
            <input id='obtain_part_$x' type='checkbox' name='obtain_part_$x'> Obtain part of the item
      </label>

			<label for='obtain_whole_$x' class='pure-checkbox'>
            <input id='obtain_whole_$x' type='checkbox' name='obtain_whole_$x'> Obtain a whole item(s)
      </label>
		</div>
	</div>




	  </fieldset>


	</div>";
}

?>

<br/>


<hr>

<div id='error_text' style="display:none">
	<p style="color:red">Some of the video segments above do not have any corresponding input.  They are shown above in red.  Please complete them to the best of your ability</p>
</div>

<input type="hidden" name="intent" value="true"/>
  <button class="pure-button pure-button-primary" type="submit">Submit</button>
</form>
</div>
</body>
</html>


<?php
	}
}
else {
	echo "Something went wrong. Please <a href=\"../index.php\">try again </a>.\n";
}

	?>

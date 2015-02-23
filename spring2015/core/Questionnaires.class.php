<?php
require_once('Connection.class.php');
// Possible validators (currently using jQuery validation):
// Parsley: http://parsleyjs.org
// jQuery Validation: http://jqueryvalidation.org
// List: http://blog.revrise.com/web-form-validation-javascript-libraries/

// Documentation for questions
// Radio:
// {"options":{<name:value> pairs}}

// TODO: likertgroup question type - a set of questions under one heading (?).
// key: db key
// Rank order: variable number for rank order (current=3)
// Likert: variable number for Likert (current=5)
// What to do about registration information? We arguably want to put that in another table


class Questionnaires
{
	private static $instance;
	private static $db_selected = "questionnaire_questions";
	private $link;
	private $lastID;
	private static $questions;

	// Cache of questions

	public function __construct() {
		$this->questions = array();
	}

	public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }


		public function populateQuestionsFromDatabase($questionnaire_name,$orderBy = NULL){
			$cxn = Connection::getInstance();
			$db_selected = self::$db_selected;

			$query = "SELECT * from $db_selected";

			if($orderBy != NULL){
				$query .= " ORDER BY $orderBy";
			}
			$results = $cxn->commit($query);
			if (!$results){
				return false;
			}else{

				while($line = mysql_fetch_array($results,MYSQL_ASSOC)){
					$questionID = $line['questionID'];
					$question = $line['question'];
					$type = $line['question_type'];
					$data = json_decode($line['question_data']);
					$key = $line['key'];
					array_push($this->questions,array(
						'questionID'=>$questionID,
						'question'=>$question,
						'question_type'=>$type,
						'question_data'=>$data,
						'key'=>$key
					));

				}
				return true;
			}
		}

		public function isQuestionnaireComplete($userID,$projectID,$questionnaire_name,$answers_database=''){
		}


		public function addQuestion(){

		}

		public function addQuestionAt($index){

		}


		public function clearCache(){
			$this->questions = array();
		}

		public function popQuestion(){

		}

		public function removeQuestionAt($index){

		}

		public function printQuestions($min=-1,$max=INF){
			if($min==-1){
				$min = 0;
			}else{
				$min = max(array($min,0));

			}
			if($max==INF){
				$max = count($this->questions)-1;
			}else{
				$max = min(array($max,count($this->questions)-1));

			}
			for($i = $min; $i <=$max; $i++){
				$q = $this->questions[$i];
				if($q['question_type']=='select'){
					$this->printSelect($q['question'],$q['key'],$q['question_data']);
				}else if($q['question_type']=='radio'){
					$this->printRadio($q['question'],$q['key'],$q['question_data']);
				}else if($q['question_type']=='rankedorder'){
					$this->printRankedOrder($q['question'],$q['key'],$q['question_data']);
				}else if($q['question_type']=='likert'){
					$this->printLikert($q['question'],$q['key'],$q['question_data']);
				}
				if($q['question_type']!='select'){
					echo "<br>";
				}

			}
		}

		public function printPreamble(){
			//Prints <link rel= ...>
			echo "<link rel=\"stylesheet\" href=\"study_styles/pure-release-0.5.0/buttons.css\">";
			echo "<link rel=\"stylesheet\" href=\"study_styles/pure-release-0.5.0/forms.css\">";
		  echo "<link rel=\"stylesheet\" href=\"study_styles/pure-release-0.5.0/grids-min.css\">";
			echo "<script src=\"lib/jquery-2.1.3.min.js\"></script>";
			echo "<script src=\"lib/validation/jquery-validation-1.13.1/dist/jquery.validate.js\"></script>";
			echo "<script src=\"lib/validation/validation.js\"></script>";
		}

		public function printPostamble(){
			echo "";
		}

		public function printValidation($formid,$rules,$messages){
			// jQUery.validator.addMethod
			echo "jQuery.validator.addMethod(\"rankedorder\", function(value, element) {
					return isRankedOrderValid(value);}, \"<span style='color:red'>Please specify a ranked order according to the description above.</span>\");";
			echo "\$().ready(function(){";
				echo "\$(\"#$formid\").validate({";
					// Ignore none
					echo "ignore:\"\",\n";
					// Rules
					echo "rules: {";
					echo $rules;
					for($i = 0; $i <=count($this->questions)-1; $i++){
						$q = $this->questions[$i];
						$type = $q['question_type'];
						$key = $q['key'];
						if($type == 'radio'){
							echo "$key"."_1 :{required: true}";
							if($i != count($this->questions)-1){
								echo ",";
							}
							echo "\n";
						}else if($type == 'select'){
							echo "$key"."_1 :{required: true}";
							if($i != count($this->questions)-1){
								echo ",";
							}
							echo "\n";
						}else if($type == 'likert'){
							echo "$key"."_1 :{required: true}";
							if($i != count($this->questions)-1){
								echo ",";
							}
							echo "\n";
						}else if($type == 'rankedorder'){
							echo "$key"."_div_key :{rankedorder: true}";
							if($i != count($this->questions)-1){
								echo ",";
							}
							echo "\n";
						}

					}
					echo "},";
					// Messages

					echo "messages: {";
					echo $messages;
					for($i = 0; $i <=count($this->questions)-1; $i++){
						$q = $this->questions[$i];
						$type = $q['question_type'];
						$key = $q['key'];
						if($type == 'radio'){
							echo "$key"."_1 :{required: \"<span style='color:red'>Please select an option.</span>\"}";
							if($i != count($this->questions)-1){
								echo ",";
							}
							echo "\n";
						}else if($type == 'select'){
							echo "$key"."_1 :{required: \"<span style='color:red'>Please select an option.</span>\"}";
							if($i != count($this->questions)-1){
								echo ",";
							}
							echo "\n";
						}else if($type == 'likert'){
							echo "$key"."_1 :{required: \"<span style='color:red'>Please select an option.</span>\"}";
							if($i != count($this->questions)-1){
								echo ",";
							}
							echo "\n";
						}
					}
					echo "},";
					// Extra

				echo "			errorPlacement: function(error, element)
    			{
        if ( element.is(\":radio\") )
        {
            error.appendTo( element.parents('.container') );
        }
        else
        { // This is the default behavior
            error.insertAfter( element );
        }
    		}";

				echo "});";

				echo "var doneyes = $(\"#doneproj_1-Yes\");
				var doneno = $(\"#doneproj_1-No\");
				var initial = doneyes.is(\":checked\");
				doneyes.click(function(){
					document.getElementById('experience_satisfaction_1_div').style.display=\"block\";
					document.getElementById('outcome_satisfaction_1_div').style.display=\"block\";
					document.getElementById('experience_satisfaction_1').disabled=false;
					document.getElementById('outcome_satisfaction_1').disabled=false;
				});
				doneno.click(function(){
					document.getElementById('experience_satisfaction_1_div').style.display=\"none\";
					document.getElementById('outcome_satisfaction_1_div').style.display=\"none\";
					document.getElementById('experience_satisfaction_1').disabled=true;
					document.getElementById('outcome_satisfaction_1').disabled=true;
				});
				document.getElementById('experience_satisfaction_1_div').style.display=\"none\";
				document.getElementById('experience_satisfaction_1_div').style.paddingLeft=\"60px\";
				document.getElementById('experience_satisfaction_1_div').style.backgroundColor=\"#F2F2F2\";
				document.getElementById('outcome_satisfaction_1_div').style.display=\"none\";
				document.getElementById('outcome_satisfaction_1_div').style.paddingLeft=\"60px\";
				document.getElementById('outcome_satisfaction_1_div').style.backgroundColor=\"#F2F2F2\";
				// style=\"display: none; padding-left:60px; background-color:#F2F2F2\"
				";

			echo "});";


		}

		public function printRadio($question,$key,$data){

			echo "<div class=\"pure-control-group\">";
			echo "<label name=\"$key\">$question</label>";
			echo "<div id=\"$key"."_div_1\" class=\"container\">";
			echo "<label for=\"$key"."_1\" class=\"pure-radio\">";
			foreach($data->{'options'} as $optionkey=>$optionvalue){
				echo "<input id=\"$key"."_1-$optionvalue\" type=\"radio\" name=\"$key"."_1\" value=\"$optionvalue\"> $optionkey ";
			}
			echo "</label>";
			echo "</div>";
			echo "</div>";
		}

		public function printSelect($question,$key,$data){
			echo "<div class=\"pure-control-group\">\n";
			echo "<div id=\"$key"."_1_div\">";
			echo "<label name=\"$key"."_1\">$question</label>\n";
			echo "<select name=\"$key"."_1\" id=\"$key"."_1\" required>\n";
			echo "<option disabled selected>--Select one--</option>\n";
			foreach($data->{'options'} as $optionkey=>$optionvalue){
				echo "<option>$optionvalue</option>\n";
			}
			echo "</select>\n";
			echo "<br>\n";
			echo "</div>\n";
			echo "</div>\n\n";

		}

		public function printRankedOrder($question,$key,$data){

			echo "<label>$question</label>\n";
			echo "<div class=\"pure-form-aligned\">\n";
			echo "<input type=\"hidden\" name=\"$key"."_div_key\" value=\"$key"."_div\">";
			echo "<div id=\"$key"."_div\">\n";
			echo "<fieldset>\n";

			foreach($data->{'options'} as $q=>$k){
			  $pref = $k;
			  $description = $q;
			  echo "<div class=\"pure-control-group\" style=\"background-color:#F2F2F2\">\n";
			  echo "<label for=\"".$pref."_1\">$description</label>\n";
			  echo "<input id=\"".$pref."_1\" size=1 maxlength=\"1\" onkeypress='return (event.charCode < 47) || (event.charCode >= 49 && event.charCode <= 51) || (event.charCode >= 97 && event.charCode <= 99)' name=\"".$pref."_1\" type=\"text\">\n";
			  echo "</div>\n";
			}
			echo "</fieldset>\n";
			echo "</div>\n";
			echo "</div>\n\n";

		}

		public function printLikert($question,$key,$data){
			$pref = $key;
			echo "<div style=\"border:1px solid gray; border-right-width:0px;border-left-width:0px\">\n";
			echo "<label \">$question</label>\n";
			echo "<div id=\"".$pref."_div_1\" class=\"container\">\n";
			echo "<div class=\"pure-g\">\n";
			$count = 1;
			foreach($data->{'options'} as $k=>$v){
				$style = "";
				if(($count)%2){
					$style = "style=\"background-color:#F2F2F2\"";
				}
				echo "<div $style class=\"pure-u-1-5\">";
				echo "<label for=\"".$pref."_1_1\" class=\"pure-radio\">";
				echo "<input id=\"".$pref."_1_1\" type=\"radio\" name=\"".$pref."_1\" value=\"$v\">$k";
				echo "</label>";
				echo "</div>\n";
				$count += 1;
			}
			echo "</div>\n";
			echo "</div>\n";
			echo "</div>\n\n";
		}


 }
?>

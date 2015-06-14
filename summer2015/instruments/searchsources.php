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

	if (isset($_POST['searchsources']))
	{
		$base = new Base();
		$stageID = $base->getStageID();

		$userID=$base->getUserID();


		/*

		SUBMIT ANSWER!


		*/

		foreach($_POST as $k=>$v){
			if ($k != "searchsources"){
				$questionnaire->addAnswer($keytoadd,$v);
			}
		}
		$questionnaire->commitAnswersToDatabase(array("$userID","$projectID","$stageID"),array('userID','projectID','stageID'),'questionnaire_repeated');


		Util::getInstance()->saveAction(basename( __FILE__ ),$stageID,$base);
		Util::getInstance()->moveToNextStage(); 
	}
	else
	{
		$base = new Base();
		$userID = $base->getUserID();
		$stageID = $base->getStageID();
		$projectID = $base->getProjectID();

		$questionnaire = Questionnaires::getInstance();
		$questionnaire->clearCache();
		$questionnaire->populateQuestionsFromDatabase("summer2015-repeated","questionID ASC");
		$questionnaire->setBaseDirectory("../");



?>

<html>
<head>
<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type='text/javascript' src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<link href="https://s3.amazonaws.com/mturk-public/bs30/css/bootstrap.min.css" rel="stylesheet" />
<script>
// When the document is ready
$(document).ready(function () {


var assignmentId = turkGetParam('assignmentId', '');
if(assignmentId != '' && assignmentId != 'ASSIGNMENT_ID_NOT_AVAILABLE'){
	$('#next1').hide();
    $('#prev1').hide();
    $('#next2').show();
    $('#prev2').show();
    $('#begin_header').show();
    $('#preview_header').hide();


    var mod = Math.floor(Math.random()*1000+1)%3;

    $("#mod").val(mod);


    if(mod==0){
        $(".input-first").css('display','block');
        $(".input-second").css('display','none');
        $(".input-third").css('display','none');
        $("#condition").val('first');
    }else if(mod==1){
        $(".input-first").css('display','none');
        $(".input-second").css('display','block');
        $(".input-third").css('display','none');
        $("#condition").val('second');
    }else{
        $(".input-first").css('display','none');
        $(".input-second").css('display','none');
        $(".input-third").css('display','block');
        $("#condition").val('third');
    }

    $('#submitButton').hide();
}else{
    $('#next1').hide();
    $('#prev1').hide();
    $('#next2').hide();
    $('#prev2').hide();
    $('#begin_header').hide();
    $('#preview_header').show();

}


$('#next1').click(function(event) {
    $('.current').removeClass('current').hide()
        .next().show().addClass('current');

    $('#next1').show();
    $('#prev1').show();
    $('#instructions_panel').hide();


    if ($('.current').hasClass('last')) {
        $('#next1').attr('disabled', true);
        $('#next2').attr('disabled', true);
        window.scrollTo(0,$('#prev1').offset().top);
        $('#submitButton').show();
        $('#end-alert').show();
    }else{
        window.scrollTo(0,$('#prev1').offset().top);
        $('#submitButton').hide();
        $('#end-alert').hide();
    }
    $('#prev1').attr('disabled', null);
    $('#prev2').attr('disabled', null);



    event.preventDefault();
    event.stopPropagation();
});

$('#prev1').click(function(event) {
    $('.current').removeClass('current').hide()
        .prev().show().addClass('current');

        $('#next1').show();
        $('#prev1').show();
        $('#instructions_panel').hide();

    if ($('.current').hasClass('first')) {
    $('#instructions_panel').show();
    $('#next1').hide();
    $('#prev1').hide();
        $('#prev1').attr('disabled', true);
        $('#prev2').attr('disabled', true);
        window.scrollTo(0,$('#begin_header').offset().top);
        $('#submitButton').hide();
        $('#end-alert').hide();
    }else{
        window.scrollTo(0,$('#prev1').offset().top);
        $('#submitButton').hide();
        $('#end-alert').hide();
    }
    $('#next1').attr('disabled', null);
    $('#next2').attr('disabled', null);




    event.preventDefault();
    event.stopPropagation();
});


$('#next2').click(function(event) {
    $('.current').removeClass('current').hide()
        .next().show().addClass('current');

    $('#next1').show();
    $('#prev1').show();
    $('#instructions_panel').hide();


    if ($('.current').hasClass('last')) {



        $('#next1').attr('disabled', true);
        $('#next2').attr('disabled', true);
        window.scrollTo(0,$('#prev1').offset().top);
        $('#submitButton').show();
        $('#end-alert').show();
    }else{
        window.scrollTo(0,$('#prev1').offset().top);
        $('#submitButton').hide();
        $('#end-alert').hide();
    }
    $('#prev1').attr('disabled', null);
    $('#prev2').attr('disabled', null);




    event.preventDefault();
    event.stopPropagation();
});

$('#prev2').click(function(event) {
    $('.current').removeClass('current').hide()
        .prev().show().addClass('current');
        $('#next1').show();
        $('#prev1').show();
        $('#instructions_panel').hide();


    if ($('.current').hasClass('first')) {
    $('#instructions_panel').show();
    $('#next1').hide();
    $('#prev1').hide();
        $('#prev1').attr('disabled', true);
        $('#prev2').attr('disabled', true);
        window.scrollTo(0,$('#begin_header').offset().top);
        $('#submitButton').hide();
        $('#end-alert').hide();
    }else{
        window.scrollTo(0,$('#prev1').offset().top);
        $('#submitButton').hide();
        $('#end-alert').hide();
    }
    $('#next1').attr('disabled', null);
    $('#next2').attr('disabled', null);



    event.preventDefault();
    event.stopPropagation();
});




</script>
</head>
<body>

<p>
	<strong>Questionnaire:</strong> Below are some online information sources that members of your group have already bookmarked for your project.
	Click on the title of the source (in blue) to see it online.
	It will open in a new tab.
</p>
<p>
	After you review each source, please answer the questions shown below.
</p>
<div id="badinputhead" class="alert alert-danger" style="display:none" role="alert">Some of your inputs are blank or incorrect.  Please check your input and submit again.</div>
<form id="sum2015_qform" class="pure-form" method="post" action="searchsources.php">
<button id="prev1" disabled="disabled" class="btn btn-default" style="display:none"><< Prev</button>
<button id="next1" class="btn btn-default" style="display:none">Next >></button>
<div id="main">
<div id="div0" class="first current">
<h2 id="begin_header" style="display:none">Click 'Next' to begin the task.  Submit it after you've completed all inputs.</h2></div>




<?php
// Print task
?>
</div>

<hr />
<button id="prev2" disabled="disabled" class="btn btn-default" style="display:none"><< Prev</button>
<button id="next2" class="btn btn-default" style="display:none">Next >></button>
<div id="badinputfoot" style="display:none" class="alert alert-danger" role="alert">Some of your inputs are blank or incorrect.  Please check your input and submit again.</div>
<style type="text/css">fieldset { padding: 10px; background:#fbfbfb; border-radius:5px; margin-bottom:5px; }
</style>
</form>
</body>
</html>

<?php
	}
}
else {
	echo "Something went wrong. Please <a href=\"../index.php\">try again </a>.\n";
}

	?>

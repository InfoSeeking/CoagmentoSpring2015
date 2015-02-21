<?php
require_once('Connection.class.php');
class Questionnaires
{
	private static $instance;
	private static $db_selected;
	private $link;
	private $lastID;

	// Cache of questions

	public function __construct() {
		$this->link = mysql_connect($host, $username, $password) or die("Cannot connect to the database: ". mysql_error());
        $this->db_selected = mysql_select_db($database, $this->link) or die ('Cannot connect to the database: ' . mysql_error());

	}

	public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }




		public function populateQuestions(){

		}

		public function isQuestionnaireComplete($userID,$projectID,$questionnaire_name){

		}


		public function addQuestion(){

		}

		public function addQuestionAt($index){

		}


		public function clearCache(){

		}

		public function popQuestion(){

		}

		public function removeQuestionAt($index){

		}

		public function printQuestions(){

		}

		public function printForm(){

		}

		public function



		// OLD FUNCTIONS

	public function commit($query)
	{
		try{
			$results = mysql_query($query) or die(" ". mysql_error());
			$this->lastID = mysql_insert_id();
			return $results;
		}
		catch(Exception $e){
			//echo $e->getMessage();
			//exit();
		}
	}

	public function esc($str){
		return mysql_real_escape_string($str);
	}

	public function getLastID()
	{
		return $this->lastID;
	}

	public function __wakeup()
	{
		$this->connect();
	}

	public function close()
	{
		mysql_close($link);
	}

	/*public function __sleep()
	{
		return array('host', 'username', 'password', 'db');
	}*/

 }
?>

<?php 

//database connection


class DatabaseConnection
{
	//connection and authentication (Access Modifiers)
	private $host = 'localhost'; // this will change depending on the hostname
	private $user = 'root'; //this will change to username of the host
	private $password = 'blade2005'; //this will change depeding on the password
	private $dbname = 'reviews'; //database name will change

	//database handler

	private $dbh;
	private $error;
	private $stmt;

	//setting the database connection each time a class is instantiated
	public function __construct ()
	{
		//Set DSN / connection string
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

		//set options

		$options = array (


			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		//create new PDO
		//this will then be a try catch exeption error handler

		try {

				$this->dbh = new PDO($dsn, $this->user, $this->password, $options);
		} catch(PDOException $e){
			$this->error = $e->getMessage();
		}
	}


	//query statement

	public function query($query)
	{
		$this->stmt = $this->dbh->prepare($query);
	}

	//the bind function

	public function bind($param, $value, $type= null)
	{
		if(is_null($type)){
			switch(true){

				case is_int($value):
				$type = PDO::PARAM_INT;
				break;

				case is_bool($value):
				$type = PDO::PARAM_BOOL;
				break;

				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;

				default:
				$type = PDO::PARAM_STR;

			}
		}

			$this->stmt->bindValue($param, $value, $type);
	}

	public function execute()
	{
		return $this->stmt->execute();
	}

	public function lastInsertId()
	{
		$this->dbh->lastInsertId();
	}

	public function resultsSet()
	{
		$this->execute();
		//This is then to fetch everything in an array with FETCH::ASSOC
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

}
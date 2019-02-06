<?php


	class DB{

		// Hold the class instance.
  		private static $_instance = null;

  		// The constructor is private
		// to prevent initiation with outer code.
		private function __construct($dsn, $username, $password)
		{
			try{

		    	self::$_instance = new PDO($dsn, $username, $password);
		    	self::$_instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING); 
			}
			catch(PDOException $e){
				echo $e->getMessage();
				 
				die();
			}
		}

		// The object is created from within the class itself
  		// only if the class has no instance.
  		public static function getInstance($db, $username, $password)
  		{
		    if (!self::$_instance)
		    {
		      new DB($db, $username, $password);
		    }
		 
		    return self::$_instance;
		}
		
	}
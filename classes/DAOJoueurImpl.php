<?php

	class DAOJoueurImpl implements DAOJoueur{

		private $_pdo; 

	   	public function __construct($pdo){
	        $this->_pdo=$pdo;
	   	}

	   	function getJoueur($nom){
	   		$joueur=null;
	   		try{

	    		$stmt =  $this->_pdo->prepare("SELECT * FROM joueurs WHERE nom=:nom");
	    		$stmt->bindValue(':nom', $nom);
	    		
				$stmt->execute();
				$row = $stmt->fetch();
				if(is_array($row))
					$joueur=new Joueurs($row);
	    	}
	    	catch(Exception $e){
	    		echo $e->getMessage();
	    		$joueur=null;
	    	}
	    	return $joueur;
	   	}

	   	function addJoueur($joueur){
	   		if(!is_null($joueur)){
	    		try{
	    			$this->_pdo->beginTransaction();
		    		$stmt =  $this->_pdo->prepare("INSERT INTO joueurs (nom) VALUES (:nom)");
		    		$stmt->bindValue(':nom', $joueur->getNom());
		    		$stmt->execute();
			    	$this->_pdo->commit();
	    		}
	    		catch(PDOException $e){
	    			$this->_pdo->rollback();
		    		echo $e->getMessage();
		    		return false;
	    		}
	    		return true;
	    	}
	   	}

	   	function getAllJoueurs(){
	   		$joueurs = [];
	    	try{
	    		$stmt = $this->_pdo->query('SELECT * FROM joueurs');
			    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			    {
			      $joueurs[] = new Joueurs($row);
			    }
	    	}
	    	catch(Exception $e){
	    		echo $e->getMessage();
	    		$joueurs = null;
	    	}
    		return $joueurs;
	   	}
	}
<?php

	class DAOScoreImpl implements DAOScore{

		private $_pdo; 

	   	public function __construct($pdo){
	        $this->_pdo=$pdo;
	   	}

		function getScore($id_joueur){
			$score=null;
	   		try{

	    		$stmt =  $this->_pdo->prepare("SELECT * FROM scores WHERE id_joueur=:id_joueur");
	    		$stmt->bindValue(':id_joueur', $id_joueur);
	    		
				$stmt->execute();
				$row = $stmt->fetch();
				if(is_array($row))
					$score=new Scores($row);
	    	}
	    	catch(Exception $e){
	    		echo $e->getMessage();
	    		$score=null;
	    	}
	    	return $score;
		}

		function addScore($score){
			if(!is_null($score)){
	    		try{
	    			$this->_pdo->beginTransaction();
		    		$stmt =  $this->_pdo->prepare("INSERT INTO scores (id_joueur) VALUES (:id_joueur)");
		    		$stmt->bindValue(':id_joueur', $score->getId_joueur());
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

		function updateScore($id_joueur){
			if(!is_null($id_joueur)){
				try {
					$this->_pdo->beginTransaction();
		    		$stmt =  $this->_pdo->prepare("UPDATE scores SET score=score+1 WHERE id_joueur=:id_joueur");
		    		$stmt->bindParam(":id_joueur", $id_joueur);
		    		if($stmt->execute()){
			    		$this->_pdo->commit();
			    		return true;
		    		}
				} catch (PDOException $e) {
					$this->_pdo->rollback();
		    		echo $e->getMessage();
		    		return false;
				}
				return false;
			}
		}

		function getAllScores(){
			$scores = [];
	    	try{
	    		$stmt = $this->_pdo->query('SELECT * FROM scores ORDER BY score DESC');
			    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			    {
			      $scores[] = new Scores($row);
			    }
	    	}
	    	catch(Exception $e){
	    		echo $e->getMessage();
	    		$scores = null;
	    	}
    		return $scores;
		}

	}

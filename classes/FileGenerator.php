<?php

   class FileGenerator{


	private $_pdo; 

   	public function __construct($pdo){
        $this->_pdo=$pdo;
   	}

    public function genererBase($dbName, $chemin){

    	$show='show tables';

    	$resultat=$this->_pdo->query($show);
        
    	while($table=$resultat->fetch()){

    		$this->generer($table['Tables_in_'.$dbName], $chemin);
    		
    	}	
    }

	public function getColumns($table){
		
      $donnees=array();
      $chaine='';
      $select='select * from '.$table;
      if($this->_pdo->query($select) === false){
			echo "erreur"; die();
      }
      else if($this->_pdo->query($select) !== false){
			$statement=$this->_pdo->query($select);
			for($i=0;$i<$statement->ColumnCount();$i++){
            	$donnees[]= $statement->getColumnMeta($i)['name'] ;
            }
      }
      return $donnees;
    }


   	public function generer($table, $chemin){

   				$attributs=$this->getColumns($table);

   				if(count($attributs)!=0){
					  $open=fopen($chemin.''.ucfirst($table).'.php','w+');
	                  fwrite($open,'<?php 
	                class '.ucfirst($table).'{

	                  		');

	                  foreach ($attributs as $value) {
	                     fwrite($open,'private $_'.$value.';
	                     	');
	                  }


	                  fwrite($open,'

		                  	public function __construct(array $donnees){

		                    	$this->inisialiser($donnees);

		                    }');

	                  foreach ($attributs as $value) {
	                     fwrite($open,'

		                    public function get'.ucfirst($value).'(){

		                      return $this->_'.$value.';

		                    }');
	                  }

	                  foreach ($attributs as $value) {
	                     fwrite($open,'

		                    public function set'.ucfirst($value).'($'.$value.'){

		                      $this->_'.$value.'=$'.$value.';

		                    }');
	                  }


	                  fwrite($open,

	                  	'

		                  	public function inisialiser(array $donnees){

		                        foreach ($donnees as $cle => $valeur) {

		                           $fonction=\'set\'.ucfirst($cle);

		                           if(method_exists($this,$fonction)){

		                              $this->$fonction($valeur);

		                           }

		                        }

		                    }'

	                  );
	                  fwrite($open,'
	                }');
   				}
                  

    }


   }

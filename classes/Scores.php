<?php 
	                class Scores{

	                  		private $_id;
	                     	private $_score;
	                     	private $_id_joueur;
	                     	

		                  	public function __construct(array $donnees){

		                    	$this->inisialiser($donnees);

		                    }

		                    public function getId(){

		                      return $this->_id;

		                    }

		                    public function getScore(){

		                      return $this->_score;

		                    }

		                    public function getId_joueur(){

		                      return $this->_id_joueur;

		                    }

		                    public function setId($id){

		                      $this->_id=$id;

		                    }

		                    public function setScore($score){

		                      $this->_score=$score;

		                    }

		                    public function setId_joueur($id_joueur){

		                      $this->_id_joueur=$id_joueur;

		                    }

		                  	public function inisialiser(array $donnees){

		                        foreach ($donnees as $cle => $valeur) {

		                           $fonction='set'.ucfirst($cle);

		                           if(method_exists($this,$fonction)){

		                              $this->$fonction($valeur);

		                           }

		                        }

		                    }
	                }
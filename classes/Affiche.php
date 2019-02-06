<?php

	class Affiche{

		private $_init;

		public function __construct($init){
			$this->_init=$init;
		}

		public function affiche_ligne($line){

			$board=$this->_init->getBoard();
			$larg=$this->_init->getLarg();
			echo "<tr>\n";
				for ($i=0; $i<$larg; $i++) {
				    $c = $board[$i][$line];
				    echo '<center><td><img src="../public/images/';
				    echo (($c == 0) ? "vide.png" : (($c == 1) ? "joueur1.png" : "joueur2.png"));
				    echo '" alt="';
				    echo (($c == 0) ? "0" : (($c == 1) ? "j1" : "j2"));
				    echo '" /></td></center>'; 
				}
			echo "\n</tr>\n";
		}

	}
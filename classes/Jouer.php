<?php

	class Jouer{


		private $_init;

		public function __construct($init){
			$this->_init=$init;
		}


		public function jouer($col, $joueur){
			$board=$this->_init->getBoard();
			$haut=$this->_init->getHaut();
			$i=0;
			$done = false;
			while ($i<$haut) {
			    if ($board[$col][$i] == 0) {
					$board[$col][$i] = $joueur;
					$done=true;
					break;
			    } else {
					$i++;
			    }
			}
			$this->_init->setBoard($board);
			return $done;
		}

	}
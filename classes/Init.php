<?php


	class Init{

		private $_board;
		private $_larg;
		private $_haut;

		public function __construct($haut, $larg){
			$this->setHaut($haut);
			$this->setLarg($larg);
		}

		public function init(){
			for ($i=0; $i<$this->_larg; $i++) {
			    for ($j=0; $j<$this->_haut; $j++) {
					$this->_board[$i][$j]=0;
			    }
			}
		}

		public function setBoard($board){
        	$this->_board=$board;
        }

		public function getBoard(){
        	return $this->_board;
        }

		public function setLarg($larg){
        	$this->_larg=$larg;
        }

        public function getLarg(){
        	return $this->_larg;
        }

        public function setHaut($haut){
        	$this->_haut=$haut;
        }

        public function getHaut(){
        	return $this->_haut;
        }

	}
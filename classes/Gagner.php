<?php

	class Gagner{


		private $_init;

		public function __construct($init){
			$this->_init=$init;
		}

		function nb_align($posx, $posy, $dx, $dy, $turn) {
			$board=$this->_init->getBoard();
			$haut=$this->_init->getHaut();
			$larg=$this->_init->getLarg();

			if ($posx<0 || $posx>=$larg || $posy<0 || $posy>=$haut) { 
			    return 0; 
			} 
			else if ($board[$posx][$posy] == $turn)	{
			    return 1 + ($this->nb_align($posx+$dx, $posy+$dy, $dx, $dy, $turn)); 
			} 
			else{
				return 0;
			}
	    }

	    function total_line($posx, $posy, $dx, $dy, $turn) {
			return 1 + $this->nb_align($posx+$dx, $posy+$dy, $dx, $dy, $turn) + $this->nb_align($posx-$dx, $posy-$dy, -$dx, -$dy, $turn);
	    }

		public function est_gagnant($col, $turn){
			$board=$this->_init->getBoard();
			$haut=$this->_init->getHaut();
			$larg=$this->_init->getLarg();
			$posx = $col - 1;
			// On doit maintenant retrouver la hauteur du dernier pion
			$i = $haut - 1;
			while ($i>=0) {
			    if (!($board[$posx][$i] == 0)) {
					break;
			    } else {
					$i--;
			    }
			}
			$posy = $i;
			return(($this->total_line($posx, $posy, 0, 1, $turn) >= 4) 
			    || ($this->total_line($posx, $posy, 1, 0, $turn) >= 4) 
			    || ($this->total_line($posx, $posy, 1, 1, $turn) >= 4) 
			    || ($this->total_line($posx, $posy, -1, 1, $turn) >= 4));
		}

	}
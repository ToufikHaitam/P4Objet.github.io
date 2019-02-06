<?php


	class Affichage{

		private $_init;

		public function __construct($init){
			$this->_init=$init;
		}

		public function affiche_choix(){
			$larg=$this->_init->getLarg();

			echo '<center><tr class="lastline" id="choix">'."\n";
				for ($i=0; $i<$larg; $i++) {
				    echo '<td><input type="submit" name="col" id="col" value="'.($i + 1).'" /></td>';
				}
			echo "\n</tr></center>\n";
		}

	}
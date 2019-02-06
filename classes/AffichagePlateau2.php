<?php

	class AffichagePlateau2{

		private $_init;
		private $_affiche;
		private $_affichage;

		public function __construct($init, $affiche, $affichage){
			$this->_init=$init;
			$this->_affiche=$affiche;
			$this->_affichage=$affichage;
		}

		public function affiche_plateau(){
			$haut=$this->_init->getHaut();
			echo '<center><form class="intable" name="jouer" method="POST" action="../controleurs/MainControleur.php">'."\n";
				echo '<table>'."\n";
					for ($i=($haut - 1); $i>=0; $i--){
						$this->_affiche->affiche_ligne($i);
					}
					$this->_affichage->affiche_choix();
					echo '<input type="hidden" name="action" value="Jouer" />';
				echo "</table>\n";
			echo "</form></center>\n";
		}
	}
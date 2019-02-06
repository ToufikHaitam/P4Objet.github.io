<?php

	interface DAOJoueur{

		function getJoueur($nom);
		function addJoueur($joueur);
		function getAllJoueurs();

	}
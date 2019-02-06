<?php

	interface DAOScore{

		function getScore($id_joueur);
		function addScore($score);
		function updateScore($id_joueur);
		function getAllScores();

	}
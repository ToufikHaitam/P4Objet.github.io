<?php

	session_start();
$win=0;

if(isset($_SESSION['win'])){
    $win=$_SESSION['win'];
	}



	/*
	* Chargement des classes
	*/
	require'../classes/Autoloader.php';
	Autoloader::register();

	
	define('DSN','mysql:host=remotemysql.com;dbname=ZUYu8a6dAH');
 	define('USER','ZUYu8a6dAH');
 	define('PASSWORD','SaDMu8KAZP');
	$instance=DB::getInstance(DSN, USER, PASSWORD);

	/*
	* L'interaction avec la base de donnees
	*/
	$daoJoueur=new DAOJoueurImpl($instance);
	$daoScore=new DAOScoreImpl($instance);

	if(isset($_POST) && count($_POST)>0){
		if(isset($_POST['action'])){
			$action=$_POST['action'];
			if($action==="Commencer"){
			$_SESSION['win']=0;
				if (isset($_POST['nomj1']) && $_POST['nomj1']!="" && isset($_POST['nomj2']) && $_POST['nomj2']!="") {
					$nomj1=$_POST['nomj1'];
					$nomj2=$_POST['nomj2'];

					if($nomj1!=$nomj2){
						$_SESSION['nomj1'] = $nomj1;
						$_SESSION['nomj2'] = $nomj2;
						setcookie("nomj1", $_POST['nomj1'], time()+12*24*3600); // expire dans 12 jours
						setcookie("nomj2", $_POST['nomj2'], time()+12*24*3600); 

						// Dans le cas ou la session a expire, on reprend aussi les noms dans les cookies
					    if (!isset($_SESSION['nomj1'])) {
							$_SESSION['nomj1'] = $_COOKIE['nomj1'];
							$_SESSION['nomj2'] = $_COOKIE['nomj2'];
					    }

					    /**
					    * L'ajout du joueur 1 s'il n'existe pas
					    */
					    if($daoJoueur->getJoueur($nomj1)==null){
					    	$j1["nom"]=$nomj1;
					    	$joueur1=new Joueurs($j1);
					    	$daoJoueur->addJoueur($joueur1);

					    	$joueur1=$daoJoueur->getJoueur($nomj1);
					    	if($daoScore->getScore($joueur1->getId())==null){
					    		$s1["id_joueur"]=$joueur1->getId();
					    		$score1=new Scores($s1);
					    		$daoScore->addScore($score1);
					    	}
					    }

					    /**
					    * L'ajout du joueur 1 s'il n'existe pas
					    */
					    if($daoJoueur->getJoueur($nomj2)==null){
					    	$j2["nom"]=$nomj2;
					    	$joueur2=new Joueurs($j2);
					    	$daoJoueur->addJoueur($joueur2);

					    	$joueur2=$daoJoueur->getJoueur($nomj2);
					    	if($daoScore->getScore($joueur2->getId())==null){
					    		$s1["id_joueur"]=$joueur2->getId();
					    		$score2=new Scores($s1);
					    		$daoScore->addScore($score2);
					    	}
					    }


					    $_SESSION['turn']=1;
					    $init=new Init(7, 7);
						$init->init();
						$affiche=new Affiche($init);
						$affichage=new Affichage($init);
						$affichagePlateau=new AffichagePlateau2($init, $affiche, $affichage);

						$_SESSION["affichagePlateau"]=serialize($affichagePlateau);
						$_SESSION["init"]=serialize($init);
					    header('location: ../views/p4.php');	
					}
					else{
						$message="Des nom diffrents";
						$_SESSION["message"]=$message;
						header('location: ../views/index.php');
					}
			    }
			    else{
			    	$message="Il faut remplire les champs";
					$_SESSION["message"]=$message;
			    	header('location: ../views/index.php');
			    }
			}
		    else if($action==="Jouer"){
		    	if(isset($_POST["col"])){
		    		$col=$_POST["col"];
		    		$turn=$_SESSION['turn'];
		    		$init=unserialize($_SESSION["init"]);
		    		$jouer=new Jouer($init);
		    		if($jouer->jouer($col-1, $turn)){
						$gagner=new Gagner($init);

						if($gagner->est_gagnant($col, $turn)){
							$j1 = $_SESSION['nomj1'];
    						$j2 = $_SESSION['nomj2'];

    						/*
    						* La modification du score
    						*/
    						if($turn==1){
    							$joueur1=$daoJoueur->getJoueur($j1);
    							$daoScore->updateScore($joueur1->getId());
    						}
    						else{
    							$joueur2=$daoJoueur->getJoueur($j2);
    							$daoScore->updateScore($joueur2->getId());
    						}
							$result=(($turn == 1) ? $j1 : $j2 )." a gagné !";
							$_SESSION['result']=$result;
							$_SESSION['turn']=1;
							$_SESSION['win']=1;
						}
						else{
							$_SESSION['turn']=($turn%2)+1;
						}

		    			$affiche=new Affiche($init);
						$affichage=new Affichage($init);
						$affichagePlateau=new AffichagePlateau2($init, $affiche, $affichage);

						$_SESSION["affichagePlateau"]=serialize($affichagePlateau);
						$_SESSION["init"]=serialize($init);
						
					    header('location: ../views/p4.php');
		    		}
		    		else{
		    			header('location: ../views/p4.php');
		    		}
		    	}
		    }
		    else if($action==="Recommencer"){
		    	$_SESSION['turn']=1;
		    	$_SESSION['win']=0;
			    $init=new Init(7, 7);
				$init->init();
				$affiche=new Affiche($init);
				$affichage=new Affichage($init);
				$affichagePlateau=new AffichagePlateau2($init, $affiche, $affichage);

				$_SESSION["affichagePlateau"]=serialize($affichagePlateau);
				$_SESSION["init"]=serialize($init);
			    header('location: ../views/p4.php');
		    }
		    else if($action==="listJoueurs"){
		    	$joueurs=$daoJoueur->getAllJoueurs();
		    	$scores=$daoScore->getAllScores();
		    	$_SESSION["list_joueurs"]=serialize($joueurs);
		    	$_SESSION["list_scores"]=serialize($scores);
		    	header('location: ../views/p4.php');
		    }
			else{
				header('location: ../views/index.php');
			}
		}
		else{
			header('location: ../views/index.php');
		}
	}
	else{
		header('location: ../views/index.php');
	}
   

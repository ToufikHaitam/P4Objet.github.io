<?php

	session_start();

$win=0;
$result="";
 	 require'../classes/Autoloader.php';
	require'../classes/AIMoves.php';
	Autoloader::register();
	if(isset($_SESSION['win'])){
    $win=$_SESSION['win'];
	}
   if(isset($_SESSION['result'])){
    $result=$_SESSION['result'];
	}

	
	define('DSN','mysql:host=remotemysql.com;dbname=ZUYu8a6dAH');
 	define('USER','ZUYu8a6dAH');
 	define('PASSWORD','SaDMu8KAZP');
	$instance=DB::getInstance(DSN, USER, PASSWORD);

	/*
	* L'interaction avec la base de donnees
	*/
	$daoJoueur=new DAOJoueurImpl($instance);
	$daoScore=new DAOScoreImpl($instance);
 

 
 

	if(!isset($_SESSION["nomj1"]) || !isset($_SESSION["nomj2"])){
		header('location: index.php');
	}

	/*
	* Chargement des classes
	*/
	 


$r=unserialize($_SESSION["init"]);
$GLOBALS['turn']=$_SESSION['turn'];
$GLOBALS['board']=$r->getboard();
$GLOBALS['HAUT']=$r->getHaut();
$GLOBALS['Larg']=$r->getLarg();


$var= new AIMoves();
$t=$_SESSION['turn'];

 if($t==2){
//print($var->AIPlay());
 	$daoJoueur=new DAOJoueurImpl($instance);
	$daoScore=new DAOScoreImpl($instance);
 
$jouer=new Jouer($r);
if($jouer->jouer($var->AIPlay(), $t)){
$gagner=new Gagner($r);

                           if($gagner->est_gagnant($var->AIPlay()+1, $turn)){
                           	$j1 = $_SESSION['nomj1'];
    						$j2 = $_SESSION['nomj2'];
    						/*$joueur2=$daoJoueur->getJoueur($j2);
					    	if($daoScore->getScore($joueur2->getId())==null){
					    		$s1["id_joueur"]=$joueur2->getId();
					    		$score2=new Scores($s1);
					    		$daoScore->addScore($score2);
					    	}
    						
    						$joueur2=$daoJoueur->getJoueur($j2);
    							$daoScore->updateScore($joueur2->getId());
    						*/

                            $result=(($turn == 1) ? $j1 : $j2 )." a gagné !";
							$_SESSION['result']=$result;
							$_SESSION['turn']=1;
							$_SESSION['final']="final";
							$_SESSION['result']=$result;
							$_SESSION['win']=1;
							$result=$_SESSION['result'];
							$win=$_SESSION['win'];

								}
						else{
							$_SESSION['turn']=1;
							 echo "   <center>Systeme a jouer c'est ton tour</center>";
						}

		    			$affiche=new Affiche($r);
						$affichage=new Affichage($r);
						$affichagePlateau=new AffichagePlateau($r, $affiche, $affichage);

						$_SESSION["affichagePlateau"]=serialize($affichagePlateau);
						$_SESSION["init"]=serialize($r);
						



}

}
	if(isset($_SESSION["affichagePlateau"])){
		$affichagePlateau=unserialize($_SESSION["affichagePlateau"]);
	}
	else{
		$affichagePlateau=null;
	}

	if(isset($_SESSION["result"])){
		$result=$_SESSION["result"];
		unset($_SESSION["result"]);
	}
	else{
		$result=null;
	}

	if(isset($_SESSION["turn"])){
		$turn=$_SESSION["turn"];
		$j1=$_SESSION["nomj1"];
		$j2=$_SESSION["nomj2"];
	}
	else{
		$turn=null;
	}

	if(isset($_SESSION["list_joueurs"])){
		$listJoueurs=unserialize($_SESSION["list_joueurs"]);
	}
	else{
		$listJoueurs=null;
	}

	if(isset($_SESSION["list_scores"])){
		$listScores=unserialize($_SESSION["list_scores"]);
	}
	else{
		$listScores=null;
	}
?>



<!DOCTYPE html 
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" type="text/css" href="../public/css/p4.css" title="Normal" />
		<link rel="stylesheet" type="text/css" href="/public/css/style.css" title="Normal" />

	<title>Puissance 4</title>
    </head>
    <body>
		<center><div>
 
		<?php
			 
				echo "<b>".$result."</b>";
			
			if(!is_null($affichagePlateau)){
				$affichagePlateau->affiche_plateau();
			}
			if(!is_null($turn)){
				echo "C'est à ".(($turn == 1)? $j1 : $j2).' (<img src="../public/images/'.(($turn == 1)? "joueur1.png" : "joueur2.png" ).'" alt="pionJoueur" height="15">) de jouer.'."\n";
			}
		?>

			<form action="../controleurs/contremachine.php" method="post">
				<input type="hidden" name="action" value="Recommencer" />
			    <input type="submit" name="clear" value="Recommencer" />
			</form>
			
			<form action="index2.php" method="post">
			    <input type="submit" value="Changer les noms" />
			</form> 

			<form action="../controleurs/contremachine.php" method="post">
				<input type="hidden" name="action" value="listJoueurs" />
			    <input type="submit" value=" La liste des Joueurs" />
			</form>

		</div>


		<script>
			 
if(<?php echo $win;?>=="1"){
  
  var x = document.getElementById("choix");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }}

</script>
					

		 
		<br>
		<div>
			
			<?php
				if(!is_null($listJoueurs) && !is_null($listScores)){
					echo '<table border="1" id="customers" >';
					echo "<tr><th>Nom</th><th>Score</th></tr>";
					foreach ($listJoueurs as $joueur) {
						foreach ($listScores as $score) {
							if($joueur->getId()== $score->getId_joueur()){
								echo "<tr><td>".$joueur->getNom()."</td><td>".$score->getScore()."</td></tr>";
							}
						}
					}
				}
			?>

		</div></center>

    </body>
</html>


<?php
$win=0;

	session_start();

	if(!isset($_SESSION["nomj1"]) || !isset($_SESSION["nomj2"])){
		header('location: index.php');
	}

	/*
	* Chargement des classes
	*/
	require'../classes/Autoloader.php';
	Autoloader::register();


	if(isset($_SESSION['win'])){
    $win=$_SESSION['win'];
	}
 if(isset($_SESSION['result'])){
    $result=$_SESSION['result'];
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
	<title>Puissance 4</title>
    </head>
    <body>
		<div>


		<?php
			if(!is_null($result)){
				echo "<b>".$result."</b>";
			}
			if(!is_null($affichagePlateau)){
				$affichagePlateau->affiche_plateau();
			}
			if(!is_null($turn)){
				echo "C'est à ".(($turn == 1)? $j1 : $j2).' (<img src="../public/images/'.(($turn == 1)? "joueur1.png" : "joueur2.png" ).'" alt="pionJoueur" height="15">) de jouer.'."\n";
			}
		?>

			<form action="../controleurs/MainControleur.php" method="post">
				<input type="hidden" name="action" value="Recommencer" />
			    <input type="submit" name="clear" value="Recommencer" />
			</form>
			
			<form action="index.php" method="post">
			    <input type="submit" value="Changer les noms" />
			</form> 

			<form action="../controleurs/MainControleur.php" method="post">
				<input type="hidden" name="action" value="listJoueurs" />
			    <input type="submit" value=" La liste des Joueurs" />
			</form>

		</div>
		<br>
		<script>
			 
if(<?php echo $win;?>=="1"){
  
  var x = document.getElementById("choix");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }}

</script>
			
		<div>
			
			<?php
				if(!is_null($listJoueurs) && !is_null($listScores)){
					echo "<table border='1' id='customers'>";
					echo "<tr><td>Nom</td><td>Score</td></tr>";
					foreach ($listJoueurs as $joueur) {
						foreach ($listScores as $score) {
							if($joueur->getId()== $score->getId_joueur()){
								echo "<tr><td>".$joueur->getNom()."</td><td>".$score->getScore()."</td></tr>";
							}
						}
					}
				}
			?>

		</div>

    </body>
</html>


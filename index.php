<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<link href="style.css" rel="stylesheet" type="text/css">
		<title>Puissance 4</title>
    </head>
     


    <style>
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
</style>
</head>
<body>
<br><br><br><br><br><br><br><br><br>
<center><h2>Jeu puissance 4 </h2>

<a href="views/index2.php"><button class="button" style="vertical-align:middle"><span>Contre machine </span></button></a><a href="views/index.php"><button class="button" style="vertical-align:middle"><span>contre ami(e) </span></button></a>

</center>
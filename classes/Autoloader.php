<?php

		class Autoloader{


				public static function autoloadClasses($classname)
				{
					//if(file_exists($classname.'.php'))
					require $classname.'.php';// comme include mais il stoppera le script dans le cas d'un erreur
				}

				public static function register(){

					spl_autoload_register(array(__CLASS__,'autoloadClasses'));// enregistre la fonction dans la pile d'autoload

				}
				
		}
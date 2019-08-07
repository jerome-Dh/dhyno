<?php

	/**
	 * Gestion de la ligne de commande 
	 *
	 * Il est possible pour l'utilisateur de générer les classes de controlleurs,
	 * des models, des vues et des tests automatiquement
	 *
	 * L'utilisation se fait en ligne de commande et nécessite qu'on lui passe des arguments
	 *
	 * Ex: > php make controller --name=User
	 * Cet exemple générera un controlleur nommé User dans le dossier app/Controllers
	 * automatiquement
	 *	
	 * @author Jerome Dh <jdieuhou@gmail.com>
	 *
	 */

	require __DIR__ . '/vendor/autoload.php';

	require __DIR__ . '/core/Helpers.php';

	$command = new \Core\Commands\CommandLineRunner();

	$command->run();

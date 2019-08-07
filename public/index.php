<?php

	/**
	 * Framework MVC By Jerome Dh <jdieuhou@gmail.com>
	 * 
	 * Ce Framework offre les services de gestion des réquêtes, les réponses
	 * les routes, les vues, les models et des multiples SGBD tels que SQLite, MySQL
	 *
	 * (c) 2019 Jerome Dh - Licence MIT
	 */
	////////////////////////////////////////////////////////////////////////////////

	/**
	 * Chargement des packages nécéssaires pour toute application
	 * Le chargement mets en évidence toutes les classes et les namespace du dossier
	 * "app" et "core"
	 */
	require __DIR__ . '/../vendor/autoload.php';


	/**
	 * Chargement des utilitaires, disponibles dans toute l'application
	 * Les utilitaires fournissent des fonctions pour faciliter certaines taches 
	 * répetitives de l'application comme obtenir l'url de base et les autres chemins
	 * tels que les vues et bien plus.
	 */
	require __DIR__ . '/../core/Helpers.php';


	///////////////////////////////////////////////////////////////////////////
	//
	//	Exécuter une instance de l'application, générer et renvoyer la réponse
	//
	///////////////////////////////////////////////////////////////////////////
	
	$app = new \Core\FrontendApplication();

	$app->run();


	//Message de bienvenue
	// echo 'Bienvenue dans le framework PHP MVC';
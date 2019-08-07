<?php
 
namespace App\Config;


//==============================================================================
//
//	Configuration des accès aux différentes bases de données
// 
// 	Contient les options de configurations ainsi que les comptes de connexions
//
//
//	@date 31/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


class Database 
{
	/**
	 * Nom du moteur MySQL
	 *
	 * @var string
	 */
	const MYSQL_CON = 'mysql';
	
	/**
	 * Nom du moteur SQLite
	 *
	 * @var string
	 */
	const SQLITE_CON = 'sqlite';
	
	/**
	 * Nom de la connexion à utiliser par défaut lors de l'appel static DB::method 
	 *
	 * La valeur peut être : mysql, sqlite
	 */
	const DEFAULT_DB = self::SQLITE_CON;

    /**
     * Le fichier portant la base de données SQLite
     */
    const PATH_TO_SQLITE_FILE = __dir__ . '/../../storages/db/sqlitedatabase.db';


	// ====================================================================
	//
	// Connexion à MySQL
	// Ces valeurs correspondent aux données de connexion à la BD MySQL
	//
	// ====================================================================
	const MYSQL_DB = [

		'host' => 'localhost',

		'port' => 3306,

		'user' => 'root',

		'password' => '',

		'dbname' => 'tests',

	];
 
}
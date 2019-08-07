<?php

namespace Core\DB;

//==============================================================================
//
//	Manager les differentes SGBD
// 
// 	Selectionner la base de données par défaut et implémenter les opérations 
//	communes telles que la sélection, la mise à jour, etc..
//
//
//	@date 31/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use App\Config\Database;

use Core\DB\{ PDOMySQLConnection, SQLiteConnection };

class DBManager
{
	/**
	 * Instance de connexion à la BD
	 *
	 * @var \PDO
	 */
	protected $pdo;
	
	/**
	 * Constructeur
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Choix de la BD et instantiation
	 */
	public function init()
	{
		try
		{
			$typeDB = Database::DEFAULT_DB;

			switch($typeDB)
			{
				case Database::MYSQL_CON :

					$this->pdo = PDOMySQLConnection::connect();

					break;

				case Database::SQLITE_CON :

					$this->pdo = SQLiteConnection::connect();

					break;

				default :

					throw new \Exception('Choix du SGBD incorrecte !');

			}

		}
		catch(\Exception $e)
		{
			$this->exceptionDb($e);
		}
	}

	/**
	 * Gérer les érreurs survenues lors de la connexion à la BD
	 */
	public function exceptionDb(\Exception $e)
	{
		exit('Impossible de se connecter à la BD: '.$e->getMessage());
	}

	/** 
	 * Obtenir l'instance de connexion PDO
	 *
	 * @return \PDO
	 */
	public function getPDO()
	{
		return $this->pdo;
	}


}

	
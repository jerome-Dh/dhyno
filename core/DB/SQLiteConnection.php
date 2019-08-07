<?php

namespace Core\DB;

//==============================================================================
//
//	SQLite connexion
// 
// 	Gérer la connexion à la base de données SQLite
//
//
//	@date 26/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


use App\Config\Database;


class SQLiteConnection 
{
    /**
     * PDO instance
     * @var type 
     */
    private static $pdo = null;
 
    /**
     * Obtenir l'objet de connexion à la base de données SQLite
	 *
     * @return \PDO
	 *
	 * @throws \PDOException
     */
    public static function connect()
	{

		if (self::$pdo == null) 
		{
			self::$pdo = new \PDO("sqlite:" . Database::PATH_TO_SQLITE_FILE);
		}

        return self::$pdo;

    }
}
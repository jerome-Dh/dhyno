<?php

namespace Core\DB;

//==============================================================================
//
//	PDO MySQL Connexion
// 
// 	Gérer la connexion à la base de données MySQL avec PDO
//
//
//	@date 31/07/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


use App\Config\Database;


class PDOMySQLConnection 
{
    /**
     * PDO instance
     * @var type 
     */
    private static $pdo = null;

    /**
     * Obtenir l'objet de connexion à la base de données MySQL
	 *
     * @return \PDO
	 *
	 * @throws \PDOException
     */
    public static function connect()
	{
		
		if (self::$pdo == null)
		{
			$host = Database::MYSQL_DB['host'];
			$user = Database::MYSQL_DB['user'];
			$password = Database::MYSQL_DB['password'];
			$dbname = Database::MYSQL_DB['dbname'];

			self::$pdo = new \PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password, array(
				\PDO::ATTR_PERSISTENT => true
			));

			self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}

        return self::$pdo;

    }

}
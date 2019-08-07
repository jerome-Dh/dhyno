<?php


namespace Core;


//==============================================================================
//
//	Gestion des logs
// 
//	Génère les fichiers de logs pour chaque exécution
//
//
//	@date 05/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


final class Log
{

	/**
	 * Ecrire une info dans le fichier de log 
	 * 
	 * @param $data 
	 */
	public static final function info($data)
	{
		$filename = \log_dir().self::generateUniqueFilename();
		
		$data = 'Log::info > '.print_r($data, true);

		self::writeFile($filename, $data);

	}

	/**
	 * Ecrire dans le fichier
	 * 
	 * @param $name
	 * @param $data
	 *
	 * @return int
	 */
	private static final function writeFile($filename, $data)
	{
		$newLine = "\n";
		file_put_contents($filename, $data, FILE_APPEND);
		file_put_contents($filename, $newLine, FILE_APPEND);
	}

	/**
	 * Générer un nom de fichier unique
	 *
	 * @return  string
	 */
	private static final function generateUniqueFilename()
	{
		$date = new \Datetime('now', new \DateTimeZone('Africa/Douala'));

		return $date->format('Y-m-d H').'-log';
	}
}

	
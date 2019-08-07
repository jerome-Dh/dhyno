<?php


namespace Core\Commands;


//==============================================================================
//
//	Gestion des fichiers
// 
//	Créer des fichiers en ligne de commande
//
//
//	@date 04/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\Commands\Colors;

abstract class BaseMake
{
	/** 
	 * Nom du repertoire
	 * 
	 * @var string
	 */
	protected $dirname;

	/**
	 * Nom du fichier
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Constructeur
	 *
	 */
	public function __construct()
	{

	}

	/** 
	 * Lancer les opérations
	 */
	public function make()
	{
		return $this->writeInFile();
	}

	/** 
	 * Ecrire dans le fichier
	 *
	 * @throws \Exception
	 */
	public function writeInFile()
	{
		$name = ucfirst($this->name);

		$content = $this->getContent(ucfirst(basename($name)));

		$file = $this->dirname.$name.'.php';

		if( ! file_exists(dirname($file)))
		{
			throw new \Exception(' Chemin de fichier incorrecte !');
		}

		return file_put_contents($file, $content);

	}

	public abstract function getContent($name);

	/** 
	 * Modifier le nom du repertoire
	 *
	 * @param $dirname
	 *
	 * @throws \Exception
	 */
	public function setDirname($dirname)
	{
		if( ! is_string($dirname) or ! file_exists($dirname))
		{
			throw new \Exception('Nom de répertoire invalide !');
		}

		$this->dirname = $dirname;

		return $this;

	}

	/** 
	 * Modifier le nom du fichier
	 *
	 * @param $name
	 *
	 * @throws \Exception
	 */
	public function setName($name)
	{
		if( ! is_string($name))
		{
			throw new \Exception('Nom de fichier invalide !');
		}

		//Vérifier que le fichier n'existe pas
		$fullname = $this->dirname.ucfirst($name).'.php';

		if(file_exists($fullname))
		{
			fwrite(STDOUT, "\n Le fichier " . Colors::make($fullname, 'purple') . " existe déjà\n\n voulez-vous l'écraser ? y/n : ");

			$line = trim(fgets(STDIN));
			
			if($line == 'n')
			{
				throw new \Exception(' Opération abandonnée !');
			}

		}

		$this->name = $name;

		return $this;

	}

	/** 
	 * Rétourner le nom du repertoire
	 *
	 * @return string
	 */
	public function getDirname()
	{
		return $this->dirname;
	}

	/**
	 * Rétourner le nom du fichier
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

}
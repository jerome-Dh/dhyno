<?php

namespace Core;


//==============================================================================
//
// 	Gestion des vues
// 
// 	Elle réprésente l'instance d'une vue
//
//
//	@date 05/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


use Core\{ ApplicationComponent, Application };

class View
{
	/**
	 * Le nom du fichier de la vue
	 * 
	 * @var string
	 */
	protected $filename;
	
	/**
	 * Les données de la vue
	 * 
	 * @var array
	 */
	protected $data;

	/**
	 * Constructor
	 */
	public function __construct($filename = '', array $data = [])
	{
		$this->setView($filename);

		$this->setData($data);
	}

	// =============== Getters et Setters ======================

	public function setView($filename)
	{
		$ext = '.php';

		if( ! strchr($filename, $ext))
		{
			$filename .= $ext;
		}
		
		$fullname = view_dir().$filename;

		if( ! file_exists($fullname))
		{
			throw new \InvalidArgumentException('Vue <'.$filename.'> introuvable dans <<'.view_dir().'>> ! Merde');
		}

		$this->filename = $fullname;

	}

	public function getView()
	{
		return $this->filename;
	}

	public function setData($data)
	{
		$this->data = $data;	
	}

	public function getData()
	{
		return $this->data;
	}
	
	/**
	 * Rétourner le contenu de la vue
	 *
	 * @return string
	 */
	public function getContent() : string
	{
		extract($this->data);

		// Buffériser les sorties
		\ob_start();

		require $this->filename;

		$content = \ob_get_clean();

		return $content;

	}
	

}
<?php


namespace Core\Commands;


//==============================================================================
//
//	Classe de gestion des couleurs de la ligne de commande
//
//
//	@date 04/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


final class Colors
{

	/**
	 * Les couleurs d'avant plan
	 *
	 * @var array
	 */
	private static $fg = [

		'black' => '0;30',
		'dark_gray' => '1;30',
		'blue' => '0;34',
		'light_blue' => '1;34',
		'green' => '0;32',
		'light_green' => '1;32',
		'cyan' => '0;36',
		'light_cyan' => '1;36',
		'red' => '0;31',
		'light_red' => '1;31',
		'purple' => '0;35',
		'light_purple' => '1;35',
		'brown' => '0;33',
		'yellow' => '1;33',
		'light_gray' => '0;37',
		'white' => '1;37',

	];
	private static $bg = [

		'black' => '40',
		'red' => '41',
		'green' => '42',
		'yellow' => '43',
		'blue' => '44',
		'magenta' => '45',
		'cyan' => '46',
		'light_gray' => '47',

	];

	/**
	 * Colorer un texte
	 *
	 * @param $chaine La chaine à colorer
	 * @param $fg
	 * @param $bg
	 *
	 * @return string
	 */
	public static final function make($chaine, $fg = null, $bg = null) : string
	{
		$chaine_colorer = "";

		//La couleur d'avant plan
		if (isset(self::$fg[$fg])) 
		{
			$chaine_colorer .= "\033[" . self::$fg[$fg] . "m";
		}
		// La couleur d'arrière plan
		if (isset(self::$bg[$bg])) 
		{
			$chaine_colorer .= "\033[" . self::$bg[$bg] . "m";
		}

		// Ajouter la couleur
		$chaine_colorer .=  $chaine . "\033[0m";

		return $chaine_colorer;
	}

	/**
	 * Obtenir le tableau de couleurs d'avant plan
	 *
	 * @return array
	 */
	public static final function getForegroundColors() : array
	{
		return array_keys(self::$fg);
	}

	/**
	 * Obtenir le tableau de couleurs d'arrière plan
	 *
	 * @return array
	 */
	public static final function getBackgroundColors() : array
	{
		return array_keys(self::$bg);
	}

}
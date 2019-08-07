<?php


namespace Core\Exceptions;


//==============================================================================
//
//	Gestion des exceptions des routes
// 
// 	Concernant la gestion des routes de l'application, une exception est lévée 
//	chaque fois qu'une route est introuvable ou le fichier de routes est mal formaté
//
//
//	@date 30/07/2019 
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================


class RoutesException extends \Exception
{
	public function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	// chaîne personnalisée représentant l'objet
	public function __toString() 
	{
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

}

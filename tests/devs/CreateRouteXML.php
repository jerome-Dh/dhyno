<?php

namespace Tests;


//==============================================================================
//
//	Trait de création du fichier de routes.xml pour les tests
//
//	@date 05-08-2019 11:27 
//
//	@author Jerome Dh
//
//=============================================================================


Trait CreateRouteXML
{

	public static function createXML($filename)
	{

		\file_put_contents($filename, self::getContent());

	}

	private static function getContent()
	{

		$texte = '<?xml version="1.0" encoding="utf-8" ?>
<routes>
	<web>
		<get url="show" action="Home@show"/>
		<get url="/" action="acceuil"/>
		<get url="/" action="acceuil"/>
		<post url="test" action="acceuil"/>
		<post url="/" action="acceuil"/>
	</web>
	<api>
		<get url="test" action="FooController@doSometing"/>
		<get url="/" action="FooController@doSometing"/>
	</api>
</routes>';

		return $texte;

	}

}


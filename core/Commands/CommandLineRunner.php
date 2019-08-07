<?php


namespace Core\Commands;


//==============================================================================
//
//	Gestion de la ligne de commande
// 
//	Ces options permettent d'interagir avec l'application
//	L'utilisateur pourra créer des controlleurs, des models et des tests
//
//
//	@date 04/08/2019
//
//	@author Jerome Dh <jdieuhou@gmail.com>
//
//=============================================================================

use Core\Commands\{ MakeController, MakeModel, MakeTest, Colors };

class CommandLineRunner
{
	
	/**
	 * Liste des commandes
	 *
	 * @var array
	 */
	protected $commands;

	/**
	 * Nombre d'argument
	 *
	 * @var int
	 */
	protected $argumentsCount;

	/**
	 * Constructor
	 */
	public function __construct()
	{

	}

	/**
	 * Exécuter la commande
	 *
	 * @see isArgumentPassed, getListArgs, showHelp
	 */
	public function run()
	{
		if( ! $this->isArgumentPassed())
		{
			$this->show($this->getListHelp());

			exit(0);

		}

		$this->argumentsCount = $this->getArgumentCount();

		$this->commands = $this->getListArgs();


		//Analyse des arguments
		if($this->isHelpCommand())
		{
			$this->show($this->showHelp());
			exit(0);
		}
		
		if($this->isControllerCommand())
		{
			if($this->argumentsCount >=  3 and $this->commands[2] == '--help')

				$this->show($this->showHelpController());

			else
				$this->show($this->makeController());
			
			exit(0);
		}

		if($this->isModelCommand())
		{
			if($this->argumentsCount >=  3 and $this->commands[2] == '--help')

				$this->show($this->showHelpModel());

			else

				$this->show($this->makeModel());

			exit(0);
		}

		if($this->isTestCommand())
		{
			if($this->argumentsCount >=  3 and $this->commands[2] == '--help')

				$this->show($this->showHelpTest());

			else

				$this->show($this->makeTest());
	
			exit(0);
		}

		$this->show($this->showInvalidCommand());
		
	}

	/** 
	 * Obtenir la liste des arguments
	 * 
	 * @return array
	 */
	protected function getListArgs() : array
	{
		$ret = [];

		if($this->isArgumentPassed())
		{
			$ret = $_SERVER['argv'];
		}

		return $ret;

	}
	
	/**
	 * Retourne le nombre d'arguments passé
	 *
	 * @return int
	 */
	protected function getArgumentCount() : int
	{
		return $_SERVER['argc'];
	}

	/**
	 * Tester si au moins une commande a été passée 
	 *
	 * @return bool
	 */
	protected function isArgumentPassed() : bool
	{
		return $this->getArgumentCount() > 1;
	}

	/**
	 * Tester s'il s'agit de la commande d'aide
	 *
	 * @return bool
	 */
	protected function isHelpCommand() : bool
	{
		return $this->commands[1] == 'help' 
			or $this->commands[1] == '--help'
			or $this->commands[1] == '/?';
	}

	/**
	 * Tester s'il s'agit de la commande pour controlleur
	 *
	 * @return bool
	 */
	protected function isControllerCommand()
	{
		return strtolower($this->commands[1]) == 'controller';
	}

	/**
	 * Tester s'il s'agit de la commande pour model
	 *
	 * @return bool
	 */
	protected function isModelCommand()
	{
		return strtolower($this->commands[1]) == 'model';
	}

	/**
	 * Tester s'il s'agit de la commande pour test
	 *
	 * @return bool
	 */
	protected function isTestCommand()
	{
		return strtolower($this->commands[1]) == 'test';
	}

	/**
	 * Afficher l'aide
	 *
	 * @return string
	 *
	 * @see listCommandes
	 */
	protected function showHelp()
	{
		if(count($this->commands) < 3)
		{
			$texte = $this->listCommandes();
		}
		else
		{
			$comm = strtolower(trim($this->commands[2]));

			switch($comm)
			{
				case 'controller' :

					$texte = $this->showHelpController();

					break;

				case 'model' : 
					
					$texte = $this->showHelpModel();
					
					break;
				
				case 'test' : 
					
					$texte = $this->showHelpTest();
					
					break;
					
				default :

					$texte = $this->showInvalidCommand();
			}
		}

		return $texte;
	}

	/**
	 * Obtenir la liste d'aide
	 *
	 * @return string
	 */
	protected function getListHelp()
	{
		$texte = Colors::make("\n\t Bienvenu dans make, outil d'aide à la construction de votre projet\n", 'cyan');

		$texte .= Colors::make("\n\t Author : Jerome Dh\n", 'cyan');

		$texte .= $this->listCommandes();

		return $texte;

	}

	/**
	 * Retourner la liste des commandes
	 *
	 * @return string
	 */
	protected function listCommandes()
	{

		$texte = Colors::make("\n\t Liste des commandes", 'brown');
		$texte .= "\n\t -----------------------\n\n";

		$texte .= "\t controller 	: Crée une classe de controlleur\n"; 
		$texte .= "\t model		: Crée une classe de model\n";
		$texte .= "\t test		: Crée une classe de test\n";
		$texte .= $this->getPlusHelp();

		return $texte;

	}
	
	/**
	 * Affiche plus d'aide
	 *
	 * @return string
	 */
	protected function getPlusHelp()
	{
		$texte = "\n\t --help		: Affiche cette fenêtre d'aide\n";
		$texte .= "\n\t Pour plus d'aide, taper la commande \"php make help nomDeCommande\"\n";
		
		return $texte;
	}
		

	/**
	 * Afficher l'aide des controlleurs
	 *
	 * @return string
	 */
	public function showHelpController()
	{
		$texte = Colors::make("\n\t controller - Crée une classe de controlleur\n\n", 'brown'); 
		$texte .= "\t Liste des options";
		$texte .= "\n\t -----------------------\n\n";
		$texte .= "\t --name=<nom>	: Nom du controlleur\n";
		$texte .= $this->getPlusHelp();

		return $texte;

	}

	/**
	 * Afficher l'aide des models
	 *
	 * @return string
	 */
	public function showHelpModel()
	{
		$texte = Colors::make("\n\t model - Crée une classe de model\n\n", 'brown'); 
		$texte .= "\t Liste des options";
		$texte .= "\n\t -----------------------\n\n";
		$texte .= "\t --name=<nom>	: Nom du model\n";
		$texte .= $this->getPlusHelp();

		return $texte;

	}

	/**
	 * Afficher l'aide des tests
	 *
	 * @return string
	 */
	public function showHelpTest()
	{
		$texte = Colors::make("\n\t test - Crée une classe de test unitaire\n\n", 'brown'); 
		$texte .= "\t Liste des options";
		$texte .= "\n\t -----------------------\n\n";
		$texte .= "\t --name=<nom>	: Nom de la classe de test\n";
		$texte .= $this->getPlusHelp();

		return $texte;

	}

	/**
	 * Afficher le message pour toute commande invalide
	 *
	 * @return string
	 */
	protected function showInvalidCommand()
	{
		$texte = Colors::make("\n Commande invalide, taper \"php make help\" pour plus d'aide\n", 'red');

		return $texte;

	}

	/**
	 * Afficher en console
	 *
	 * @param $texte 
	 */
	protected function show($texte)
	{
		echo "\n".$texte."\n";
	}

	/**
	 * Créer le controlleur 
	 *
	 * @return string
	 */
	protected function makeController()
	{

		try
		{
			$name = $this->getNameOption();

			$createController = new MakeController();

			$createController->setDirname(controller_dir())->setName($name);

			if($createController->make())
			{
				$texte = Colors::make(' Controlleur crée avec succès', 'green');
			}
			else
			{
				$texte = Colors::make(' Impossible de créer le controlleur', 'red');
			}
		}
		catch(\Exception $e)
		{
			$texte = Colors::make($e->getMessage(), 'red');
		}

		return $texte;

	}

	/**
	 * Créer le model 
	 *
	 * @return string
	 */
	protected function makeModel()
	{
		try
		{
			$name = $this->getNameOption();

			$createModel = new MakeModel();

			$createModel->setDirname(model_dir())->setName($name);

			if($createModel->make())
			{
				$texte = Colors::make(' Model crée avec succès', 'green');
			}
			else
			{
				$texte = Colors::make(' Impossible de créer le Model', 'red');
			}
		}
		catch(\Exception $e)
		{
			$texte = Colors::make($e->getMessage(), 'red');
		}

		return $texte;

	}

	/**
	 * Créer le test 
	 *
	 * @return string
	 */
	protected function makeTest()
	{
		try
		{
			$name = $this->getNameOption();

			$createTest = new MakeTest();

			$createTest->setDirname(test_dir())->setName($name);

			if($createTest->make())
			{
				$texte = Colors::make(' Test crée avec succès', 'green');
			}
			else
			{
				$texte = Colors::make(' Impossible de créer le Test', 'red');
			}
		}
		catch(\Exception $e)
		{
			$texte = Colors::make($e->getMessage(), 'red');
		}

		return $texte;

	}
	
	/**
	 * Retourner le name du fichier à créer
	 *
	 * @return string
	 *
	 * @throw \Exception
	 */
	protected function getNameOption()
	{

		if($this->argumentsCount < 3)
		{
			throw new \Exception(' Argument introuvable');
		}

		$tab = explode('=', $this->commands[2]);

		if((count($tab) < 2) or (trim($tab[0]) != '--name')  or empty(trim($tab[1])))
		{
			throw new \Exception(' Argument incorrect');
		}

		$name = $tab[1];

		return $name;

	}
	


}
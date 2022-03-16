<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
	
           $router = new RouteList();
                 
           $admin = new RouteList('Admin');
           $admin->addRoute('[<locale=cs cs|en>/]admin/<presenter>/<action>[/<id>]', 'People:people');
           $router[] = $admin;
           
           $api = new RouteList('Api');
           $api->addRoute('api/<presenter>/<action>[/<id>]', 'Api:default');
           $api->addRoute('[<locale=cs cs|en>/]api/<presenter>/<action>[/<id>]', 'Api:default');
           $router[] = $api;
           
           /*$front = new RouteList('Front');
           $front->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
           $router[] = $front;*/
           
           $front = new RouteList('Front');
           $front->addRoute('<presenter>/<action>[/<id>]', 'Starts:default');
           $front->addRoute('[<locale=cs cs|en>/]<presenter>/<action>[/<id>]', 'Starts:default');
           $router[] = $front;
           
           
           
           return $router;
	}
}

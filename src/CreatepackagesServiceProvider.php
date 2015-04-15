<?php namespace	Jai\Createpackages;

/**
 *
 * @author kora jai <kora.jayaram@gmail>
 */

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class CreatepackagesServiceProvider extends ServiceProvider{


	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{

		//$this->loadViewsFrom(realpath(__DIR__.'/../views'), 'contact');
		//$this->setupRoutes($this->app->router);


		// this  for conig
//		$this->publishes([
//				__DIR__.'/config/contact.php' => config_path('contact.php'),
//		]);

	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function setupRoutes(Router $router)
	{
		$router->group(['namespace' => 'Jai\Contact\Http\Controllers'], function($router)

		{
			require __DIR__.'/Http/routes.php';
		});
	}


	public function register()
	{
//		$this->app->bind('Createpackages',function($app){
//        			return new Createpackages($app);
//        		});

		$this->registerCreatepackages();
	}

	protected $commands = [
			'Jai\Createpackages\Commands\PackageCreatorCommand'
	];

	private function registerCreatepackages()
	{
//		$this->app->singleton('command.jai.Createpackage', function ($app) {
//			return $app['jai\Createpackages\Commands\PackageCreatorCommand'];
//		});
		$this->commands($this->commands);
	}


}
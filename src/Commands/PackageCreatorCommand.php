<?php namespace Jai\Createpackages\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Composer;

class PackageCreatorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'create-package';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * The filesystem instance.
	 *
	 * @var Filesystem
	 */
	protected $files;
	/**
	 * @var Composer
	 */
	protected $composer;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Filesystem $files, Composer $composer)
	{
		parent::__construct();

		$this->files =	$files;
		$this->composer = $composer;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
			$vendorName = $this->argument('vendorName');
			$packageName = $this->argument('packageName');
		   $this->makePackage($vendorName,$packageName);


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['vendorName', InputArgument::REQUIRED, 'vendor name.'],
			['packageName', InputArgument::REQUIRED, 'packaeg  name.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

	private function makepackage($vendorName, $packageName)
	{
		// check if vendor name exits
		if (!$this->makeDirectory($path = $this->getPath($vendorName,'dir'))) {
			 $this->comment( ' vendor already exists!'); // returns  kills it
		}
		$path = $path.ucfirst($packageName);


//		// check if packagenaem exits
		if (!$this->makeDirectory($path)) {
			return $this->error( 'package already exists! cannot create a pakage'.ucfirst($packageName)); // returns  kills it
		}
		$path = $path.'/src';
		if (!$this->makeDirectory($path)) {
			return $this->error( 'package already exists! cannot create a pakage'.$packageName); // returns  kills it
		}

		$path= $path.'/'.ucfirst($packageName).'ServiceProvider.php';

		//at this stage  only new serice providers will be creates
		if ($this->files->exists($path)) {
			return $this->error(' already exists!');
		}

		$this->files->put($path, $this->addtext(array('name'=>"sdfasdas")));

		$this->info('Service Provider created successfully.');
		$this->composer->dumpAutoloads();

	}

	/**
	 * Construct the syntax to drop a column.
	 *
	 * @param  string $field
	 * @return string
	 */
	private function addtext($field)
	{
		$stub = $this->files->get(__DIR__ . '/../stubs/serviceprovider.stub');
		$this->replaceClassName($stub)
				->replaceVendorName($stub)
				//->replaceTableName($stub)
				;
		return $stub;
		//return sprintf("\$table->dropColumn('%s');", $field['name']);
	}

	/**
	 * Replace the class name in the stub.
	 *
	 * @param  string $stub
	 * @return $this
	 */
	protected function replaceClassName(&$stub)
	{
		$className = ucwords(camel_case($this->argument('packageName')));
		$stub = str_replace('{{packageName}}', $className, $stub);
		return $this;
	}

	/**
	 * Replace the class name in the stub.
	 *
	 * @param  string $stub
	 * @return $this
	 */
	protected function replaceVendorName(&$stub)
	{
		$className = ucwords(camel_case($this->argument('vendorName')));
		$stub = str_replace('{{vendorName}}', $className, $stub);
		return $this;
	}


	/**
	 * Build the directory for the class if necessary.
	 *
	 * @param  string $path
	 * @return string
	 */
	protected function makeDirectory($path)
	{
		if (!$this->files->isDirectory($path)) {
			return $this->files->makeDirectory($path, 0777, true, true);
		}else{
			return false;
		}
	}


	/**
	 * Get the path to where we should store the migration.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function getPath($name,$type='file')
	{
		if($type=='file'){
			return './packages/'. $name . '.php';
		}else{
			return './packages/'. $name.'/';
		}

	}



}

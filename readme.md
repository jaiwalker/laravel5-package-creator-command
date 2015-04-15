# Laravel 5 Package Creator Template

Notes : at this stage very messy need  to clean up 

L5 includes an artisan command to create a laravel specific package out of the box, so this package only needs to add a few things, like:

- `create-package vendorName PackageName `


*With one or two more to come.*

## Usage

### Step 1: Install Through Composer

```
composer require jai/createpackages --dev
```

### Step 2: Add the Service Provider

You'll only want to use these generators for local development, so you don't want to update the production  `providers` array in `config/app.php`. Instead, add the provider in `app/Providers/AppServiceProvider.php`, like so:

 Place ``` Jai\Createpackages\CreatepackagesServiceProvider``` in  config/app.php providers  array.

for Local 
```php
public function register()
{
	if ($this->app->environment() == 'local') {
		$this->app->register('Jai\Createpackages\CreatepackagesServiceProvider');
	}
}
```


### Step 3: Run Artisan!

You're all set. Run `php artisan` from the console, and you'll see the new command .

## Examples

- [create package With Service Provider](#CreatePackage-with-ServiceProvider)

### Create Package With Service Provider

```
php artisan create-package vendorName PackageName"
```

TODO : 

Extend this to load - routes 
Extend this to load - config 
Extend this to load - views 
Extend this to load - model 


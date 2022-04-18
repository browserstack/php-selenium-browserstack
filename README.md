# php-selenium-browserstack

## Prerequisites 
1. `php` and `composer` should be installed in your system
2. Go to the directory where you have your test scripts and run the command below:
```
  composer require php-webdriver/webdriver
```

## Steps to run test sessions
1. Install dependencies
```
  # If you don't already use Composer, you can download the composer.phar binary:
  curl -sS https://getcomposer.org/installer | php

  # Include the binding:
  php composer.phar require browserstack/local:dev-master

  # Install all the dependencies:
  php composer.phar install

  # Test the installation by running a simple test file, check out example.php in the main repository.
```
2. Configure test capabilities
(To run single test, navigate to ./scripts/single.php)

```php
$caps = array(
	'bstack:options' => array(
		"os" => "OS X",
		"osVersion" => "Sierra",
		"buildName" => "Final-Snippet-Test",
		"sessionName" => "Selenium-4 PHP snippet test",
		"local" => "false",
		"seleniumVersion" => "4.0.0",
	),
	"browserName" => "Chrome",
	"browserVersion" => "latest",
);

// Set you credentails
$BROWSERSTACK_USERNAME = "BROWSERSTACK_USERNAME";
$BROWSERSTACK_ACCESS_KEY = "BROWSERSTACK_ACCESS_KEY";
```

## To run tests
### Single test
Run single test session by running.
```
php single.php
```
### Local test
Run local test session by running.
```php
# Update "BROWSERSTACK_ACCESS_KEY" in bs_local.
$bs_local_args = array("key" => "ACCESS_KEY");
```
```
php local.php
```

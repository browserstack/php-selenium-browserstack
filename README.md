# php-selenium-browserstack

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
    "browserName" => "iPhone",
    "device" => "iPhone 11",
    "realMobile" => "true",
    "os_version" => "14.0",
    "name" => "BStack-[Php] Sample Test", // test name
    "build" => "BStack Build Number 1" // CI/CD job or build name
);
// IMP: Use your browserstack username and accesskey
$web_driver = RemoteWebDriver::create("https://USERNAME:ACCESS_KEY@hub-cloud.browserstack.com/wd/hub", $caps);
```

## To run tests
---
### Single test
```
php single.php
```

### Local test 
```
php local.php
```
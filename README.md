# php-selenium-browserstack
Code samples for php selenium tests on browserstack.

## Prerequisites 
1. `php` and `composer` should be installed in your system.
* If you don't already use Composer, you can download the composer.phar binary:
```
curl -sS https://getcomposer.org/installer | php
```

## Steps to run test sessions
1. Clone the repo
```
git clone https://github.com/browserstack/php-selenium-browserstack.git
```
2. Install dependencies
```
  php composer.phar install
```
3. Set your credentials in the `config.php` file. Update `YOUR_USERNAME` and `YOUR_ACCESS_KEY` with your username and access key.
You can also set them as environment variables `BROWSERSTACK_USERNAME` and `BROWSERSTACK_ACCESS_KEY`, as follows:
  * For Unix-like or Mac machines:
  ```
  export BROWSERSTACK_USERNAME=<browserstack-username> &&
  export BROWSERSTACK_ACCESS_KEY=<browserstack-access-key>
  ```

  * For Windows:
  ```
  set BROWSERSTACK_USERNAME=<browserstack-username>
  set BROWSERSTACK_ACCESS_KEY=<browserstack-access-key>
  ```

## To run tests
### Single test
Run single test session by running.
```
php scripts/single.php
```
### Parallel test
Run parallel test session by running.
```
php scripts/parallel.php
```
### Local test
Run local test session by running.
```
php scripts/local.php
```

<?php
    require_once("vendor/autoload.php");
    require_once('config.php');
    use Facebook\WebDriver\Remote\RemoteWebDriver;
    use Facebook\WebDriver\WebDriverBy;
    use Facebook\WebDriver\WebDriverExpectedCondition;
    use BrowserStack\Local;

    $caps = array(
        'bstack:options' => array(
            "os" => "OS X",
            "osVersion" => "Big Sur",
            "buildName" => "browserstack-build-1",
            "sessionName" => "BStack [php] Local test",
            "local" => "true",
            "seleniumVersion" => "4.0.0",
        ),
        "browserName" => "Chrome",
        "browserVersion" => "latest",
    );

    # read credentials from environment variables
    $USERNAME = getenv('BROWSERSTACK_USERNAME');
    $ACCESS_KEY = getenv('BROWSERSTACK_ACCESS_KEY');

    # if not provided in env vars, read credentials from config file
    if (!isset($USERNAME)) {
        $USERNAME = constant('BROWSERSTACK_USERNAME');
    }
    if (!isset($ACCESS_KEY)) {
        $ACCESS_KEY = constant('BROWSERSTACK_ACCESS_KEY');
    }

    # Creates an instance of Local
    $bs_local = new Local();
    $bs_local_args = array("key" => $ACCESS_KEY);
    # Starts the Local instance with the required arguments
    $bs_local->start($bs_local_args);

    # Check if BrowserStack local instance is running
    echo $bs_local->isRunning();

    $web_driver = RemoteWebDriver::create("https://$USERNAME:$ACCESS_KEY@hub.browserstack.com/wd/hub", $caps);
    try{
        $web_driver->get("http://bs-local.com:45691/check");
        $body_text = $web_driver->wait(10000)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector("body")))->getText();
        # Setting the status of test as 'passed' or 'failed' based on the condition; if title of the web page starts with 'BrowserStack'
        if ($body_text == "Up and running"){
            $web_driver->executeScript('browserstack_executor: {"action": "setSessionStatus", "arguments": {"status":"passed", "reason": "Local test ran successfully"}}' );
        }  else {
            $web_driver->executeScript('browserstack_executor: {"action": "setSessionStatus", "arguments": {"status":"failed", "reason": "Failed to load local test"}}');
        }
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
    $web_driver->quit();
    # Stop the Local instance
    $bs_local->stop();
?>

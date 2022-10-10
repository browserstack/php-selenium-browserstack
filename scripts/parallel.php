<?php
    require_once('vendor/autoload.php');
    require_once('config.php');
    use Facebook\WebDriver\Remote\RemoteWebDriver;
    use Facebook\WebDriver\WebDriverBy;
    use Facebook\WebDriver\WebDriverExpectedCondition;

    # read credentials from environment variables
    $USERNAME = getenv('BROWSERSTACK_USERNAME');
    $ACCESS_KEY = getenv('BROWSERSTACK_ACCESS_KEY');

    # if not provided in env vars, read credentials from config file
    if (!isset($USERNAME)) {
        $USERNAME = constant('BROWSERSTACK_USERNAME');
    }
    if (!isset($USERNAME)) {
        $ACCESS_KEY = constant('BROWSERSTACK_ACCESS_KEY');
    }

    function executeTestCase($caps) {
        global $USERNAME, $ACCESS_KEY;

        $web_driver = RemoteWebDriver::create(
            "https://$USERNAME:$ACCESS_KEY@hub.browserstack.com/wd/hub",
            $caps
        );
        try{
            $web_driver->get('https://bstackdemo.com/');
            $web_driver->wait(10000)->until(WebDriverExpectedCondition::titleIs('StackDemo'));
            # getting text of the product
            $product_on_page = $web_driver->wait(10000)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::XPath("//*[@id='1']/p")))->getText();
            # clicking the 'Add to cart' button
            $web_driver->wait(10000)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::XPath("//*[@id='1']/div[4]")))->click();
            # checking whether the cart pane is present on webpage
            $web_driver->wait(10000)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::className("float-cart__content")));
            # getting text of the product
            $product_in_cart = $web_driver->wait(10000)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::XPath("//*[@id='__next']/div/div/div[2]/div[2]/div[2]/div/div[3]/p[1]")))->getText();
            # Setting the status of test as 'passed' or 'failed' based on the condition; if title of the web page starts with 'BrowserStack'
            if ($product_on_page == $product_in_cart){
                $web_driver->executeScript('browserstack_executor: {"action": "setSessionStatus", "arguments": {"status":"passed", "reason": "Product has been successfully added to the cart!"}}' );
            }  else {
                $web_driver->executeScript('browserstack_executor: {"action": "setSessionStatus", "arguments": {"status":"failed", "reason": "Failed to add product to the cart or some elements might have failed to load."}}');
            }
        }
        catch(Exception $e){
            echo 'Message: ' .$e->getMessage();
        }
        $web_driver->quit();
    }
    $caps = array(
        array(
            'bstack:options' => array(
                "os" => "OS X",
                "osVersion" => "Big Sur",
                "buildName" => "browserstack-build-1",
                "sessionName" => "BStack [php] Parallel 1",
                "seleniumVersion" => "4.0.0",
            ),
            "browserName" => "Chrome",
            "browserVersion" => "latest",
        ),
        array(
            'bstack:options' => array(
                "os" => "Windows",
                "osVersion" => "10",
                "buildName" => "browserstack-build-1",
                "sessionName" => "BStack [php] Parallel 2",
                "seleniumVersion" => "4.0.0",
            ),
            "browserName" => "Firefox",
            "browserVersion" => "latest",
        ),
        array(
            'bstack:options' => array(
                "osVersion" => "10.0",
                "deviceName" => "Samsung Galaxy S20",
                "buildName" => "browserstack-build-1",
                "sessionName" => "BStack [php] Parallel 3",
                "seleniumVersion" => "4.0.0",
            ),
            "browserName" => "Chrome",
            "browserVersion" => "latest",
        ),
    );
    foreach ( $caps as $cap ) {
        executeTestCase($cap);
    }
?>
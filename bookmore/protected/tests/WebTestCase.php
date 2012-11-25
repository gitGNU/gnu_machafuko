<?php

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
define('TEST_BASE_URL','http://workspace/machafuko/bookmore/index-test.php/');

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase
{
	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->setBrowserUrl(TEST_BASE_URL);
		//$this->setSleep(2);
	}
	
	/**
	 * Is a general function, that can be use by a lot of classes.
	 */
	protected function login($user, $password)
	{
		// Login.
		$this->open('');
		$this->clickAndWait('link=Login');
		$this->assertElementPresent('name=LoginForm[username]');
		$this->type('name=LoginForm[username]',$user);
		$this->type('name=LoginForm[password]',$password);
		$this->clickAndWait("//input[@value='Login']");
	}
}

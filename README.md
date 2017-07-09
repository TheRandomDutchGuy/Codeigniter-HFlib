# HackForums Codeiginter library

A easy to use codeiginter library for the official Hackforums API

### Usage example (controllers)
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index(){
	    //This will give all user information (Omniscient)
        $user = $this->hackforums->user('1');
        $username = $user->result->username;
	}
?>
```

### Installation
**Copy all files to the matching directory in your CI project, Edit /application/config/hackforums.php to match your settings. Add the config and lib to your autoloader and now you can use the lib, Example above.**

*More details docs will come later*
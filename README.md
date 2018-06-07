# Air Framework
Light mvc framework providing simple routing system, twig templates and yml support.

Requirement
-----------
* Php 7.0
* composer

Install
---------
* Clone this repository
* Run `composer install` and `composer update`
* Decide wich Namespace you want to use Depending on you tree. We'll used `AppNamespace` for this Readme
* Decide where to store your views and your config, respectively views and config for this Readme
* Create your AppNamespace directory and create following files: index.php and .htaccess (replacing `AppNamespace`, `views` if needed) 
```
# .htaccess
#
# Air Framework
# Copyright (C) 2018 Abderrahman Daif and Lionel Tordjman
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <https://www.gnu.org/licenses/>. *

# enable Rewite module
RewriteEngine On

# Remove unwanted directories
RewriteRule ^vendor/(.*)?$ / [R=301,L]
RewriteRule ^AppNamespace/(.*)?$ / [R=301,L]

# Serve file if exists
RewriteCond %{REQUEST_FILENAME} -f
RewriteRule .? - [L]
# Rewrite other requests to index.php
RewriteRule .? %{ENV:BASE}/index.php [L]
```
```
# index.php

<?php
/**
 * Air Framework
 * Copyright (C) 2018 Abderrahman Daif and Lionel Tordjman
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>. *
 */
 
$loader = require __DIR__ . '/vendor/autoload.php';
/* Add Your(s) working directories to permit classes autoload */
$loader->addPsr4('AppNamespace\\', __DIR__ . '/AppNamespace');

use Air\Bootstrap\Bootstrap;

session_start();
$_SESSION['locale'] = 'en';

/*
    Instantiate the bootstrap (Router) with your own namespace depending on your file structure
    i.e. namespace App stands for App folder on base dir
*/
$viewsPath = $_SERVER['DOCUMENT_ROOT'].'/views';
try {
    $bootstrap = Bootstrap::getInstance('AppNamespace', $viewsPath);
} catch (Exception $e) {
    echo $e->getMessage();
}
```
* Create your first Controller file (by default IndexController.php) Into Your AppNamespace/Controller directory extending BaseController
* above default IndexController.php
```
# AppNamespace/Controller/IndexController.php

<?php

namespace AppNamespace\Controller;

use Air\Controller\BaseController;

class IndexController extends BaseController
{
	/**
	 * By default called on base url "/" without parameters
     * To add parameters to this route url must be /index/index/param1/param2/...
	 */
	public function indexAction()
	{
		$this->render( 'index.html.twig', array('hello' => 'world'));
	}

	/**
	 * Route with params
     * Without router file (routes.yml) called like this :
     * http(s)://base_url/index/param/{hello}/{world}
     * Can be called like this too cause it's IndexController
     * http(s)://base_url/param/{hello}/{world}
     *
	 * @param string $hello
	 * @param string $world
	 */
	public function paramAction($hello = '', $world = '')
	{
		$this->render( 'index.html.twig', array('hello' => $hello, 'world' => $world));
	}

}
```
* create index.html.twig into your view directory
SysDream 2
=========

PHP micro-framework with REST architecture support


Documentation
=======

The whole thing starts by a "controller". It is basically a class that handles the client's actions.

The controllers are located in the "app/controllers" folder.

The file naming convention is simple: "[name]_controller.php". The file name should be lower case.

If your controller needs to manage a ressource, the name should be plural. Example: users_controller.php. Otherwise, you can name it singular.

The name of the class should start with an upper case letter, which is also used to separte words: UsersController.



Your controller class must extend the framework's Controller class, located in "system/controller.php".

The controller base class has some abstract methods in it. You must obviously implement them in your class.


Here is a sample controller, that could manage articles.

```
<?php

require_once SYSTEM.'controller.php';

class ArticlesController extends Controller {

	public function __construct() {

	}

	/**
	 * Return a listing of the articles
	 * GET /articles
	 * 
	 * @return Response
	 */
	public function index($request) {

	}


	/**
	 * Return an article's details
	 * GET /articles/:id
	 * 
	 * @return Response
	 */
	public function get($id, $request) {

	}


	/**
	 * Create a new article
	 * POST /articles
	 * 
	 * @return Response
	 */
	public function create($request) {

	}


	/**
	 * Update the specified article
	 * PUT /articles/:id
	 * 
	 * @return Response
	 */
	public function update($id, $request) {

	}


	/**
	 * Destroy the specified article
	 * DELETE /articles/:id
	 * 
	 * @return Response
	 */
	public function destroy($id, $request) {

	}

```

As you can see, there are multiple methods used by a controller.


Index: this methods is called when a GET request comes to the server which has the URL "/articles".

Get: called when a GET request comes to the server with this URL "/articles/:id". The ":id" get passed to the method as the $id parameter.

Create: this is fired when a POST request arrives with a URL like "/articles".

Update: The function is called when a PUT request is handled with the following URI: "/articles/:id". The ":id" is passed to the method.

Destroy: This one is called when a DELETE request comes with a URL like so: "/articles/:id".


As they name suggests, each methods can be used to list, get, create, update or destroy the concerned ressource, here an article.


If your controller is not supposed to manage a ressource, for example a home page, you do not need some of these methods.
You can disable the useless functions by calling the denyAction() from the base class (Controller) in the constructor.

For instance, let's say you do not want to activate the destroy() action:

```
...
require_once SYSTEM.'actions.php';
...

class HomeController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
	}

	...

}

...
```

This way, if a client tries to send a GET request to "/home/:something", it will get a "403 - Forbidden" error response.


The last thing you need to do in order to make your controller working is to link the URL, here "/articles/" to the controller.
To do that, edit the "app/config/routes.json" file, and add a line like that:

```
{
	...
	"articles": "articles",
}
```

The first part is the URI, and the second is your controller's name.
You can make another URL point to the same controller by adding a new line like so:*

```
{
	...
	"articles": "articles",
	"posts": "articles",
}
```

This way, when a user will access "/articles" or "/posts" with his browser (thus with a GET request), the "articles" controller will be loaded 
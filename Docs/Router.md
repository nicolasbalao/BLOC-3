# Router Class

The `Router` class is responsible for handling the routing of the app.

## Usage

Instantiate the `Router` class and declare routes using the following methods:

- `get($url, $handler)`: Declare a GET route.
- `post($url, $handler)`: Declare a POST route.
- `put($url, $handler)`: Declare a PUT route.
- `delete($url, $handler)`: Declare a DELETE route.

The `$url` parameter represents the URL path, and the `$handler` parameter is an array containing the controller class and method to execute on the route.

## Methods

### `addRoute($url, $handler, $method = "GET")`

Adds routes to the app.

- `$url` (string): The URL path.
- `$handler` (array): The function to execute on the route.
- `$method` (string, optional): The HTTP method. Default is "GET".

### `handleRequest()`

Handles the request by mapping it through the routes and executing the corresponding controller method.

This method performs the following steps:

1. Gets the request URI from `$_SERVER["REQUEST_URI"]`.
2. Iterates through the defined routes.
3. Builds a regular expression pattern for each route's URL using the `buildPattern` method.
4. Checks if the route matches the request URI and has the same request method.
5. If a match is found, extracts any arguments from the URL using the `preg_match` function.
6. Removes the full text matched and the text that matched the first captured group from the `$matches` array.
7. If the handler is an array, creates an instance of the controller class and executes the specified method, passing the extracted arguments.
8. If the handler is not an array, outputs "here" (you can customize this behavior).
9. If no route matches, calls the `handle404` method.

### `handle404()`

Handles a 404 (Not Found) error by setting the appropriate header and displaying a 404 view.

### `buildPattern($path)`

Builds the regular expression pattern based on the URL path.

- `$path` (string): The URL path.

This method performs the following transformations on the `$path`:

1. Escapes forward slashes using `preg_replace` to allow them to be treated as literal characters in the regular expression.
2. Converts `{arg}` placeholders to named capturing groups using `preg_replace`. Each placeholder becomes `(?P<arg>[^\\/]+)`.
3. Prepends `^` to match the start of the URL path and appends `$` to match the end of the URL path.
4. Returns the built pattern.

---

The `Router` class is used to define routes and handle the routing logic in an application. It allows you to map URLs to specific controller methods based on the HTTP method. You can use this class as a foundation for building your application's routing system.

Feel free to modify and extend this class to fit your specific requirements.

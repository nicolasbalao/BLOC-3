# Db Class

Handle the connection with the database using the singleton design pattern.
## Singleton

The singleton design pattern is chosen for the database connection handler in this use case for the following reasons:

1- `Single point of access`: The singleton pattern ensures that there is only one global access point to the database connection. This simplifies the usage of the connection throughout the application, as you don't need to pass around connection objects or manage multiple instances.

2- `Resource optimization`: By having a single instance of the database connection, you can avoid creating multiple connections unnecessarily, optimizing resource usage and reducing overhead.

3- `Consistent state`: With a singleton, any changes or settings applied to the database connection will be preserved across all usage points, ensuring consistency in configurations or attributes.


While the singleton pattern offers these benefits, it's important to consider its drawbacks, such as increased dependencies and potential challenges in unit testing. Evaluating the specific requirements and constraints of the application is crucial before deciding to use the singleton pattern.

## Usage

To use the `Db` class, you can obtain an instance of the connection by calling the `getInstance()` method:

```php
$db_connection = Db::getInstance();
```

## Methods

`getInstance()`

Handle the connection to the database and ensure that only one instance of the connection is created.

Return Value
- Db: The instance of the database connection.
Example
```php
Copy code
$db_connection = Db::getInstance();
```

## Class Details

### Namespace

- App\Db

### Extends
- PDO

### Constants
The `Db` class requires the following constants defined in the `db_config.php` file:

- `DB_HOST`: The hostname of the database server.
- `DB_NAME`: The name of the database.
- `DB_USER`: The username for the database connection.
- `DB_PASS`: The password for the database connection.

### Constructor
The constructor initializes the database connection using the PDO class.

Parameters
The constructor does not accept any parameters.

### Attributes
The `Db` class sets the following attributes for the PDO instance:

- `PDO::MYSQL_ATTR_INIT_COMMAND`: Sets the initial SQL command to run when connecting to the database, used to set the character encoding to UTF-8.
- `PDO::ATTR_DEFAULT_FETCH_MODE`: Sets the default fetch mode for result sets to associative arrays.
- `PDO::ATTR_ERRMODE`: Sets the error reporting mode to throw exceptions.

### Exceptions
The constructor catches any PDOException and terminates the script execution, displaying the error message.

```php
Copy code
catch(PDOException $e){
    die($e->getMessage());
}
```
*Documentation generate by chatGPT*
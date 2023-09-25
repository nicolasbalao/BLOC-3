# Model Class

The `Model` class is a base model for repository that contains all CRUD (Create, Read, Update, Delete) operations and functions for hydrating data into the repository.

## Usage

The `Model` class can be extended to create specific models for different database tables. It provides methods for performing common database operations such as retrieving records, creating new records, updating existing records, and deleting records.


## Class Details

### Namespace

- `App\Db`

### Inherits

- `App\Db\Db`

### Properties

- `$table`: The name of the database table associated with the model.
- `$db`: The instance of the database connection.

### Methods

#### `request(string $sql, array $attributes = null): PDOStatement|false`

Handles the execution of a prepared SQL query or a simple query.

- Parameters:
  - `$sql`: The SQL query to execute.
  - `$attributes`: An array of values to prepare for the SQL query.
- Returns:
  - `PDOStatement|false`: The prepared statement or `false` on failure.

#### `findAll(): array`

Retrieves all records from the associated table.

- Query: `SELECT * FROM table`
- Returns:
  - `array`: An array of all records found.

#### `findBy(array $conditions): array`

Retrieves records from the associated table based on the specified conditions.

- Parameters:
  - `$conditions`: An array of conditions in the format `["field" => value]`.
- Query: `SELECT * FROM table WHERE conditions`
- Returns:
  - `array`: An array of records found.

#### `findById(int $id): array`

Retrieves a record from the associated table by the specified ID.

- Parameters:
  - `$id`: The ID of the record to retrieve.
- Query: `SELECT * FROM table WHERE id = $id`
- Returns:
  - `array`: An array containing the found record.

#### `create(Model $model): bool`

Creates a new record in the associated table.

- Parameters:
  - `$model`: The object to create, which is an instance of the `Model` class.
- Query: `INSERT INTO table (column ...) VALUES (value ...)`
- Returns:
  - `bool`: `true` on success, `false` on failure.

#### `update(int $id, Model $model): bool`

Updates an existing record in the associated table.

- Parameters:
  - `$id`: The ID of the record to update.
  - `$model`: The object or partial object containing the updated data.
- Query: `UPDATE table SET column = value ... WHERE id = $id`
- Returns:
  - `bool`: `true` on success, `false` on failure.

#### `delete(int $id): bool`

Deletes a record from the associated table by the specified ID.

- Parameters:
  - `$id`: The ID of the record to delete.
- Query: `DELETE FROM table WHERE id = $id`
- Returns:
  - `bool`: `true` on success, `false` on failure.

#### `hydrate(array $data): self`

Hydrates the object with data.

- Parameters:
  - `$data`: An array of data to be hydrated into the object.
- Returns:
  - `self`: The hydrated object.

---
*Documentation generate by chatGPT*

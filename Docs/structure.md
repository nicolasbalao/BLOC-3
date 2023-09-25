# Structure of the repository

We use `MVC` as design pattern with `POO`

## Folder structure

```
- app
    - src
        - user
            - controllers
                - UserController.php
                - ...
            - models
                - User.php
                - ...
            - views
                - index.php
                - create.php
                - edit.php
                - show.php
                - ...
        - product
            - controllers
                - ProductController.php
                - ...
            - models
                - Product.php
                - ...
            - views
                - index.php
                - create.php
                - edit.php
                - show.php
                - ...
    - config
        - db.config.php
    - helper
        -
    -...
  - helpers
    - DatabaseHelper.php
    - ValidationHelper.php
    - ...
  - config
    - database.php
    - routes.php
    - ...
- public
  - css
    - styles.css
  - js
    - scripts.js
  - index.php

```

_source: chat-gpt_

- app: Contains the application-specific code.

  - controllers: Contains the controller classes responsible for handling requests and responses.

  - models: Contains the model classes representing your data entities.
  - views: Contains the view files responsible for rendering HTML templates.
  - helpers: Contains helper classes or functions that provide reusable functionality.
  - config: Contains configuration files, such as database credentials or route definitions.

## MVC

In PHP, the Model-View-Controller (MVC) pattern is a popular architectural pattern used for developing web applications. In PHP MVC, each component plays a specific role:

1- Model: The Model represents the data and business logic of the application. In PHP, the Model typically consists of classes that interact with the database or other data sources. It encapsulates data manipulation, validation, and business rules. The Model retrieves data from the database, performs CRUD operations (create, read, update, delete), and provides an interface for the Controller to access and manipulate the data.

2- View: The View is responsible for presenting the data to the user. In PHP, the View usually comprises HTML templates mixed with PHP code for dynamic rendering. It focuses on the visual representation of the data and is responsible for generating the output that is sent to the user's browser. The View receives data from the Controller and incorporates it into the appropriate templates to produce the final HTML output.

3- Controller: The Controller acts as an intermediary between the Model and the View. In PHP, the Controller consists of classes that receive and handle user requests, perform necessary data processing, and coordinate the flow of data between the Model and the View. It receives user input, validates and sanitizes it, interacts with the Model to fetch or update data, and then passes the relevant data to the View for rendering.

4- PHP frameworks such as Laravel, Symfony, or CodeIgniter provide built-in support for MVC and help developers structure their PHP applications accordingly. These frameworks often provide base classes or components to facilitate the implementation of Models, Views, and Controllers and offer routing mechanisms to map URLs to specific Controllers and actions.

By adopting the PHP MVC pattern, developers can achieve better separation of concerns, code organization, maintainability, and testability in their PHP applications. It promotes modular development, code reusability, and scalability, making it easier to manage and extend PHP projects effectively.

_source: chat gpt_

## .htaccess

```
RewriteEngine On
RewriteBase /public

# Redirect all requests to index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

```

This code block is part of the .htaccess file and is responsible for routing all requests to the index.php file in your PHP application. Let's go through each line:

`RewriteCond %{REQUEST_FILENAME} !-f`: This line checks if the requested URL does not match an existing file on the server (!-f). It ensures that the rewrite rule is only applied if the requested URL does not correspond to an actual file.

`RewriteCond %{REQUEST_FILENAME} !-d`: This line checks if the requested URL does not match an existing directory on the server (!-d). It ensures that the rewrite rule is only applied if the requested URL does not correspond to an actual directory.

`RewriteRule ^(._)$ index.php?url=$1 [QSA,L]`: This line defines the actual rewrite rule. It captures the requested URL (excluding the base path specified in RewriteBase) using the regular expression ^(._)$ and assigns it to the query parameter url in the rewritten URL. [QSA,L] are flags modifying the behavior of the rewrite rule:

QSA (Query String Append): This flag appends the original query string to the rewritten URL. For example, if the original request was example.com/foo?param=value, the rewritten URL will be example.com/index.php?url=foo&param=value.
L (Last Rule): This flag indicates that if the current rule matches, no further rules should be processed.
In summary, these directives ensure that if the requested URL does not correspond to an existing file or directory, the request will be rewritten to index.php with the original URL captured as the url query parameter. This approach allows your PHP application to handle the routing and processing of the requested URL

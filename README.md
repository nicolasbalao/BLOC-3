# PHP MVC Framework Boilerplate

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Your PHP MVC (Model-View-Controller) Framework Boilerplate is designed to kickstart your web development projects with a clean, organized, and scalable structure.

## Features

- **MVC Architecture:** Organize your code into Models, Views, and Controllers for maintainability and separation of concerns.
- **Routing:** Implement flexible routing to map URLs to controller actions.
- **Template System:** Easily create and render views using a template engine of your choice.
- **Database Integration:** Configure and interact with your database using a PDO or your preferred database library.
- **Error Handling:** Handle errors gracefully with customizable error pages and logging.
- **Modular and Extensible:** Add new features and modules to your framework with ease.

## Getting Started

### Prerequisites

- Docker desktop ([install](https://docs.docker.com/get-docker/))

### Installation

1.  Clone this repository to your local machine:

    ```bash
    git clone https://github.com/nicolasbalao/PHP-MVC-boilerplate/blob/main/public/index.php
    ```

2.  Configure docker-compose.yml (replace all #EDIT)

    ```yaml
    version: "3"

    services:
    web:
      build:
      context: .
      dockerfile: Dockerfile
      ports:
        - 80:80
      volumes:
        - .:/var/www/html
        - ./vhost/site.conf:/etc/apache2/sites-available/000-default.conf
    db:
      image: mariadb:10.4
      container_name: your_db_container_name #EDIT
      environment:
      MYSQL_ROOT_PASSWORD: your_root_password #EDIT
      MYSQL_DATABASE: your_database_name #EDIT
      MYSQL_USER: your_mysql_user #EDIT
      MYSQL_PASSWORD: your_mysql_password #EDIT
      ports:
        - "3306:3306"
      volumes:
        - your_db_volume_name:/var/lib/mysql #EDIT
    phpmyadmin:
      image: phpmyadmin/phpmyadmin
      container_name: your_phpmyadmin_container_name #EDIT
      links:
        - db
      environment:
      PMA_HOST: your_db_container_name #EDIT
      PMA_PORT: 3306
      PMA_ARBITRARY: 1
      ports:
        - 8081:80

    volumes:
    your_db_volume_name: #EDIT
    ```

3.  Configure the vhost

    ```bash
        <VirtualHost *:80>
        ServerName your_domain_name #EDIT
        DocumentRoot /var/www/html/public

        <Directory /var/www/html/public>
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        </VirtualHost>
    ```

4.  Run the project

    ```bash
    docker compose up --build -d
    ```


## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE.md) file for details.

## Contact

Nicolas balao
Email: nicolasbalao.pro@gmail.com

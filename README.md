# Descripción

Proyecto elaborado en Php, con el  patrón MVC.

  - Php versión 7 o superior
  - gestor dase de datos mysql
  - Composer version 1.10.1 o superior


### Instalación

1- Clone el proyeto desde https://github.com/juliocesarjcrs/suplos_php.git

2- Ejecute o importe en su gestor de base de datos, el script de creación de la estructura ubicado en:

```sh
 bd\intelcost_bienes.sql
```

Remplace la configuración de las variables de su base de datos en:
```sh
 app\database.php
```
 por las que tenga su sistema
```sh
  'mysql' =>[
    'host' => 'localhost',
    'database' => 'intelcost_bienes',
    'user' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'password' => ''
  ]
```

```sh
$ git clone 'https://github.com/juliocesarjcrs/suplos_php.git'
$ cd suplos_php
$ composer install
$ php -S localhost:8080 -t public
```

En un navegador vaya  a la siguiente ruta 

http://localhost:8080/

Gracias



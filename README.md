# Lendico Account Management
- Summary:
  - Requirements
  - Installation
  - Examples

### Requirements
> Composer: [https://getcomposer.org/download/](https://getcomposer.org/download/)

> PHP 5.4+

### Installation
Change your database configuration in: [project-path]/app/config/parameters.yml
```yaml
parameters:
    database_host: 127.0.0.1
    database_port: 3306
    database_name: lendico_bank
    database_user: root
    database_password: 123456
    ....

```
Give the rights permissions to the cache and log dirs.
```sh
$ sudo chmod 777 your-project-path/app/config/cache -R
$ sudo chmod 777 your-project-path/app/config/logs -R
```
Create your database;
```sql
create database if not exists lendico_bank;
```
```sh
$ composer install
```
Execute [Doctrine](http://docs.doctrine-project.org/projects/doctrine-migrations/en/latest/) migrations.
```sh
cd your-project-path/ && app/console doctrine:migrations:migrate --no-interaction
```

### Examples
*See API.md*

### Postman
You could import a postman collection using Postman-LendicoBank.json
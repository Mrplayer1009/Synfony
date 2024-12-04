# Synfony

Installation entière de Synfony pour windows

```symfony new --webapp symfony```
```composer require symfony/orm-pack```
```composer require symfony/maker-bundle --dev```

avant de créé la bdd faire attention a ce que le fichier php.ini
enlever le ";" de ;extension=pdo_mysql

```symfony local:new ./Test```

```symfony console doctrine:database:create```

dans le .env
DATABASE_URL="mysql://root:root@127.0.0.1:3306/'BDD a nommer ici "symphony"'"




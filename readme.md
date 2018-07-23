
Para criar Controller/Model e migration utilizar <php artisan model:model XXX --all>


Para funcionar a aplicacao
tem que criar um virtual host na maquina para apontar a aplicação

Para configurar virtual host do laravel
<Directory /var/www/html/portal-light/public>
          AllowOverride All
          allow from all
          Options +Indexes
</Directory>


se der erro na hora de rodar as migrations e dar um erro que não achou o PDO, então que instalar esses modulos do php
sudo apt-get install php-gd php-mysql

Instalar PHP >=7.2

dar um git clone no repositório

>git clone https://github.com/CharlesMendes1/gerenciador-de-solicitacao.git

após dar um git clone você pode dar start no servidor laravel , ou criar um virtual host para o laravel , se você criar um virtual host não precisar ficar dando start no servidor do laravel

para dar start no laravel
>php artisan laravel

para criar um virtual host

ir até o diretório 
>cd /etc/apache2/sites-available/

copiar e colar arquivo conf que configura um novo virtual host
>sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/gerenciador.conf

adicionar no arquivo conf
        ServerAlias gerenciador.c
        ServerName gerenciador
        DocumentRoot /var/www/html/gerenciador-de-solicitacao/public
        <Directory /var/www/html/gerenciador-de-solicitacao/public>
          AllowOverride All
          allow from all
          Options +Indexes
        </Directory>
	
após realizar esta configuração :

Ativar os arquivo de configuração

>sudo a2ensite example.com.conf

e Restart o servidor apache 2
>sudo service apache2 restart

adicionar localização da virtual hosts no hosts
>127.0.0.1       gerenciador.c

Apos isso rodar
>composer update

>composer install

dar permissão para as pastas
>sudo chmod -R 777 /var/www/html/gerenciador-de-solicitacao/storage/

adicionar o arquivo .env
>cp /var/www/html/gerenciador-de-solicitacao/.env.example .env

gerar a chave 
>php artisan key:generate


------------
para configurar tabela usuario
https://pt.stackoverflow.com/questions/187488/personalizando-uma-model-de-usuarios-laravel-5-4-problema-no-login



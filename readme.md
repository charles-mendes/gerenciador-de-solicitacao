------------------No Windows------------------
primeiro instala o wamp 


depois instala o composer
obs : na hora da instalação tu tem que escolher o php7.2 na caixa de opções 
para que o composer seja instalado dentro do php7.2


instalar o laravel : 
>composer global require "laravel/installer"


dentro do projeto do laravel , rodar 
>composer update -- pra baixar algumas atualizacaos q faltaram 
obs:demora para caramba esse comando

>composer dump-autoload -- pra limpar uns erros laaa


inicio o laravel dentro do projeto 
>php artisan serve


adicionar o arquivo .env no projeto, pq o env não vem, tem que copiar um arquivo de exemplo que tem no laravel
>copiar arquivo .env.example e dar o nome de .env

gerar a chave key do laravel
>php artisan key:generate --force.

da pra usar o console CMD dentro do VScode 
>Ctrl + Shift + P - abre caixa de pesquisa no vsCode
>digitar : Create new integrated Terminal




--------------------No linux--------------------
instalar Apache 2
instalar mysql
Instalar PHP >=7.2

dar um git clone no repositório

>git clone https://github.com/CharlesMendes1/gerenciador-de-solicitacao.git

tem que configurar o arquivo .env do laravel

após dar um git clone você pode dar start no servidor laravel ,ou criar um virtual host para o laravel ,
se você criar um virtual host não precisar ficar dando start no servidor do laravel

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


abrir arquivo hosts : sudo nano /etc/hosts
adicionar localização da virtual hosts no hosts 
>127.0.0.1       gerenciador.c

Apos isso rodar
>composer update

>composer install

dar permissão para as pastas
>sudo chmod -R 777 /var/www/html/gerenciador-de-solicitacao/storage/

adicionar o arquivo .env no projeto, pq o env não vem, tem que copiar um arquivo de exemplo que tem no laravel
>cp /var/www/html/gerenciador-de-solicitacao/.env.example .env

gerar a chave key do laravel
>php artisan key:generate


para configurar tabela usuario
https://pt.stackoverflow.com/questions/187488/personalizando-uma-model-de-usuarios-laravel-5-4-problema-no-login


para gerar os usuario fakes 
>php artisan db:seed --class=UsuarioTableSeeder -v



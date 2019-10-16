
## [Posto Médico UEMA API](http://www.postomedico.ga)
API destinada ao posto médico da Universidade Estadual do Maranhão - UEMA que irá ser consumida pela aplicação   [Posto Médico](https://github.com/alexilallas/Posto-Medico-com-Angular-8)

### Tecnologias Utilizadas

* PHP 7.3
* Laravel 5.7
* MySQL 5.7.19

### Instalação

Para o gerenciamento dos pacotes foi utilizado o `composer`, caso não tenha instalado. seu download está disponível [aqui](https://getcomposer.org/) para windows ou `sudo apt-get install composer` para linux.
 
 Com o `composer` instalado, baixe as dependências do projeto através do seguinte comando:

 `composer install`

Este projeto utiliza a framework [Laravel](https://laravel.com/docs/5.7/installation), que conta com o  [`artisan`](https://laravel.com/docs/5.7/artisan),  uma CLI que contém vários comandos que irão nos auxiliar no desenvolvimento/manutenção da aplicação.

Após o download das dependências, copie o arquivo `.env.exemple` para `.env`  e execute o seguinte comando 

>`php artisan key:generate` 
>Este comando irá gerar a chave da aplicação.

Após isso, abra o arquivo `.env` e configure o banco que será utilizado corretamente, como mostrado abaixo.

`DB_HOST=id_do_seu_servidor_mysql`

`DB_PORT=porta_do_mysql`

`DB_DATABASE=nome_do_banco`

`DB_USERNAME=usuario_do_banco`

`DB_PASSWORD=senha_do_usuario_do_banco`

>**Nota**: Quando o sistema subir para produção, atribuir à variável`APP_DEBUG` o valor `false` para que o sistema não mostre explicitamente  os erros ao usuário.
`APP_DEBUG = false`

Com o banco configurado corretamente, podemos rodar as [`migrações`](https://laravel.com/docs/5.7/migrations) do Laravel. As `migrações` são basicamente uma estrutura que irá gerar todas as tabelas no banco.
Para executar as `migrações` utilizamos o seguinte comando:

`php artisan migrate --seed`

O parâmetro `--seed` é passado para que seja adicionado também os [seeders](https://laravel.com/docs/5.7/seeding). Portanto, com o comando acima irá criar as tabelas e também  adicionar registros a elas.

Com as tabelas do banco criadas, podemos subir o servidor local, para isso usamos o servidor do `artisan` com o seguinte comando:

`php artisan serve`

Por padrão, a aplicação estará no ar na URL 

http://localhost:8000

Se tudo ocorreu certo, será mostrada a página inicial do Laravel Framework.

### Estrutura do projeto

````
|-- app
	|-- Exceptions
	|-- Helpers
	|-- Http
		|-- Controllers
			|-- Auth
			|-- JWT
			|-- Manager
			|-- System
		|-- Middleware
	|-- Models
	|-- Providers
|-- ...
|-- config
|-- database
	|-- ...
	|-- migrations
	|-- seeds
|-- modelagem do banco
|-- ...
|-- resources
|--...
|-- vendor
|-- composer.json
|-- package.json
|-- ...
````
O pontilhado representa outros diretórios que fazem parte do padrão da framework e não foram alterados.
	


 - **app** -



### Implantação



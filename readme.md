
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

`php artisan key:generate` 
>Este comando irá gerar a chave da aplicação.


`php artisan jwt:secret` 
>Este comando irá gerar a chave do JWT.


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

O parâmetro `--seed` é passado para que seja adicionado também os [seeders](https://laravel.com/docs/5.7/seeding). Portanto, o comando acima irá criar as tabelas e também  adicionar registros a elas.

Com as tabelas do banco criadas, podemos subir o servidor local, para isso usamos o servidor do `artisan` com o seguinte comando:

`php artisan serve`

Por padrão, a aplicação estará no ar na URL 

http://localhost:8000

Se tudo ocorreu certo, será mostrada a página inicial do API.

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
            |-- Controller.php
		|-- Middleware
	|-- Models
	|-- ...
|-- ...
|-- config
|-- database
	|-- ...
	|-- migrations
	|-- seeds
|-- modelagem do banco
|-- ...
|-- resources
|-- routes
|--...
|-- vendor
|-- composer.json
|-- ...
````
O pontilhado representa outros diretórios que fazem parte parte do padrão da framework e não precisamos mexer.
	


 -  **app** - Contém todo o código-fonte da aplicação.
	- **Exceptions** - Contém a classe `Handler`, responsável por reportar e renderizar erros da aplicação. Todos as Exceptions da aplicação passarão por essa classe. As alterações realizadas nesse método foram em relação ao tratamento de Exceptions do tipo `Tymon\JWTAuth\Exceptions`.
	- **Helpers** - Contém as funções "helpers" que podem ser utilizadas em qualquer parte do projeto.
	- **Http** - Contém todos os controllers, middlewares e o `kernel` responsável pelas requisições http.
		- **Controllers** - Contém todos os controllers usados pela API.
			- **Auth** - Esta é uma pasta padrão do Laravel, ela é gerada ao executar o comando `php artisan make:auth`, a única classe utilizada/modificada no projeto é `ResetPasswordController`.
			- **JWT** - Contém o controller responsável pela autenticação dos usuários.
			- **Manager** - Contém os controllers responsáveis pelo gerenciamento de usuários e perfis no sistema.
			- **System** - Contém os controllers responsáveis pelos Pacientes, Inventário, Relatórios, Auditoria e Dashboard.
			- **Controller.php** - O controller base, o qual todos os outros da aplicação irão estender. Contém os métodos básicos que poderão ser utilizados por qualquer controller.
		 - **Middleware** - Contém todos os middleware utilizados pela API, apenas o middleware `Cors` e `CheckPermission` foram criados, os demais são padrões do Laravel.
	 - **Models** - Contém todas as Models da aplicação.
 - **config** - Contém os arquivos de configurações da framework, apenas `jwt.php` foi adicionado, os demais arquivos são padrão.
 - **database** - Contém os arquivos responsáveis pelas tabelas do banco.
	 - **migrations** -  Contém o código responsável pela geração das tabelas que serão utilizadas pela aplicação. Cada arquivo irá gerar uma tabela no banco.
	 - **seeds** - Contém o código responsável pela população das tabelas. A classe `DatabaseSeeder` é a classe principal, responsável por chamar as outras classes que irão inserir popular as tabelas. É importante lembrar que o seeder é apenas para o ambiente de teste, quando a aplicação subir para o ambiente de produção, não é necessário rodar os seeders.
 - **modelagem do banco** - Contém o arquivo `.mwb`com a modelagem do banco, que pode ser aberto com o `MySQL workbench`.
 - **resources** - Contém a única view utilizada pela API, a página inicial.
 - **routes** - Contém os arquivos de rotas da API, o arquivo utilizado é o `api.php`.
 - **vendor** - Diretório que armazena as bibliotecas baixadas pelo composer. As bibliotecas definidas no `composer.json` são baixadas e colocadas nesta pasta.
 - **composer.json** - Arquivo de configurações de dependências e autoloader.
 

### Implantação
Para a implantação da API, necessita apenas configurar o arquivo `.env` corretamente:

A variável `APP_ENV` deve ser setada para `production` e o `APP_DEBUG` deve ser setado para `false`.

Dessa forma, no arquivo `.env` terá as variáveis como vemos abaixo:

`APP_ENV=production`

`APP_DEBUG=false`



##
## Task Maneger - Gerenciador de Tarefas
##
## Como Testar:

Faça o clone do repositório na sua máquina

```bash
git clone git@github.com:guibmolina/task-maneger.git
```

### Configuração do ambiente
***

**Para configuração do ambiente é necessário ter o [Docker](https://docs.docker.com/desktop/) instalado em sua máquina.**

Dentro da pasta do projeto, rode o seguinte comando: `docker-compose up -d`.

Copie o arquivo `.env.example` e renomeie para `.env` dentro da pasta raíz da aplicação.

```bash
cp .env.example .env
```
É no  `.env` que estão as configurações de ambiente para o envio de email, como teste, utilizei o serviço https://mailtrap.io/ que é bem fácil de configurar, só realizar o login no site e mudar as credenciais do`.env`. Como o exemplo a seguir:
```bash
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=75e25d9765f1a7
MAIL_PASSWORD=7fe0ef832e862a
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="email@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```


Após criar o arquivo `.env`, será necessário acessar o container da aplicação para rodar alguns comandos de configuração do Laravel.

Para acessar o container use o comando `docker exec -it task-maneger-app bash`.

Digite os seguintes comandos dentro do container:

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan jwt:secret
```

## Endpoints

###  Criação de usuário

Requisição
```bash
POST  http://localhost:8000/api/v1/users

body:
{
	"name": "Guilherme",
	"email":"guilherme@teste.com",
	"password":"12345"
}

```
Resposta
```
{
	"id": 1
}
```
Campo       | Tipo      | Obrigatório   
----------- | :------:  | :------:        
name        | string    	 | true                 
email       | string     	 | true      
password  	| string    	 | true         



###  Login de usuário

Requisição
```bash
POST  http://localhost:8000/api/v1/auth

body:
{
	"email":"guilherme@teste.com",
	"password":"12345"
}
```
Resposta
```
{
	"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2F1dGgiLCJpYXQiOjE2Nzc2MzM0NjUsImV4cCI6MTY3NzYzNzA2NSwibmJmIjoxNjc3NjMzNDY1LCJqdGkiOiJCRkZTbnhpMjVsc1NUeGo4Iiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.84CPoLwtWGn6r75mmHoqBwWl6S1nsmTBoOzL2OGJ99E"
}
```

Campo       | Tipo      | Obrigatório   
----------- | :------:  | :------:                       
email       | string     	 | true      
password  	| string    	 | true  


Lembrando que esse token deve ser passado no *header* como **Authorization: Bearer [token]** de todas  requisições a baixo, é com ele que vamos autenticar o usuário nas requisições.

###  Listar Usuários

Requisição
```bash
GET  http://localhost:8000/api/v1/users
Authorization: Bearer [token]

```
Resposta
```
[
	{
		"id": 1,
		"name": "Guilherme",
		"email": "guilherme@teste.com"
	},
	{
		"id": 2,
		"name": "Guilherme",
		"email": "guilherme2@teste.com"
	},
	{
		"id": 3,
		"name": "Guilherme",
		"email": "guilherme3@teste.com"
	}
]
```


###  Criação de tarefa

Requisição
```bash
POST  http://localhost:8000/api/v1/tasks
Authorization: Bearer [token]

body:
{
	"title": "task test",
	"description": "Description test",
	"start_date": "2023/02/28",
	"end_date": "2023/03/28",
	"status_id": 1,
	"users_id":["1"]
}

```
Resposta
```
{
	"id": 1,
	"title": "task test",
	"description": "Description test",
	"start_date": "2023-02-28 00:00:00",
	"end_date": "2023-02-28 00:00:00",
	"status": "em andamento",
	"users": [
		{
			"id": 1,
			"name": "Guilherme"
		}
	]
}
```
Campo       | Tipo      | Obrigatório   
----------- | :------:  | :------:        
title       | string    	 | true                 
description | string     	 | true      
start_date  | string/date    | true 
end_date    | string/date    | true  
status_id   | int		     | true   
users_id   	| array[user_id] | true         


#### É possivel adicionar mais de um usuário em uma tarefa:
Basta adicionar um novo item no array de users_id, passando o id do usuário
```bash
	"users_id":["1", "2"]
```

###  Listar Tarefas

Requisição
```bash
GET  http://localhost:8000/api/v1/tasks
Authorization: Bearer [token]
```
Resposta
```
[
[
	{
		"id": 1,
		"title": "task test",
		"description": "Description test",
		"start_date": "2023-02-28 00:00:00",
		"end_date": "2023-02-28 00:00:00",
		"status": "em andamento",
		"users": [
			{
				"id": 1,
				"name": "Guilherme"
			}
		]
	},
	{
		"id": 2,
		"title": "task test 2",
		"description": "Description test 2",
		"start_date": "2023-02-28 00:00:00",
		"end_date": "2023-02-28 00:00:00",
		"status": "em andamento",
		"users": [
			{
				"id": 1,
				"name": "Guilherme"
			},
			{
				"id": 2,
				"name": "Guilherme"
			}
		]
	}
]
```


### Filtros
É possível combinar filtros na listagem  de tarefas

##### Filtar por um ou mais usuários
```bash
GET  http://localhost:8000/api/v1/tasks?user_id[]=1&user_id[]=3
```
##### Filtrar pelo status da tarefa
```bash
GET  http://localhost:8000/api/v1/tasks?status_id=1
```

###  Atualização da Tarefa

Requisição
```bash
PUT  http://localhost:8000/api/v1/tasks/{task_id}
Authorization: Bearer [token]

body:
{
	"title": "task test",
	"description": "Description test",
	"start_date": "2023/02/28",
	"end_date": "2023/03/28",
	"status_id": 2,
	"users_id":["1"]
}

```
Resposta
```
{
	"id": 1,
	"title": "task test",
	"description": "Description test",
	"start_date": "2023-02-28 00:00:00",
	"end_date": "2023-02-28 00:00:00",
	"status": "concluído",
	"users": [
		{
			"id": 1,
			"name": "Guilherme"
		}
	]
}
```
Campo       | Tipo      | Obrigatório   
----------- | :------:  | :------:        
title       | string    	 | true                 
description | string     	 | true      
start_date  | string/date    | true 
end_date    | string/date    | true  
status_id   | int		     | true   
users_id   	| array[user_id] | true   

###  Exclusão da Tarefa

Requisição
```bash
DELETE  http://localhost:8000/api/v1/tasks/{task_id}
Authorization: Bearer [token

```

###  Listar Status

Requisição
```bash
GET  http://localhost:8000/api/v1/status
Authorization: Bearer [token]

```
Resposta
```
[
	{
		"id": 1,
		"description": "em andamento"
	},
	{
		"id": 2,
		"description": "concluída"
	},
	{
		"id": 3,
		"description": "cancelada"
	}
]
```

##
##  Rodar a fila de emails
Toda a vez que uma tarefa é atribuida a um usuário ou quando ela passa para o status de concluído, um email é enviado para os usuários daquela tarefa.
E como isso é feito de maneira assíncrona, precisamos rodar a fila do Laravel via terminal, para isso basta executar:
`$ docker exec -it task-maneger-app php artisan queue:listen`

***
###  Testes

`$ docker exec -it task-maneger-app php artisan test `

***
### Insomnia
Segue no reposotório o arquivo .json da collection do Insomnia com todas as requisições (Insomnia_task_maneger.json)

Para rodar o projeto sem a necessidade de containers:

1. Rodar o script .sql para criar a base de dados

2. Acessar o back-end `cd back-end/`

3. instalar os pacotes do php `composer install`

4. Popular a base de dados `php artisan db:seed`
     - Se necessario resetar a base `php artisan migrate:fresh --seed`

5. Criar o .env `cd .env.example .env`

6. Rodar o servidor `php artisan serve --port=8081`
     - O front-end foi desenvolvido com base nessa url, sem setar a porta, não vai funcionar

7. Acessar o front-end `cd ../front-end`

8. Instalar os pacotes `npm install`

9. Rodar o servidor `vue serve`

7. acessar o endereço disponibilizado pelo Vue
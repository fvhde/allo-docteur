# Doctor Appointment rest api
This is a simple rest api for doctor appointment. It is built using php, symfony 6 and docker.

## Installation
1. Clone the repository
2. Generate ssl certificates and place them in `var/ssl/jwt` directory
3. copy `.env.dev` to `.env.dev.local`. This file is ignored by git and is used to override the default environment variables.
4. in `.env.dev.local` set `JWT_PASSPHRASE` to the passphrase you used to generate the certificates.
5. Run `docker-compose up -d` to start the containers
6. Run `docker-compose exec php composer install` to install the dependencies
7. Run `docker-compose exec php bin/console doctrine:migrations:migrate` to create the database tables
8. Run `docker-compose exec php bin/console doctrine:fixtures:load` to load the fixtures

You should now have user with the following credentials:
- email: `pro@fixture.com`
- password: `123456`
- role: `ROLE_PROFESSIONAL`


- email: `dev@fixture.com`
- password: `123456`
- role: `ROLE_PATIENT`

## Usage
1. Visit `http://localhost:90/api/doc` to view the documentation, you can change port in `docker-compose.yml` file.
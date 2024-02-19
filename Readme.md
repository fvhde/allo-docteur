# Doctor Appointment System
This is a simple system for doctor appointment. It is built using symfony 6 and docker.

## Setup the system
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
1. Visit `http://localhost:90` to get into home page
2. Visit `http://localhost:90/admin/login` to log as professional or admin user
3. Visit `http://localhost:90/api/doc` to view the rest api documentation

`90` is the default port, you can change it in `docker-compose.yml` file.
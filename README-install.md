# Installation Steps

1. Clone repository
2. Run `docker-compose up -d`
3. Run `docker container exec -it vero-test-case-app_php-1 sh -c "cd /var/www/html && bin/composer install"`
4. Import postman collection from `postman` folder (not really necessary it's just for your convenience)
5. Hit API to get PDF: `http://localhost:8081?username=365&password1`

# What exactly this project is doing and what we are looking for?
1. This project is based on Symfony 7 and PHP 8.2
2. In this project ADR & MVC patterns are used together to increase ENCAPSULATION
3. SOLID principles are highly considered
4. Some tests are included (see below)
5. Credentials are stored in .env file to increase SECURITY
6. Docker is used to increase PORTABILITY
7. Postman is used to increase DOCUMENTATION
8. Most possible design patterns are used to increase REUSABILITY

# Testing
Considering the time limit, only a few tests are included. You can run tests by running `docker container exec -it vero-test-case-app_php-1 sh -c "cd /var/www/html && bin/phpunit"`

As you can see in the structure, all services are encapsulated. It means we can write tests for each service separately. But, as I mentioned above, only a few tests are included.
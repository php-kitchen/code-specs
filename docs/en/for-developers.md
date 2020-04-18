# Setting Up Environment

Build Docker image
```bash
docker-compose build
```

Install dependencies
```bash
docker-compose run --rm php-cli composer install 
```

# Testing Changes
```bash
docker-compose run --rm php-cli vendor/bin/phpunit tests
```
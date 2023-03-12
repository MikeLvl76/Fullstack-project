# API

The API will be here.

Refer to the [Getting Started Guide](https://api-platform.com/docs/distribution) for more information.

# Tests

|Command description|On Linux|On Windows|
|--|--|--|
|Install test mechanism (if not already install)|sudo docker compose exec php     composer require --dev symfony/test-pack|docker compose exec php     composer require --dev symfony/test-pack|
|Run all tests|sudo docker compose exec php     bin/phpunit|docker compose exec php     bin/phpunit|
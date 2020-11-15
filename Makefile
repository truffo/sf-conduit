test:
	php bin/console doctrine:database:create
	./bin/phpunit
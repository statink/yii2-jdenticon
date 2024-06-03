.PHONY: all php clean dist-clean
all: php

php: vendor

dist-clean: clean
	rm -rf composer.phar vendor node_modules

clean:

vendor: composer.lock composer.phar
	./composer.phar install --prefer-dist -vvv

composer.lock: composer.json composer.phar
	./composer.phar update --prefer-dist -vvv

composer.phar:
	curl -sSL 'https://getcomposer.org/installer' | php -- --stable
	touch -r composer.json $@

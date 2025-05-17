#!/usr/bin/bash
vendor/bin/phpstan analyse app
php code-checker/code-checker -f
cd cypress/ && npx cypress run; cd -

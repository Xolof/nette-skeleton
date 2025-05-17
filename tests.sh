#!/usr/bin/bash
vendor/bin/phpstan analyse app
php code-checker/code-checker
cd cypress/ && npx cypress run; cd -


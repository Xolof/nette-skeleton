#!/usr/bin/bash
vendor/bin/php-cs-fixer fix app/Model app/Presentation

vendor/bin/phpcs app --ignore=app/Presentation/Accessory/*,app/Presentation/Error/*,app/Bootstrap.php,app/Core/* -s
vendor/bin/phpcbf app --ignore=app/Presentation/Accessory/*,app/Presentation/Error/*,app/Bootstrap.php,app/Core/* -s

vendor/bin/phpmd app/Model text cleancode
vendor/bin/phpmd app/Presentation text cleancode

vendor/bin/phpstan analyse app/Model app/Presentation --memory-limit="512M"

cd cypress/ && npx cypress run; cd -

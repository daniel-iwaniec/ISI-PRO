#!/usr/bin/env bash
php app/console cache:clear -e prod
php app/console assets:install -e prod
php app/console assetic:dump -e prod
php app/console doctrine:schema:update --force
grunt

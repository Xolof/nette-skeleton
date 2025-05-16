#!/usr/bin/bash
docker exec -it nette-skeleton-mysql-1 sh -c "mysql -unette -ppass nettedb -e 'source docker-entrypoint-initdb.d/setup.sql'"

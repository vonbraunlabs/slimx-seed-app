#!/bin/bash

NAME=$1
LOWER=$(echo $NAME | awk '{print tolower($0)}')

echo "$NAME $LOWER"

for e in config/ src/ tests/ phpunit.xml.dist docker-run.sh composer.json composer.lock index.php
do
    sed -i "s/SeedApp/$NAME/g" `find $e -type f`
    sed -i "s/seedapp/$LOWER/g" `find $e -type f`
done

mv src/SeedApp src/$NAME
mv tests/SeedApp tests/$NAME
cp config/application.php.template config/application.php

#!/bin/bash

NAME=$1
LOWER=$(echo $NAME | awk '{print tolower($0)}')

echo "$NAME $LOWER"

for dir in config/ src/ tests/ phpunit.xml.dist docker-run.sh
do
    sed -i "s/SeedApp/$NAME/g" $dir
    sed -i "s/seedapp/$LOWER/g" $dir
done

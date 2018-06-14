#!/bin/bash

docker build --pull -t seedapp-dev -f ./Dockerfile-dev .
docker run --rm -ti --network=backoffice_dbnet -v $(pwd):/opt --name seedapp seedapp-dev /bin/bash

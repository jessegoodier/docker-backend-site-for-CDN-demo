#!/bin/bash
set -e
#remove cache directories before build
sudo rm -rf var/cache/nginx/*
docker build --tag=image-dump .

#check if container exists and remove if so
if [ -n "$( docker container ls --all --quiet --filter name=image-dump )" ]; then
  echo "Container exists, removing"
  docker rm -f image-dump;
fi

#pass the ports and volumes
docker run --restart unless-stopped --name=image-dump -d -p 80:80 -p 443:443 -p 8080:8080 -v $PWD/image-dump:/usr/share/nginx/html image-dump:latest

#!/bin/bash
set -e
docker build --tag=image-dump .
docker container rm -f image-dump

docker run --restart unless-stopped --name=image-dump -d -p 80:80 -p 443:443 -p 8080:8080 -v $PWD/image-dump:/usr/share/nginx/html image-dump

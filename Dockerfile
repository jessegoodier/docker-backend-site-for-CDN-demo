FROM wyveo/nginx-php-fpm:php74
COPY etc/ssl/fullchain1.pem /etc/ssl/fullchain1.pem
COPY etc/ssl/privkey1.pem /etc/ssl/privkey1.pem
COPY etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY etc/nginx/conf.d/image-dump.conf /etc/nginx/conf.d/default.conf
COPY etc/nginx/conf.d/image-dump-ssl.conf /etc/nginx/conf.d/default-ssl.conf

EXPOSE 80 443 8080
#STOPSIGNAL SIGTERM

#CMD ["nginx", "-g", "daemon off;"]
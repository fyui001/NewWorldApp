FROM php:7.4-fpm-alpine

ARG TZ

COPY ./docker/php/startup.sh /root

WORKDIR /code

ADD . .

RUN set -eux && \
  apk add --update-cache --no-cache --virtual=.build-dependencies tzdata && \
  apk --no-cache add zip unzip composer npm && \
  docker-php-ext-install bcmath pdo_mysql && \
  chmod +x /root/startup.sh

CMD ["/root/startup.sh","php-fpm", "-F"]

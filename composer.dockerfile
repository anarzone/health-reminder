FROM composer:2


ENV PHPGROUP=hr
ENV PHPUSER=hr

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}; exit 0

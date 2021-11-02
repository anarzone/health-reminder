FROM nginx:stable-alpine

ARG NGINXGROUP
ARG NGINXUSER

#ENV NGINXGROUP=${NGINXGROUP}
#ENV NGINXUSER=${NGINXUSER}

ENV NGINXGROUP=hr
ENV NGINXUSER=hr

ADD nginx/default.conf /etc/nginx/conf.d/default.conf

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

RUN mkdir -p /var/www/html/public

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}; exit 0

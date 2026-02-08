FROM mysql:5.7.33

ENV MYSQL_ROOT_PASSWORD=K
ENV MYSQL_DATABASE=sctim
ENV MYSQL_USER=kab
ENV MYSQL_PASSWORD=Sc

COPY docker-entrypoint-initdb.d/ /docker-entrypoint-initdb.d/

EXPOSE 3306

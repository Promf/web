
FROM nginx:alpine

COPY index.html /usr/share/nginx/html

COPY login.php /usr/share/nginx/html

COPY styles/style.css /usr/share/nginx/html

COPY delete_user.php /usr/share/nginx/html

COPY add_user.php /usr/share/nginx/html

COPY news.php /usr/share/nginx/html

COPY workers.php /usr/share/nginx/html

COPY add_worker.php /usr/share/nginx/html

COPY delete_worker.php /usr/share/nginx/html

ENV MYSQL_DATABASE=mydb \
    MYSQL_USER=web \
    MYSQL_PASSWORD=123123 \
    MYSQL_ROOT_PASSWORD=123123

RUN apk update && \
    apk add --no-cache mariadb mariadb-client && \
    rm -rf /var/cache/apk/*


RUN apk add php82-fpm php82-soap php82-openssl php82-gmp php82-pdo_odbc php82-json php82-dom php82-pdo php82-zip php82-mysqli php82-sqlite3 php82-apcu php82-pdo_pgsql php82-bcmath php82-gd php82-odbc php82-pdo_mysql php82-pdo_sqlite php82-gettext php82-xmlreader php82-bz2 php82-iconv php82-pdo_dblib php82-curl php82-ctype

COPY nginx.conf /etc/nginx/nginx.conf

COPY php-fpm.conf /etc/php82/php-fpm.conf

COPY www.conf /etc/php82/php-fpm.d

COPY main.php /usr/share/nginx/html

RUN mysql_install_db --user=mysql --datadir=/var/lib/mysql

COPY init.sql /docker-entrypoint-initdb.d/init.sql

VOLUME ["/var/lib/mysql", "/usr/share/nginx/html", "/etc/nginx"]

CMD ["sh", "-c", "php-fpm82 && mariadbd-safe --datadir=/var/lib/mysql & sleep 10 && mariadb -u root < /docker-entrypoint-initdb.d/init.sql && nginx -g 'daemon off;'"]

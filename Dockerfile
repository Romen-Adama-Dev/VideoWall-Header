FROM php:8.3-apache

WORKDIR /var/www/html

RUN a2enmod headers \
    && { \
        echo "ServerTokens Prod"; \
        echo "ServerSignature Off"; \
        echo "DirectoryIndex index.php index.html"; \
    } > /etc/apache2/conf-available/videowall-header.conf \
    && a2enconf videowall-header

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/cache \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && chmod 775 /var/www/html/cache \
    && chmod 755 /var/www/html/docker-entrypoint.sh

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD php -r "exit(@file_get_contents('http://127.0.0.1/health.php') === 'ok' ? 0 : 1);"

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]

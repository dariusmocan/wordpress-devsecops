# Base: pin to a specific digest for reproducibility
FROM wordpress:6.5-php8.2-apache

# Metadata labels (OCI standard)
LABEL org.opencontainers.image.title="WordPress Hardened"
LABEL org.opencontainers.image.description="Security-hardened WordPress image"
LABEL org.opencontainers.image.vendor="Your Name"

# 1. Update all OS packages and remove unnecessary tools 
RUN apt-get update && apt-get upgrade -y && \
    apt-get remove -y \
        telnet \
        netcat-traditional && \
    apt-get autoremove -y && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# 2. Disable dangerous PHP functions
RUN echo "disable_functions = exec,passthru,shell_exec,system,proc_open,\
popen,parse_ini_file,show_source,phpinfo,symlink,fsockopen,\
pfsockopen,stream_socket_client" \
    >> /usr/local/etc/php/conf.d/security.ini && \
    echo "expose_php = Off"           >> /usr/local/etc/php/conf.d/security.ini && \
    echo "display_errors = Off"       >> /usr/local/etc/php/conf.d/security.ini && \
    echo "log_errors = On"            >> /usr/local/etc/php/conf.d/security.ini && \
    echo "allow_url_fopen = Off"      >> /usr/local/etc/php/conf.d/security.ini && \
    echo "allow_url_include = Off"    >> /usr/local/etc/php/conf.d/security.ini && \
    echo "file_uploads = Off"         >> /usr/local/etc/php/conf.d/security.ini && \
    echo "session.cookie_httponly = 1" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "session.cookie_secure = 1"  >> /usr/local/etc/php/conf.d/security.ini && \
    echo "session.use_strict_mode = 1" >> /usr/local/etc/php/conf.d/security.ini

# 3. Apache hardening 
RUN echo "ServerTokens Prod" > /etc/apache2/conf-available/security-hardened.conf && \
    echo "ServerSignature Off" >> /etc/apache2/conf-available/security-hardened.conf && \
    echo "TraceEnable Off"     >> /etc/apache2/conf-available/security-hardened.conf && \
    echo "Header always set X-Frame-Options SAMEORIGIN" \
        >> /etc/apache2/conf-available/security-hardened.conf && \
    echo "Header always set X-Content-Type-Options nosniff" \
        >> /etc/apache2/conf-available/security-hardened.conf && \
    echo "Header always set X-XSS-Protection \"1; mode=block\"" \
        >> /etc/apache2/conf-available/security-hardened.conf && \
    echo "Header always set Referrer-Policy strict-origin-when-cross-origin" \
        >> /etc/apache2/conf-available/security-hardened.conf && \
    a2enconf security-hardened && \
    a2enmod headers

# 4. Disable XML-RPC and block wp-login.php brute force
COPY hardening/wp-hardening.htaccess /var/www/html/.htaccess

# 5. WordPress hardened config additions 
COPY hardening/wp-config-security.php /tmp/wp-config-security.php

# 6. Remove readme and install files
RUN rm -f /var/www/html/readme.html \
          /var/www/html/license.txt \
          /var/www/html/wp-config-sample.php

# 7. Drop to non-root user (www-data already exists in the image)
# WordPress still needs write access to wp-content for uploads
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# wp-config.php should be readable only by www-data
RUN chmod 640 /var/www/html/wp-config.php 2>/dev/null || true

USER www-data

EXPOSE 80

CMD ["apache2-foreground"]
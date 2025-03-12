FROM surnet/alpine-wkhtmltopdf:3.20.2-0.12.6-full as wkhtmltopdf
FROM php:8.2.13-fpm-alpine
# install extensions

RUN apk add --update linux-headers \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.2.2 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

RUN apk --update add --virtual build-dependencies build-base openssl-dev autoconf

RUN pecl install igbinary

# Install dependencies for wkhtmltopdf
RUN apk add --no-cache \
    libstdc++ \
    libx11 \
    libxrender \
    libxext \
    libssl3 \
    ca-certificates \
    fontconfig \
    freetype \
    ttf-dejavu \
    ttf-droid \
    ttf-freefont \
    ttf-liberation \
    # more fonts
  && apk add --no-cache --virtual .build-deps \
    msttcorefonts-installer \
  # Install microsoft fonts
  && update-ms-fonts \
  && fc-cache -f \
  # Clean up when done
  && rm -rf /tmp/* \
  && apk del .build-deps

# Copy wkhtmltopdf files from docker-wkhtmltopdf image
COPY --from=wkhtmltopdf /bin/wkhtmltopdf /bin/wkhtmltopdf
COPY --from=wkhtmltopdf /bin/wkhtmltoimage /bin/wkhtmltoimage
COPY --from=wkhtmltopdf /lib/libwkhtmltox* /lib/

# install bcmath extension
RUN docker-php-ext-install bcmath

RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

RUN sed -i -e 's/listen.*/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.conf

RUN echo "expose_php=0" > /usr/local/etc/php/php.ini

CMD ["php-fpm"]

# Usamos una imagen base oficial de PHP (Apache)
FROM php:8.0-apache

# Instalar dependencias necesarias (si tienes alguna dependencia adicional, puedes agregarla aquí)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd

# Copiar el código de la aplicación al directorio de trabajo del contenedor
COPY . /var/www/html/

# Habilitar el mod_rewrite de Apache (si es necesario)
RUN a2enmod rewrite

# Exponer el puerto en el que se ejecuta Apache (80 es el puerto por defecto)
EXPOSE 80

# El contenedor se ejecutará en Apache por defecto
CMD ["apache2-foreground"]

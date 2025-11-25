FROM php:8.2-fpm

#Liste des arguments
ARG user=laravel
ARG uid=1000

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    netcat-openbsd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

#Installer les extensions php
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

#Récupérer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer un utilisateur système
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Modifier le répertoire de travail
WORKDIR /var/www

# Copier les fichiers d'application
COPY --chown=$user:$user . /var/www


ENV WAYFINDER_ENABLED=false

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install NPM dependencies and build assets
RUN npm ci

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
CMD ["/usr/local/bin/start.sh"]

#Modifier les permissions des dossiers
RUN chown -R $user:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache


USER $user

# Exposer le port 9000
EXPOSE 9000



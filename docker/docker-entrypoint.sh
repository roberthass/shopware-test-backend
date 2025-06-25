#!/bin/bash

# Composer installieren
composer install --no-interaction --optimize-autoloader

# Apache starten
apache2-foreground

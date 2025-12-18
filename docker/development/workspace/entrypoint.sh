#!/bin/bash
set -e

# Load NVM
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

# Install Composer dependencies if vendor directory doesn't exist
if [ ! -d "/var/www/vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --optimize-autoloader
else
    echo "Composer dependencies already installed."
fi

# Install NPM dependencies if node_modules doesn't exist
if [ ! -d "/var/www/node_modules" ]; then
    echo "Installing NPM dependencies..."
    npm install
else
    echo "NPM dependencies already installed."
fi

# Fix permissions for Laravel directories
echo "Fixing Laravel storage and cache permissions..."
mkdir -p /var/www/storage/framework/{cache,sessions,views}
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

echo "Workspace ready!"

# Run the default command (bash to keep container running)
exec "$@"

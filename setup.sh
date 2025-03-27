#!/bin/bash

# Make sure the database directory exists
mkdir -p database

# Create an empty SQLite database file if it doesn't exist
touch database/database.sqlite

# Build and start the Docker containers
docker-compose up -d

# Wait for containers to be ready
echo "Waiting for containers to start..."
sleep 5

# Run migrations and seed the database
docker exec -it mwlbasket php artisan migrate:fresh --seed

# Generate app key
docker exec -it mwlbasket php artisan key:generate

echo "Setup complete! The API is available at http://localhost:9876"
echo ""
echo "Default user credentials:"
echo "Email: roy@wmlbasket.com"
echo "Password: password1234"
echo ""
echo "You can use these credentials to obtain an API token by making a POST request to /api/login"
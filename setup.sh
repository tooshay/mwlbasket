#!/bin/bash
set -e

echo "Setting up MWL Basket API..."

# Make sure the database directory exists
mkdir -p database

# Create an empty SQLite database file if it doesn't exist
touch database/database.sqlite

# Build and start the Docker containers
echo "Building and starting Docker containers..."
docker-compose up -d --build

# Wait for containers to be ready
echo "Waiting for containers to start..."
sleep 8

# Run migrations and seed the database
echo "Setting up the database..."
docker exec mwlbasket php artisan migrate:fresh --seed

# Generate app key
echo "Generating application key..."
docker exec mwlbasket php artisan key:generate

echo "✅ Setup complete! The API is available at http://localhost:9876"
echo ""
echo "Default user credentials:"
echo "Email: roy@mwlbasket.com"
echo "Password: password1234"
echo ""
echo "You can use these credentials to obtain an API token by making a POST request to /api/login"
echo ""
echo "Example:"
echo "curl -X POST http://localhost:9876/api/login \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -d '{\"email\": \"roy@mwlbasket.com\", \"password\": \"password1234\"}'"
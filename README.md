# Shopping Basket API

A Laravel-based JSON API for managing shopping baskets with the ability to track items that were added to a basket but removed before checkout.

## Features

- User authentication with API tokens
- Add items to basket
- Remove items from basket
- Checkout functionality
- Track and retrieve removed items

## Requirements

- Docker and Docker Compose

## Running with Docker

1. Clone the repository

2. Navigate to the project directory:
   ```
   cd mwlbasket
   ```

3. Run the setup script:
   ```
   ./setup.sh
   ```
   
   This script will:
   - Create the SQLite database file
   - Start the Docker containers
   - Run migrations and seed the database
   - Generate an application key

The API will be available at `http://localhost:9876`

## API Endpoints

### Authentication
- `POST /api/login` - Login with email and password to get API token

### Basket Operations
- `GET /api/basket` - Get current basket
- `POST /api/basket/items` - Add item to basket
- `DELETE /api/basket/items/{item_id}` - Remove item from basket
- `POST /api/basket/checkout` - Checkout basket
- `GET /api/basket/removed-items` - Get items that were removed before checkout

## Example Usage

### Login to get API token
```
curl -X POST http://localhost:9876/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "roy@wmlbasket.com", "password": "password1234"}'
```

### Add item to basket
```
curl -X POST http://localhost:9876/api/basket/items \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"product_id": 1}'
```

### Remove item from basket
```
curl -X DELETE http://localhost:9876/api/basket/items/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Get removed items
```
curl -X GET http://localhost:9876/api/basket/removed-items \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Checkout
```
curl -X POST http://localhost:9876/api/basket/checkout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

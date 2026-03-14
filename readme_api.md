# API de Gestion d'Itinéraires Touristiques

A high-performance API built with Laravel 11 and PostgreSQL, specifically designed to handle complex travel itineraries, destination mapping, and user collaboration.

## Features

- **PostgreSQL Database**: Persistent data storage with properly defined relationships
- **Authentication**: API authentication using Laravel Sanctum with Bearer tokens
- **Forgot Password**: Secure password reset flow using reset tokens
- **Itinerary Tracking**: Full CRUD operations for managing travel expenses
- **Destination Management**: CRUD operations for destinations with automatic calculation of total spending
- **CORS Support**: Configured for seamless frontend integration
- **Simulated Network Delays**: Simulates realistic API response times for development and testing
- **Input Validation**: !Robust! validation for all API endpoints
- **Security**: Protection with bcrypt password hashing, Sanctum authentication, and safeguards against SQL injection

## Quick Start

### 1. Installation

# Clone the repository
git clone https://github.com/fakhrddinelargou/MarocExplore
cd finance-dashboard-api

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in the .env file

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_app_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Install API authentication (Laravel Sanctum)
php artisan install:api

# Run database migrations
php artisan migrate

# Start the development server
php artisan serve

The server will start on `http://127.0.0.1:8000`

### 3. Test the API

Visit `http://localhost:8000` to verify the server is running.

## API Endpoints

### Authentication
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login user
- `POST /api/auth/forgot-password` - Request password reset
- `POST /api/auth/reset-password` - Reset password with token

### Itinerary
- `GET /api/itineraries` - Get all user itineraries (protected)
- `POST /api/itineraries` - Create new itinerary (protected)
- `GET /api/itineraries/search` - Search itineraries (protected)
- `GET /api/itineraries/{id}` - Get a specific itinerary (protected)
- `GET /api/category/{category}/itineraries` - Get itineraries by category (protected)
- `PATCH /api/itineraries/{id}` - Update an itinerary (protected)
- `DELETE /api/itineraries/{id}` - Delete an itinerary (protected)

### Destination
- `GET /api/destinations` - Get all user destinations (protected)
- `POST /api/destinations` - Create new destinations (protected)
- `GET /api/destinations/{id}` - Get a specific itinerary (protected)
- `PATCH /api/destinations/{id}` - Update an destinations (protected)
- `DELETE /api/destinations/{id}` - Delete an destinations (protected)

### Favorites

- `GET /api/favorites` — Get all user favorites (protected)
- `POST /api/favorites/{id}` — Add an itinerary to favorites (protected)
- `DELETE /api/favorites/{id}` — Remove an itinerary from favorites (protected)

## Database

### Database Schema

## Database Schema

**Users Table:**
- id (BIGINT PRIMARY KEY)
- name (VARCHAR NOT NULL)
- email (VARCHAR UNIQUE NOT NULL)
- email_verified_at (TIMESTAMP) - nullable
- password (VARCHAR NOT NULL) - hashed with bcrypt
- remember_token (VARCHAR) - for "remember me" authentication
- created_at (TIMESTAMP NOT NULL)
- updated_at (TIMESTAMP NOT NULL)

**Itineraries Table:**
- id (BIGINT PRIMARY KEY)
- title (VARCHAR NOT NULL)
- category (VARCHAR NOT NULL)
- duration (VARCHAR NOT NULL)
- image (VARCHAR) - optional
- user_id (BIGINT NOT NULL) - foreign key referencing `users(id)` (on delete cascade)
- created_at (TIMESTAMP NOT NULL)
- updated_at (TIMESTAMP NOT NULL)

**Destinations Table:**
- id (BIGINT PRIMARY KEY)
- itinerary_id (BIGINT NOT NULL) - foreign key referencing `itineraries(id)` (on delete cascade)
- name (VARCHAR NOT NULL)
- location (VARCHAR NOT NULL)
- activities (TEXT NOT NULL) - list of activities or description
- created_at (TIMESTAMP NOT NULL)
- updated_at (TIMESTAMP NOT NULL)

**Itinerary_User Table (Favorites)**
- id (BIGINT PRIMARY KEY)
- user_id (BIGINT NOT NULL) - foreign key referencing `users(id)` (on delete cascade)
- itinerary_id (BIGINT NOT NULL) - foreign key referencing `itineraries(id)` (on delete cascade)
- created_at (TIMESTAMP NOT NULL)
- updated_at (TIMESTAMP NOT NULL)

## Demo User

The server comes with a pre-created demo user:
- **Name**: Demo User
- **Email**: `demo@example.com`
- **Password**: `password123`

The demo user includes sample itineraries and destinations for testing.

## Authentication

This API uses **Laravel Sanctum** for authentication. All protected routes require a **Bearer Token**.

## Example API Calls

### Register a New User
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
  }'
```
### Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "demo@example.com",
    "password": "password123"
  }'
```

### Forgot Password
```bash
curl -X POST http://localhost:8000/api/auth/forgot-password \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com"
  }'
```

### Reset Password
```bash
curl -X POST http://localhost:8000/api/auth/reset-password \
  -H "Content-Type: application/json" \
  -d '{
    "token": "your-reset-token",
    "email": "john@example.com",
    "newPassword": "newpassword123"
  }'
```

### Create an Itinerary
```bash
curl -X POST http://localhost:8000/api/itineraries \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer <your-token>" \
  -d '{
    "title": "casablanca",
    "category": "travel",
    "duration": "Coffee and snacks",
    "image": "image.png"
  }'
```

### Create an Destination
```bash
curl -X POST http://localhost:8000/api/itineraries \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer <your-token>" \
  -d '{
    "itinerary_id": 2 ,
    "name": "something",
    "location": "AIP LOK90",
    "activities": "do something fun"
  }'
```

### Add to Favorites
```bash
curl -X POST http://localhost:8000/api/favorites/2 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer <your-token>"



## Data Models

### User
```json
{
  "id": "uuid",
  "name": "string",
  "email": "string",
  "created_at": " date string",
  "updated_at": " date string"
}
```

### Itinerary
```json
{
  "id": "uuid",
  "user_id": "uuid",
  "title": "string",
  "category": "string",
  "duration": "string",
  "image": "string",
  "createdAt": " date string",
  "updatedAt": " date string"
}
```

### Destination
```json
{
  "id": "uuid",
  "itinerary_id": "uuid",
  "name": "string",
  "location": "string",
  "activities": "string",
  "createdAt": " date string",
  "updatedAt": " date string"
}
```

### Favorite
```json
{
  "id": "uuid",
  "itinerary_id": "uuid",
  "user_id": "uuid",
  "createdAt": " date string",
  "updatedAt": " date string"
}
```









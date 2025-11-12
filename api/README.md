# 🐳 Laravel Nginx API

This project provides a REST API for managing Nginx virtual hosts inside a Docker container.  
You can easily create, delete, or reload Nginx configurations for custom domains through simple HTTP requests.

---

## ⚙️ Requirements

- Docker & Docker Compose
- PHP 8.3+
- Composer

---

## 🚀 Getting Started

1. Clone the repository

   `git clone https://github.com/vovasl/laravel_api_nginx.git`

   `cd laravel_api_nginx`


2. Configure environment variables. Rename the file:api/.env.example → api/.env


3. Start Docker containers
`docker-compose up -d`


4. Install Laravel dependencies.
Enter the Laravel container:
`docker exec -it laravel_api bash`

    Then run:
`composer install`
`php artisan migrate`


5. Generate API Token (Test User) `php artisan make:test-user`

    This will create a test user and output an API token. Use that token to authenticate your API requests via the header: `Authorization: Bearer <your-token>`


## 🌐 Application URLs

API: http://localhost:9000/

Client: http://localhost:8000/

## 📡 API Endpoints
| Category                | Method   | Endpoint                      | Body Example                 | Description                     |
| ----------------------- | -------- | ----------------------------- | ---------------------------- | ------------------------------- |
| **🔧 Nginx Management** | `POST`   | `/api/nginx/start`            | —                            | Start the Nginx container       |
|                         | `POST`   | `/api/nginx/stop`             | —                            | Stop the Nginx container        |
|                         | `POST`   | `/api/nginx/restart`          | —                            | Restart the Nginx container     |
|                         | `POST`   | `/api/nginx/reload`           | —                            | Reload Nginx configuration      |
| **🌍 Virtual Hosts**    | `POST`   | `/api/virtual-hosts`          | `{ "domain": "test.local" }` | Create a new virtual host       |
|                         | `DELETE` | `/api/virtual-hosts/{domain}` | —                            | Delete an existing virtual host |


# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

KP-Penelitian-Dosen is a PHP web application for managing and displaying lecturer research data at UNIKOM. It scrapes and displays research publications, author information, and SINTA scores.

## Tech Stack

- **Backend**: PHP 7.4+ (custom MVC framework, no framework)
- **Database**: MySQL 5.7+
- **Frontend**: Plain PHP views, Bootstrap CSS
- **Auth**: Google OAuth + password-based login
- **Deployment**: Docker + Docker Compose

## Common Commands

### Local Development (Laragon/XAMPP)
```bash
# Copy environment file
cp .env.example .env

# Import database schema
mysql -u root -p kp-penelitian-dosen < database/schema.sql
mysql -u root -p kp-penelitian-dosen < database/database_seed.sql
```

### Docker Development
```bash
# Build and run containers
docker-compose up -d --build

# View logs
docker-compose logs -f app

# Stop containers
docker-compose down

# Stop and remove volumes (resets DB)
docker-compose down -v

# Access MySQL in container
docker-compose exec db mysql -u root -p

# Backup database
docker-compose exec db mysqldump -u root -p kp-penelitian-dosen > backup.sql
```

### Access Points
- App: `http://localhost:8080`
- phpMyAdmin: `http://localhost:8081`

## Architecture

### Request Flow

```
public/index.php → Env::load() → config/config.php → Router → Controller → View
```

### Custom MVC Framework

```
public/index.php      → Entry point, loads core files and boots App
app/core/App.php      → Router initialization and dispatch
app/core/Router.php   → Route definition with dynamic params ({id})
app/core/Controller.php → Base controller with view(), render(), model(), redirect()
app/core/Database.php → PDO wrapper with query(), bind(), resultSet(), single()
app/core/Auth.php     → Session-based authentication (Google OAuth + password)
app/core/Env.php      → .env file loader
config/config.php     → Constants (DB_*, BASE_URL, API_*)
routes/web.php        → Route definitions (GET/POST/PUT/DELETE)
```

### Route Pattern

Routes use `Controller@method` syntax with dynamic parameters:

```php
// Static route
$router->get('penelitian', 'PenelitianController@index');

// Dynamic route with {id} parameter
$router->get('penelitian/detail/{id}', 'PenelitianController@detail');

// 404 handler
$router->notFound(function () {
    http_response_code(404);
    echo "404 - Page Not Found";
});
```

### Controller Pattern

Controllers extend `Controller` base class:

```php
class ExampleController extends Controller
{
    public function __construct()
    {
        // Require authentication
        AuthMiddleware::handle();
        $this->auth = new Auth();
    }

    public function index()
    {
        $userModel = $this->model('User');      // Load model
        $data = ['title' => 'Page Title'];
        $this->render('module/action', $data, 'main');  // Render with layout
    }

    public function detail($id)                  // Dynamic param from URL
    {
        // ...
    }
}
```

### Model Pattern

Models use the Database class directly (no ORM):

```php
class Example extends Model
{
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getById($id)
    {
        $this->db->query('SELECT * FROM table WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();     // Returns single object
    }

    public function getAll()
    {
        $this->db->query('SELECT * FROM table');
        return $this->db->resultSet();  // Returns array of objects
    }
}
```

### View Pattern

Views use layouts with `$viewContent` injection:

```php
// In controller
$data = [
    'title' => 'Title',
    'user' => $user,
    'viewContent' => 'module/action',  // Required for layout
    'showNavbar' => true
];
$this->render('module/action', $data, 'main');

// In layouts/main.php
<body>
    <?php if ($showNavbar) require_once 'partials/navbar.php'; ?>
    <?php require_once $viewContent . '.php'; ?>
    <?php require_once 'partials/footer.php'; ?>
</body>
```

### Service Pattern

Services encapsulate external API calls and complex logic:

```php
// app/services/ApiService.php - HTTP client for external APIs
class ApiService
{
    public function request($endpoint, $method = 'GET', $data = null): array
}

// app/services/ReportingPdfService.php - PDF generation
class ReportingPdfService
{
    public function download(array $articles, string $startYear, string $endYear): void
}

// app/services/GoogleAuthService.php - OAuth integration
```

### Helper Functions

```php
// app/helpers/response_helper.php
jsonResponse($payload, $status = 200);  // JSON response with success flag
errorResponse($message, $status = 500, $extra = []);  // JSON error response

// app/helpers/pagination_helper.php
paginate($data, $total, $page, $limit);  // Returns paginated response structure
```

### Middleware Pattern

```php
// app/middleware/AuthMiddleware.php
class AuthMiddleware
{
    public static function handle()
    {
        if (!(new Auth())->check()) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }
}
```

### Session Auth

Auth state stored in `$_SESSION`:
- `$_SESSION['user_id']` - Authenticated user ID
- `$_SESSION['username']`, `$_SESSION['email']`, `$_SESSION['full_name']`

Check auth in controllers: `AuthMiddleware::handle()` or `if (!isset($_SESSION['user_id'])) { redirect to login }`

## Database Schema

Key tables:
- `users` - User accounts (local password or Google OAuth)
- `authors` - Lecturer profiles with SINTA scores
- `articles` - Research publications
- `author_article` - Junction table (many-to-many)
- `scraping_jobs` / `scraping_logs` - Async scraping job tracking

Note: `schema.sql` uses `kp-penelitian-db` but `.env.example` uses `kp-penelitian-dosen`. Match DB_NAME in `.env` to your database name.

## Environment Variables

See `.env.example`:
- `DB_HOST` - `localhost` for local, `db` for Docker
- `DB_USER`, `DB_PASS`, `DB_NAME`
- `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`
- `API_URL`, `API_KEY` - External scraping API
- `APP_NAME`, `BASE_URL`

## Key Features

### Reporting
- `ReportingController` - Filter articles by year range, export to PDF
- `ReportingPdfService` - TCPDF-based PDF generation

### Scraping
- `ScrapingController` - Trigger async scraping jobs, sync authors/articles
- `ScrapingJob` / `ScrapingLog` models - Track job progress
- `ApiService` - External API client with error handling via `ApiException`

### Dashboard
- `DashboardController` - Statistics, charts, filtering by faculty/year

## Deployment

Push to `main` branch triggers GitHub Actions deployment to VPS. See `README-DEPLOYMENT.md` for CI/CD setup.
# Arionkoder

# SECTION 1 - Submission Questions

## Brief Summary of Approach and Architecture Decisions

This project was built with a focus on rapid development and time efficiency, leveraging modern Laravel ecosystem packages to deliver a complete project management solution.

### Dashboard & Admin Interface

**Filament** was chosen as the primary framework for dashboard development. This decision enabled rapid creation of a fully-featured admin interface with minimal custom code. Filament's server-driven UI approach allowed for quick implementation of CRUD operations, resource management, and user interfaces without extensive frontend development.

### Comments & Notifications System

The **Commentions plugin from Kirschbaum** was selected to handle the entire comments system with mentions and notifications. This plugin provides a comprehensive solution that includes:
- Comment threading and replies
- User mentions functionality
- Integrated notification system
- Subscription-based comment feeds

This single package eliminated the need to build a custom commenting system, saving significant development time while providing robust, production-ready functionality.

### API Authentication

**Laravel Sanctum** with personal access tokens was implemented for API authentication. Rather than implementing OAuth2.0, personal tokens generated from the admin user interface were chosen for:
- Quick implementation and testing
- Simplified token generation process
- Direct integration with Filament's admin interface
- Reduced complexity for time-sensitive project delivery

This approach provides secure API access while maintaining development velocity.

### API Resource Generation

The **Rupadana Filament API Service** package was integrated to automatically generate RESTful API endpoints from existing Filament resources. This package:
- Maintains code consistency between Filament resources and API endpoints
- Follows Laravel API best practices and standards
- Eliminates duplicate code between admin interface and API
- Provides a well-structured API collection that complements Filament resources

### Core Plugins & Utilities

**Spatie Laravel Permission** and **Spatie Laravel Activity Log** are mandatory plugins in every application built, providing:
- **Permissions**: Flexible role and permission management system for controlling access and status
- **Activity Logs**: Comprehensive tracking of all user actions and system events

These plugins offer comfort and ease of integration, making it straightforward to implement robust access control and audit trails throughout the application.

### Architecture Philosophy

The architecture prioritizes:
- **Rapid Development**: Leveraging well-maintained packages to reduce custom code
- **Code Reusability**: Using packages that integrate seamlessly with each other
- **Maintainability**: Following Laravel and package conventions for easier long-term maintenance
- **Time Efficiency**: Choosing solutions that provide maximum functionality with minimal implementation time

## Any assumptions you made

### Task Dependencies
A task dependency table was not implemented. Instead, a parent-child relationship is established using a `task_id` column in the tasks table. This design choice reflects the decision to support only single-parent task hierarchies (one parent, multiple children) rather than complex many-to-many dependencies.

### Database Naming Conventions
The `project_members` table was renamed to `project_user` to align with Laravel's naming conventions:
- Use singular resource names
- Maintain alphabetical ordering in pivot table names
- Avoid the need for database aliases

### Authentication & Authorization
The application leverages Filament's built-in authentication and authorization system for user management and access control.

## What you would improve given more time

### The following improvements are planned for future releases:

- Add password confirmation field in user edit forms
- Implement metrics dashboard on the homepage
- Add Kanban-style task board in Project View
- Using Laravel Echo for real time notifications
- Add slugs for resources instead of using ID in the URL

## Challenges you encountered and how you overcame them

The development was straightforward, with no major challenges encountered. The primary constraint was time, and the strategy to overcome this was to rely heavily on well-maintained plugins and packages rather than building custom solutions from scratch.

By leveraging packages like Filament, Commentions, Rupadana API Service, and Spatie's permission/activity log packages, most time-consuming tasks were handled by these battle-tested solutions. This approach allowed for rapid development while maintaining code quality and following Laravel best practices. The plugin-based architecture proved to be an effective strategy for delivering a complete, production-ready application within the project timeline.

## Reference to any patterns or practices you applied

The application follows standard Laravel conventions and design patterns to ensure maintainability and code quality. Custom traits (`ActivityLog`, `NotifiesProjectManager`) promote code reusability, while PHP 8 Enums (`TaskPriority`, `TaskStatus`, `ProjectStatus`, `ProjectUserRole`) provide type safety. The codebase implements the Service, Handler, and Transformer patterns for API operations, ensuring clear separation of concerns between business logic, data transformation, and presentation layers.

Laravel best practices are consistently applied throughout: Eloquent relationships use explicit return type hints and eager loading to prevent N+1 queries, Form Request classes handle validation, and models leverage Soft Deletes for logical deletion. The application follows Laravel 12's streamlined structure with service providers in `bootstrap/providers.php`, auto-registered commands, and casts defined in methods. Asynchronous processing via queues handles notifications, improving application responsiveness.

The architecture adheres to SOLID principles with single-responsibility classes, extensible traits and interfaces, and proper dependency injection. Package integration follows each package's conventions (Spatie Permission/Activity Log, Filament resources, Commentions contracts), ensuring seamless functionality while maintaining code consistency and following industry standards.

# SECTION 2 - Configuration

## Notification System

Notifications are processed asynchronously through Laravel's queue system. To enable notifications:

1. Start the queue worker:
   ```bash
   sail artisan queue:work
   ```

Notifications are automatically sent to project managers when:
- A project or task is created by a user other than the manager
- A project or task is edited by a user other than the manager
- When user is mentioned in a comment
- If user is subscribed to a project / task comment notification feed.

Both administrators and project members can trigger notifications when modifying projects or tasks.

## API Configuration

The application uses **Laravel Sanctum** for API authentication, integrated with the `rupadana-api-service` plugin to automatically generate RESTful API resources for Filament models.

### Generating API Tokens

To generate an API token for an admin user with full privileges:

```bash
sail artisan api:token
```

### Available Resources

The API provides standard REST endpoints for the following resources:
- Users
- Organizations
- Projects
- Tasks

### API Endpoints

All resources follow the standard REST API pattern:

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/{resource}` | Returns paginated collection |
| `GET` | `/api/{resource}/{id}` | Returns single resource |
| `POST` | `/api/{resource}` | Creates new resource |
| `PUT` | `/api/{resource}/{id}` | Updates existing resource |
| `DELETE` | `/api/{resource}/{id}` | Deletes resource |

### Authentication

Include the generated token in the `Authorization` header as a Bearer token:

```bash
curl --location 'http://laravel.test/api/users' \
  --header 'Authorization: Bearer YOUR_GENERATED_TOKEN'
```

## Deployment (Local)

### Prerequisites

Before setting up the project locally, ensure you have the following installed:

- **Docker Desktop** (required for Laravel Sail)
- **Git** (to clone the repository)

Laravel Sail provides a Docker-based development environment that includes PHP, MySQL, and all necessary services.

### Step 1: Clone the Repository

```bash
git clone https://github.com/manojo123/arionkoder.git (Repo will be public for 1 month or after confirmation)
cd arionkoder
```

### Step 2: Set Up Environment File

```bash
cp .env.example .env
```

The default Sail configuration will work out of the box. No need to modify database settings unless you have specific requirements.

### Step 3: Install PHP Dependencies

Since the `vendor` folder is not included in the repository, we need to install Composer dependencies first. We'll use Docker to run Composer in a temporary container:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    composer:latest \
    composer install --ignore-platform-reqs
```

This will install all PHP dependencies including Laravel Sail.

### Step 4: Start Sail

Now that Sail is installed, start the containers:

```bash
./vendor/bin/sail up -d
```

This will start MySQL, Mailpit (for email testing), and the Laravel application.

### Step 5: Install Node Dependencies

```bash
./vendor/bin/sail npm install
```

### Step 6: Generate Application Key

```bash
./vendor/bin/sail artisan key:generate
```

### Step 7: Run Migrations and Seed Database

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

This will create the database schema and seed default roles and users.
The migrations and seeders by default will create three users for you (username / password):

- **admin:** admin@example.com / password
- **manager:** manager@example.com / password
- **member:** member@example.com / password

### Optional Dummy Data
To populate the database with sample data for testing purposes:

```bash
php artisan db:seed DummyDataSeeder
```

### Step 8: Build Frontend Assets
```bash
./vendor/bin/sail npm run build
```

### Step 9: Start Queue Worker

In a separate terminal, start the queue worker for notifications:

```bash
./vendor/bin/sail artisan queue:work
```

### Step 10: Access the Application

- **Application:** http://localhost
- **Mailpit (Email Testing):** http://localhost:8025

### Running Tests

```bash
./vendor/bin/sail pest
```

## Deployment (Production)

### AWS Deployment Guide

This guide covers deploying the Arionkoder application to AWS using Elastic Beanstalk, the simplest deployment option.

#### Prerequisites

- AWS Account with appropriate permissions
- AWS CLI installed and configured
- Python 3.x (for EB CLI)

#### Step 1: Install EB CLI

```bash
pip install awsebcli --upgrade --user
```

Add EB CLI to your PATH (add to `~/.bashrc` or `~/.zshrc`):
```bash
export PATH=$PATH:~/.local/bin
```

#### Step 2: Initialize Elastic Beanstalk

```bash
eb init -p "PHP 8.4 running on 64bit Amazon Linux 2023" arionkoder --region us-east-1
```

Follow the prompts to configure your AWS credentials and region.

#### Step 3: Create RDS Database

1. Go to AWS RDS Console and create a MySQL 8.0 database instance
2. Note the endpoint, database name, username, and password
3. Configure the security group to allow MySQL (port 3306) from your Elastic Beanstalk environment

#### Step 4: Create Environment Configuration

Create `.ebextensions/01-environment.config`:

```yaml
option_settings:
  aws:elasticbeanstalk:application:environment:
    APP_ENV: production
    APP_DEBUG: false
    APP_KEY: "base64:YOUR_APP_KEY_HERE"
    DB_CONNECTION: mysql
    DB_HOST: your-rds-endpoint.region.rds.amazonaws.com
    DB_DATABASE: arionkoder
    DB_USERNAME: your_db_user
    DB_PASSWORD: your_db_password
    QUEUE_CONNECTION: database
    CACHE_DRIVER: file
    SESSION_DRIVER: file
    MAIL_MAILER: smtp
```

Replace the placeholder values with your actual RDS credentials. Generate `APP_KEY` using:
```bash
php artisan key:generate --show
```

#### Step 5: Create Procfile

Create `Procfile` in the root directory:

```
web: vendor/bin/heroku-php-apache2 public/
queue: php artisan queue:work --tries=3 --timeout=90
```

#### Step 6: Deploy

```bash
eb create arionkoder-production
```

This will create the environment and deploy your application. The first deployment may take 10-15 minutes.

#### Step 7: Run Migrations and Seed Database

After deployment, SSH into your environment and run:

```bash
eb ssh
php artisan migrate --force --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Step 8: Set Up Queue Worker

Elastic Beanstalk will automatically run the queue worker defined in your `Procfile`. You can monitor it in the AWS Console under your environment's logs.

#### Step 9: Configure Custom Domain (Optional)

1. Go to your Elastic Beanstalk environment in AWS Console
2. Click "Configuration" → "Load balancer"
3. Add a listener for HTTPS (port 443)
4. Request an SSL certificate from AWS Certificate Manager
5. Associate the certificate with your load balancer

#### Updating Your Application

To deploy updates:

```bash
eb deploy
```

To view logs:

```bash
eb logs
```

To SSH into your environment:

```bash
eb ssh
```

### Docker Deployment

The project includes Docker configuration files for containerized deployments.

#### Using Docker Compose (Production)

1. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```

2. **Update `.env` with production values:**
   - Database credentials
   - Application key
   - Queue configuration
   - Cache and session drivers

3. **Build and start services:**
   ```bash
   docker-compose -f docker-compose.prod.yml up -d --build
   ```

4. **Run migrations:**
   ```bash
   docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force
   ```

5. **Seed database:**
   ```bash
   docker-compose -f docker-compose.prod.yml exec app php artisan db:seed --force
   ```

6. **Optimize application:**
   ```bash
   docker-compose -f docker-compose.prod.yml exec app php artisan config:cache
   docker-compose -f docker-compose.prod.yml exec app php artisan route:cache
   docker-compose -f docker-compose.prod.yml exec app php artisan view:cache
   ```

#### Using Dockerfile Standalone

Build and run the application using the Dockerfile:

```bash
# Build image
docker build -t arionkoder:latest .

# Run container
docker run -d \
  --name arionkoder \
  -p 80:80 \
  -e APP_ENV=production \
  -e DB_HOST=your-db-host \
  -e DB_DATABASE=arionkoder \
  -e DB_USERNAME=your_user \
  -e DB_PASSWORD=your_password \
  arionkoder:latest
```

See `Dockerfile` and `docker-compose.prod.yml` for detailed configuration options.

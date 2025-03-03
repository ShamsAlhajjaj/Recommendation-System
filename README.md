# Laravel Recommendation System

A recommendation system built with Laravel that suggests relevant content to users based on their preferences and behavior.

## Features

- User authentication and profile management
- Article browsing and interaction (view, like)
- Personalized content recommendations based on user behavior
- Admin panel for content and user management
- Caching for improved performance

## Design Patterns

### Repository Pattern

The application uses the Repository pattern to abstract the data layer from the business logic:

- **ArticleRepositoryInterface** and **ArticleRepository**: Handle CRUD operations for articles
- **RecommendationRepositoryInterface** and **RecommendationRepository**: Handle recommendation storage and retrieval
- **InteractionRepositoryInterface** and **InteractionRepository**: Handle user interactions with content

Benefits:
- Separation of concerns
- Improved testability
- Consistent data access layer
- Easier to switch data sources if needed

### Service Pattern

The application uses the Service pattern to encapsulate complex business logic:

- **RecommendationService**: Contains the recommendation algorithm and logic

Benefits:
- Keeps controllers thin
- Reusable business logic
- Easier to test complex algorithms

### Observer Pattern

The application uses Laravel's Observer pattern to handle events:

- **InteractionObserver**: Generates recommendations when a user interacts with content
- **ArticleObserver**: Clears caches when articles are created, updated, or deleted

Benefits:
- Decouples event handling from business logic
- Automatically triggers actions based on model events
- Keeps the codebase clean and maintainable

## Performance Optimizations

- **Caching**: Extensive use of Laravel's caching system to store:
  - User recommendations
  - Article lists
  - User interaction history
  
- **Cache Invalidation**: Smart cache invalidation using observers to ensure data is always fresh

- **Database Optimization**:
  - Proper indexing on frequently queried columns
  - Eager loading of relationships to prevent N+1 query problems

## Installation

1. Clone the repository:
```bash
git clone https://github.com/ShamsAlhajjaj/Recommendation-System.git
cd recommendation-system
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in the .env file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recommendation_system
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Compile assets:
```bash
npm run dev
```

8. Start the server:
```bash
php artisan serve
```

## Usage

### User Side

1. Register/Login to the application
2. Browse articles
3. View and like articles
4. Visit the recommendations page to see personalized content

### Admin Side

1. Login to the admin panel at `/admin/login`
2. Manage articles, categories, and users
3. View user activity and interactions

## Routes

### Authentication Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/login` | Show login form |
| POST | `/login` | Process login |
| POST | `/logout` | Logout user |
| GET | `/register` | Show registration form |
| POST | `/register` | Process registration |
| GET | `/forgot-password` | Show password reset request form |
| POST | `/forgot-password` | Process password reset request |
| GET | `/reset-password/{token}` | Show password reset form |
| POST | `/reset-password` | Process password reset |

### User Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/dashboard` | User dashboard (article listing) |
| GET | `/profile` | Show user profile |
| PATCH | `/profile` | Update user profile |
| DELETE | `/profile` | Delete user account |
| GET | `/recommendations` | Show personalized recommendations |

### Article Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/articles/{article}` | Show article details |
| GET | `/articles/{article}/view` | Record article view |
| POST | `/articles/{article}/like` | Toggle article like |

### Admin Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/admin/login` | Admin login page |
| POST | `/admin/login` | Process admin login |
| POST | `/admin/logout` | Admin logout |
| GET | `/admin/dashboard` | Admin dashboard |

#### Admin Article Management

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/admin/articles` | List all articles |
| GET | `/admin/articles/create` | Show article creation form |
| POST | `/admin/articles` | Create new article |
| GET | `/admin/articles/{article}/edit` | Show article edit form |
| PUT | `/admin/articles/{article}` | Update article |
| DELETE | `/admin/articles/{article}` | Delete article |

#### Admin Category Management

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/admin/categories` | List all categories |
| GET | `/admin/categories/create` | Show category creation form |
| POST | `/admin/categories` | Create new category |
| GET | `/admin/categories/{category}/edit` | Show category edit form |
| PUT | `/admin/categories/{category}` | Update category |
| DELETE | `/admin/categories/{category}` | Delete category |

#### Admin User Management

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/admin/users` | List all users |
| GET | `/admin/users/create` | Show user creation form |
| POST | `/admin/users` | Create new user |
| GET | `/admin/users/{user}/edit` | Show user edit form |
| PUT | `/admin/users/{user}` | Update user |
| DELETE | `/admin/users/{user}` | Delete user |
| GET | `/admin/users/{user}/activity` | View user activity |


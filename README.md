# Laravel Todo API

A simple Todo API project implemented using Laravel. This project allows users to create and manage tasks, with features including authentication, task creation, task completion, and real-time status updates across devices using broadcasting. Tasks automatically complete after two days.

## Installation

This project uses Laravel Sail for easy Docker-based deployment. To get started:

1. Clone the repository:
   ```bash
   git clone https://github.com/skhammari/heli-technology-assignment
   ```
2. Navigate into the project directory:
   ```bash
   cd heli-technology-assignment
   ```
3. Start Laravel Sail (Docker required):
   ```bash
   ./vendor/bin/sail up
   ```
4. Run migrations to set up the database:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

## Postman collection

postman collection file is available.

## API Endpoints

### Authentication

- **Sign Up**: `POST /api/auth/signup` - Register a new user with email and password.
- **Login**: `POST /api/auth/login` - Authenticate a user and retrieve a token.

### Tasks

- **List All Tasks**: `GET /api/task/all` - Retrieve all tasks for the authenticated user.
- **Create New Task**: `POST /api/task/new` - Create a new task for the authenticated user.
- **Complete a Task**: `POST /api/task/complete` - Mark a task as completed for the authenticated user.

## Technologies

- **Backend**: Laravel
- **Authentication**: Laravel Sanctum
- **Broadcasting**: Pusher
- **Containerization**: Docker via Laravel Sail
- **Database**: MySQL (configurable)

## Broadcasting Setup

To enable real-time broadcasting of task status updates, configure your Pusher credentials in your `.env` file as per the Laravel documentation.

## Background Task Completion

Tasks are automatically marked as complete after two days using Laravel's task scheduling. Ensure to set up a Cron job to trigger Laravel's scheduler.

## Next Steps

- **Write tests**
- **Provide swagger documentation**

## Contributing

Contributions, issues, and feature requests are welcome!

# API Documentation
 
Welcome to API documentation. This document provides information about available resources, methods, and request and response formats.

&nbsp;

# API Requests

## Authentication

### Registration (POST /api/register)

#### Request:

<pre>
{
  "name": "Your Name",
  "email": "your.email@example.com",
  "password": "your_password",
  "password_confirmation": "your_password"
}
</pre>

#### Response:

<pre>
{
    "success": true,
    "data": {
        "token": "your_token",
        "name": ""Your Name"
    },
    "message": "User register successfully"
}
</pre>

### Authorization (POST /api/login)

#### Request:

<pre>
{
  "email": "your.email@example.com",
  "password": "your_password"
}
</pre>

#### Response:

<pre>
{
    "success": true,
    "data": {
        "token": "your_token",
        "name": "your_name"
    },
    "message": "User logged in successfully"
}
</pre>

&nbsp;

## Tasks (Need bearer token)

### Getting a list of all tasks (GET /api/tasks)

#### Response:

<pre>
{
    "tasks": [
        {
            "id": 1,
            "user_id": 1,
            "title": "Test Title 1",
            "description": "Test Desc 1",
            "status": "pending",
            "created_at": "2024-02-23T19:38:49.000000Z",
            "updated_at": "2024-02-23T19:38:49.000000Z"
        },
        {
            "id": 2,
            "user_id": 1,
            "title": "Test Title 2",
            "description": "Test Desc 2",
            "status": "pending",
            "created_at": "2024-02-23T19:40:29.000000Z",
            "updated_at": "2024-02-23T19:40:29.000000Z"
        },
        {
            "id": 4,
            "user_id": 3,
            "title": "Test Title 4",
            "description": "Test Desc 4",
            "status": "completed",
            "created_at": "2024-02-23T19:42:04.000000Z",
            "updated_at": "2024-02-23T19:42:22.000000Z"
        }
    ]
}
</pre>

### Getting a task by ID (GET /api/tasks/task/{taskId})

#### Response:

<pre>
{
    "task": {
        "id": 1,
        "user_id": 1,
        "title": "Test Title 1",
        "description": "Test Desc 1",
        "status": "pending",
        "created_at": "2024-02-23T19:38:49.000000Z",
        "updated_at": "2024-02-23T19:38:49.000000Z"
    }
}
</pre>

### Creating a new task (POST /api/tasks/task/create)

#### Request:

<pre>
{
  "title": "New Task",
  "description": "Description for New Task"
}
</pre>

#### Response:

<pre>
{
  "task": {
    "id": 2,
    "user_id": 1,
    "title": "New Task",
    "description": "Description for New Task",
    "status": "pending",
    "created_at": "2024-02-23T23:10:12Z",
    "updated_at": "2024-02-23T23:10:12Z"
  },
  "message": "Task created successfully"
}
</pre>

### Updating a task (PUT /api/tasks/update/{taskId})

#### Request:

<pre>
{
  "title": "Updated Task",
  "description": "Updated description",
  "status": "completed"
}
</pre>

#### Response:

<pre>
{
  "task": {
    "id": 2,
    "user_id": 1,
    "title": "Updated Task",
    "description": "Updated description",
    "status": "completed",
    "created_at": "2024-02-23T23:10:12Z",
    "updated_at": "2024-02-23T23:15:30Z"
  },
  "message": "Task updated successfully"
}
</pre>

### Deleting a task (DELETE /api/tasks/delete/{taskId})

#### Response:

<pre>
{
  "message": "Task deleted successfully"
}
</pre>

### Get your task (GET /api/tasks/user_tasks)

#### Response:

<pre>
{
    "tasks": [
        {
            "id": 1,
            "user_id": 1,
            "title": "Test Title 5",
            "description": "Test Desc 5",
            "status": "completed",
            "created_at": "2024-02-23T19:38:49.000000Z",
            "updated_at": "2024-02-23T23:54:27.000000Z"
        },
        {
            "id": 2,
            "user_id": 1,
            "title": "Test Title 2",
            "description": "Test Desc 2",
            "status": "pending",
            "created_at": "2024-02-23T19:40:29.000000Z",
            "updated_at": "2024-02-23T19:40:29.000000Z"
        },
        {
            "id": 9,
            "user_id": 1,
            "title": "Task 1",
            "description": "Description for Task 1",
            "status": "pending",
            "created_at": "2024-02-23T22:55:34.000000Z",
            "updated_at": "2024-02-23T22:55:34.000000Z"
        }
    ]
}
</pre>

&nbsp;

## Users (Need bearer token)

### Getting a list of all users (GET /api/users)

#### Response:

<pre>
{
    "users": [
        {
            "id": 5,
            "name": "Jane Doe",
            "email": "jane.doe@example.com",
            "email_verified_at": null,
            "created_at": "2024-02-23T22:54:14.000000Z",
            "updated_at": "2024-02-23T22:54:14.000000Z"
        },
        {
            "id": 4,
            "name": "John Doe",
            "email": "john.doe@example.com",
            "email_verified_at": null,
            "created_at": "2024-02-23T22:54:14.000000Z",
            "updated_at": "2024-02-23T22:54:14.000000Z"
        },
        {
            "id": 3,
            "name": "someName",
            "email": "someEmail@gmail.com",
            "email_verified_at": null,
            "created_at": "2024-02-23T21:27:01.000000Z",
            "updated_at": "2024-02-23T21:27:01.000000Z"
        },
        {
            "id": 1,
            "name": "VranT",
            "email": "vrant@gmail.com",
            "email_verified_at": null,
            "created_at": "2024-02-23T19:36:13.000000Z",
            "updated_at": "2024-02-23T19:36:13.000000Z"
        }
    ]
}
</pre>

### Getting a user by ID (GET /api/users/user/{userId})

#### Response:

<pre>
{
  "user": {
    "id": 1,
    "name": "User 1",
    "email": "user1@example.com",
    "created_at": "2024-02-23T22:55:34Z",
    "updated_at": "2024-02-23T22:55:34Z"
  }
}
</pre>

### Creating a new user (POST /api/users/user/create)

#### Request:

<pre>
{
  "name": "New User",
  "email": "new.user@example.com",
  "password": "new_password",
  "password_confirmation": "new_password"
}
</pre>

#### Response:

<pre>
{
  "user": {
    "id": 2,
    "name": "New User",
    "email": "new.user@example.com",
    "created_at": "2024-02-23T23:10:12Z",
    "updated_at": "2024-02-23T23:10:12Z"
  },
  "message": "User created successfully"
}
</pre>

### User update (PUT /api/users/update/{userId})

#### Request:

<pre>
{
  "name": "Updated User",
  "email": "updated.user@example.com",
  "password": "updated_password",
  "password_confirmation": "updated_password"
}
</pre>

#### Response:

<pre>
{
  "user": {
    "id": 2,
    "name": "Updated User",
    "email": "updated.user@example.com",
    "created_at": "2024-02-23T23:10:12Z",
    "updated_at": "2024-02-23T23:15:30Z"
  },
  "message": "User updated successfully"
}
</pre>

### Delete a user (DELETE /api/users/delete/{userId})

#### Response:

<pre>
{
  "message": "User deleted successfully"
}
</pre>

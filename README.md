Fahras 

Overview

Fahras API is a RESTful API for managing a bookstore. It enables users to perform comprehensive CRUD operations on books, facilitates user authentication, and provides advanced search functionalities..

---------------------------------

Features

User Authentication: Secure login and registration processes with role-based access control (Admin/User).
Book Management: Full CRUD operations for books, allowing easy management of your inventory.
Search Functionality: Efficiently search for books by title, author, or ISBN.
API Documentation: Comprehensive and well-structured documentation for all API operations.
Validation and Error Handling:validation with meaningful error messages.

---------------------------------

Technology Stack

Backend Framework: Laravel (latest version)
Database: MySQL
Search Engine: Elasticsearch
Containerization: Docker
CI/CD: GitHub 

---------------------------------

Prerequisites

PHP (latest version)
Composer
MySQL
Docker
Elasticsearch

---------------------------------

Setup Instructions

1. Local Development Setup
Clone the Repository using Git:

```
git clone https://github.com/yourusername/fahras-api.git
```
```
cd fahras/fahras-api
```

3. Install Dependencies using Composer:
```
composer install
```
```
npm install
```

4. Configure Environment Variables:
Copy the .env.fahras file to .env:
```
cp .env.fahras .env
```

Update the .env file with your database credentials and other necessary configurations.

5. Run Migrations:
```
php artisan migrate
```

7. Run Seeders:
```
php artisan db:seed BookSeeder
```

9. Run the Application:
```
php artisan serve
```

---------------------------------

Docker Setup

1. Build Docker Containers:
```
docker-compose up -d --build
```

3. Run Migrations in Docker:
```
docker-compose exec laravel.test artisan migrate
```

---------------------------------

API Documentation

The Fahras API follows RESTful conventions. Below are the main endpoints available:

Authentication

Login: POST /api/login
Register: POST /api/register

Book Management

List Books: GET /api/books
Add Book: POST /api/books
Update Book: PUT /api/books/{id}
Delete Book: DELETE /api/books/{id}

Elasticsearch

Create Index: PUT localhost:9200/index_name
Add Documant to Index: POST localhost:9200/index_name/doc
Search Queiries: GET localhost:9200/index_name/_search

-Authentication

Login

Endpoint: POST /api/login

Request Body:
```
{
    "email": "nour@gmail.com",
    "password": "yourpassword"
}
```

Response:
```
{
    "status": true,
    "user": {
        "id": 1,
        "name": "nour",
        "email": "nour@gmail.com",
        "password": "$2y$12$eo5zjW3ncancoXqRKmVOo.xlUPd5s.IG6rXa0SxS6EcFsWnq14dny",
        "c_password": "$2y$12$/rsmbHnH4IHGGEgfeiEYTuhlLuna1zFuZIu72OzyiLJwUNFHqnr4y",
        "role": "admin",
        "remember_token": null,
        "created_at": "2024-10-20T11:43:29.000000Z",
        "updated_at": "2024-10-20T11:43:29.000000Z"
    },
    "token": "3|TWY4TOto92rOAnZ3FltOeCw6zNsQpfQ3GzUadkSM2d13df23"
}
```

Register

Endpoint: POST /api/register

Request Body:
```
{
    "name": "nour",
    "email": "nour@gmail.com",
    "password": "yourpassword"
}
```

Response:
```
{
    "status": true,
    "message": "User created successfully",
    "role": "admin",
    "access_token": "2|xbGla8BvugNifATF7U70lYEakEwAU5XaPaetYeSVdfdee318",
    "token_type": "Bearer"
}
```

-Books

List Books

Endpoint: GET /api/books

Response:
```
[
    {
        "id": 1,
        "title": "Book Title",
        "author": "Author Name",
        "isbn": "1234567890"
    },
    ...
]
```

Add Book

Endpoint: POST /api/books

Request Body:
```
{
    "title": "New Book Title",
    "author": "New Author",
    "isbn": "0987654321"
}
```

Response:
```
{
    "message": "Book added successfully",
    "book": {
        "id": 2,
        "title": "New Book Title",
        "author": "New Author",
        "isbn": "0987654321"
    }
}
```

Update Book

Endpoint: PUT /api/books/{id}

Request Body:
```
{
    "title": "Updated Book Title",
    "author": "Updated Author",
    "isbn": "1234567890"
}
```

Response:
```
{
    "message": "Book updated successfully",
    "book": {
        "id": 1,
        "title": "Updated Book Title",
        "author": "Updated Author",
        "isbn": "1234567890"
    }
}
```

Delete Book


Endpoint: DELETE /api/books/{id}

Response:
```
{
    "message": "Book deleted successfully"
}
```

-Elasticsearch

Create Index

Endpoint: PUT localhost:9200/index_name

Response:
```
{
    "acknowledged": true,
    "shards_acknowledged": true,
    "index": "index_name"
}
```

Add Documant to Index

Endpoint: POST localhost:9200/index_name/doc

Request Body:
```
{
        "title": "elastic search",
        "author": "Jordan B. Peterson",
        "image": "https://source.unsplash.com/random",
        "description": "Jordan Peterson weaves together personal anecdotes, intellectual history, and religious imagery into a truly unique book that explores how to live a life full of meaning and purpose.",
        "isbn": "9780735277458"
    }
```
    
Response:
```
{
    "_index": "index_name",
    "_type": "doc",
    "_id": "fHngrJIB6cipaXreVSIG",
    "_version": 1,
    "result": "created",
    "_shards": {
        "total": 2,
        "successful": 1,
        "failed": 0
    },
    "_seq_no": 0,
    "_primary_term": 1
}
```


Search Queiries

Endpoint: GET localhost:9200/index_name/_search

Request Body:
```
{
        "query":{
        "query_string":{
            "query":"jordan"
        
        }

        }
}
```


Response:
```
{
    "took": 23,
    "timed_out": false,
    "_shards": {
        "total": 1,
        "successful": 1,
        "skipped": 0,
        "failed": 0
    },
    "hits": {
        "total": {
            "value": 1,
            "relation": "eq"
        },
        "max_score": 0.2876821,
        "hits": [
            {
                "_index": "index_name",
                "_type": "doc",
                "_id": "e3nSrJIB6cipaXreeCJ9",
                "_score": 0.2876821,
                "_source": {
                    "title": "elastic search",
                    "author": "Jordan B. Peterson",
                    "image": "https://source.unsplash.com/random",
                    "description": "Jordan Peterson weaves together personal anecdotes, intellectual history, and religious imagery into a truly unique book that explores how to live a life full of meaning and purpose.",
                    "isbn": "9780735277458"
                }
            }
        ]
    }
}
```

---------------------------------

Contributing

Contributions are welcome!

---------------------------------

Acknowledgements

Laravel: The PHP framework utilized for this project.
MySQL: The database management system employed.
Elasticsearch: The search engine integrated for enhanced search capabilities.
Docker: Used for containerization, ensuring consistent environments across development and production.

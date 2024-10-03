# Symfony Message Encryption with Docker

This project is a Symfony-based application that allows users to securely share encrypted messages with colleagues. The application includes features for creating encrypted message, and remove after being read once or after a an expiration period. It is set up using Docker for easy deployment and includes a cron job for automatically removing expired messages.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Versions](#versions)
- [Installation](#installation)
- [Usage](#usage)
- [Cron Job](#cron-job)

## Features

- Generate encrypted messages securely.
- Set 10 mins of expiry for messages:
    - Read once, then delete.
    - Delete after a specified period.
- Easily identify messages using unique identifiers.
- Use decryption keys for reading messages.
- Automatically remove expired messages using cron jobs.

## Technologies Used

- **Symfony**: PHP framework for building web applications.
- **Docker**: Containerization platform for easy deployment.
- **MySQL**: Database for storing messages.
- **OpenSSL**: For encrypting and decrypting messages.

## Versions

- **PHP**: 8.2
- **Symfony**: 6.4
- **MySQL** 8

## Installation

To set up the project locally, follow these steps:

1. **Clone the repository:**
   ```git clone git@github.com:mshende-project/secret-message.git```
   
2. **Go to**
   ```cd symfony-message```

3. **Build and run docker containers**
    ```docker compose up -d --build```
   
4. **Project can be accessed at**
    ```http://localhost/```
   
## Database access
The database can be accessed at
```http://localhost:8081/```
   
## Usage
1. To generate encrypted message add text and recipient, you will get indentifier and decryption key which will be required to read message.
2. To read message go to ``http://localhost/message/read`` enter details and you will see the decrypted message.

## Command to remove expired message which are unread
   To manually remove unread expired messages, you can run the following command:

   ```php bin/console app:clean-expired-messages```
    
## Cron job
A cron job is set up inside the Docker container to automatically execute the clean-expired-messages command, ensuring that expired messages are regularly removed without manual intervention.

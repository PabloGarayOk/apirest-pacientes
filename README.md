# REST API – Patients Management (PHP)

This project is a RESTful API built with **PHP and Object-Oriented Programming (OOP)**.  
It was created as a learning project to understand how APIs are designed, consumed, and secured using token-based authentication.

The API is currently **online and running**, and it is also consumed by a **Vue.js dashboard** implemented in a separate repository: **AplicacionVueJs**.

**Live API endpoint:**  
https://apirest.pablogaray.com.ar

---

## Proyect overview

**Role:** Backend Developer (PHP)  
**Type:** REST API  
**Status:** Completed

---

##  Project Purpose

This project was developed to learn:

- How a REST API works internally
- HTTP methods (GET, POST, PUT, DELETE)
- Token-based authentication
- API error handling
- Pagination
- Working with Postman and API testing tools
- Cron jobs for token expiration
- PHP OOP applied to APIs

---

##  Key Concepts Learned

- API authentication with tokens
- Public vs protected endpoints
- Error responses structure
- Handling headers and request bodies
- Basic security concepts
- API consumption from external applications
- Cron jobs for background tasks

---

## Authentication

### POST `/auth`
Authenticate a user and receive an access token.

**Endpoint**  
`POST https://apirest.pablogaray.com.ar/auth.php`

**Body (JSON):**
```json
{
  "user": "user@email.com",
  "pass": "password"
}
```

**Test credentials:**
```json
{
  "user": "hola@pablogaray.com.ar",
  "pass": "123456"
}
```

The API returns a token required to access protected endpoints.

---

## Patients Endpoints

### GET `/pacientes` (Public)
Retrieve patients without authentication.

Examples:

- GET `/pacientes`
- GET `/pacientes.php?page=1`
- GET `/pacientes.php?id=10`

Pagination is enabled (default: 100 records per page).

### POST `/pacientes` (Protected)
Create a new patient.

```json
{
  "dni": "12345678",
  "nombre": "John",
  "apellido": "Doe",
  "genero": "Mas",
  "fechaNacimiento": "1990-01-01",
  "direccion": "Street 123",
  "tel": "123456789",
  "email": "john@email.com",
  "token": "ACCESS_TOKEN"
}
```

### PUT `/pacientes` (Protected)
Update an existing patient.

```json
{
  "pacienteId": "1",
  "nombre": "John",
  "apellido": "Doe",
  "email": "john@email.com",
  "token": "ACCESS_TOKEN"
}
```

### DELETE `/pacientes` (Protected)
**Option 1 – Body**

```json
{
  "pacienteId": "1",
  "token": "ACCESS_TOKEN"
}
```

**Option 2 – Headers**

```json
{
  "Paciente-Id": "1",
  "Token": "ACCESS_TOKEN"
}
```
---

## Error Handling

Errors are returned using a structured JSON response:

```json
{
  "status": "error",
  "result": {
    "error_id": "400",
    "error_msg": "Invalid or incomplete data"
  }
}
```

This approach was chosen to simulate real-world API responses.

----

## Token Expiration (Cron Job)

A cron job runs periodically to invalidate expired tokens.
This simulates how APIs manage session security in production environments.

---

## Database Structure

The project uses MySQL with the following tables:

- `usuarios`
- `usuarios_token`
- `pacientes`

A SQL dump is included to create the database structure.
> Sample data can be added manually for testing purposes.

---

## Configuration

Database credentials are stored in a simple JSON-based config file:

`clases/conexion/config`

This approach was used for learning purposes.
In a production environment, environment variables or `.env` files are recommended.

---

## Password Encryption

Passwords are encrypted using **MD5**, intentionally kept simple for learning purposes.

**MD5 is NOT secure and should never be used in production.**
A future improvement would be migrating to `password_hash()` and `password_verify()`.

---

## Technologies Used

- PHP (OOP)
- MySQL (mysqli)
- Apache (.htaccess)
- JSON
- Postman
- Cron Jobs
- Basic HTML & CSS (API documentation page)

---

## Project Structure

- assets/
	- estilos.css 
- clases/
	- conexion/
		- conexion.php
		- config
	- actualizar_token.php
	- auth.class.php
	- eliminar_token.php
	- pacientes.class.php
	- respuestas.class.php
	- token.class.php
- cron/
	- actualizar_token.php
- auth.php
- ignore.gitignore
- index.php
- pacientes.php
- .htaccess 

---

## Lessons Learned

- Designing APIs with consistent error handling improves frontend integration.
- Token-based authentication requires careful expiration and retry logic.
- Proper documentation significantly reduces onboarding time.

---

## Possible Improvements

- Replace `md5` with `password_hash`
- Migrate from `mysqli` to `PDO`
- Add rate limiting
- Improve CORS handling
- Add API versioning
- Dockerize the project

---

## Author

Pablo Garay  
[Personal website](https://pablogaray.com.ar)


# Project Setup

This repository contains the application and its setup files.

## 1. Database specification

### Database platform

- Database type: Microsoft SQL Server.
- Application database driver: CodeIgniter `sqlsrv`.
- PHP database extensions: `sqlsrv` and `pdo_sqlsrv`.
- Database schema used by the application: `[tam]`.
- Database server version and edition: not specified or pinned by the repository.

### SQL Server connection dependencies in Docker

The following requirements are taken directly from `Dockerfile`:

| Component | Required value | Purpose |
|---|---|---|
| PHP/Apache base image | `php:7.4-apache` | Provides the PHP runtime and Apache web server. |
| Microsoft package feed | Debian 11 Microsoft package feed | Provides the Microsoft SQL Server ODBC package. |
| Unix ODBC build package | `unixodbc-dev` | Provides ODBC headers and libraries required to build SQL Server connectivity support. |
| Microsoft ODBC package | `msodbcsql17` | Provides Microsoft ODBC Driver 17 for SQL Server. |
| PHP extension | PECL `sqlsrv-5.10.1` | Provides the SQL Server PHP driver. |
| PHP extension | PECL `pdo_sqlsrv-5.10.1` | Provides the PDO SQL Server driver. |

The Dockerfile installs the Microsoft ODBC package from the Debian 11 feed but does not specify a minor `msodbcsql17` package version. Builds therefore use the package version currently available from that feed unless the Dockerfile is updated to pin one.

## 2. Initialize the database

From the repository root, run the database scripts in this order against the intended database:

1. `schema_and_seed/schema.sql`
2. `schema_and_seed/seed.sql`

The schema script creates the tables and stored procedures. The seed script adds the lookup and development data.

### Database user permissions

`schema_and_seed/schema.sql` grants table and stored-procedure permissions to `[local_db_user]`. This is a placeholder for local development. Before running the schema, replace `[local_db_user]` in `schema.sql` with the database username required by your environment, and use the same value for `DB_USERNAME` in `.env`.

Run the schema using a database administrator, database owner, object owner, or another principal authorized to issue `GRANT` statements. The application database user receives permissions to use the granted objects; it does not automatically have permission to grant those abilities to other users. Run `schema_and_seed/seed.sql` after `schema.sql` completes.

## 3. Set up and run the application

From the repository root, start the application with:

```powershell
docker compose up --build
```

Open the application at:

```text
https://127.0.0.1:4443/
```

The local container generates a self-signed HTTPS certificate, so the browser may display a certificate warning during development.

Stop the application with:

```powershell
docker compose down
```

Make sure the database is initialized before starting application testing.

## SQL file separation

`schema.sql` contains schema objects and stored procedures. `seed.sql` contains standalone data statements. `INSERT` statements inside stored-procedure definitions remain in `schema.sql` because they are part of the procedure implementation.

## 4. Current system specification

### Application runtime

- Host development environment: Windows with Docker Desktop.
- Container base image: `php:7.4-apache`.
- Application framework: CodeIgniter `3.1.4`.
- Web server: Apache HTTP Server with HTTPS, URL rewriting, headers, and spelling support enabled.
- Application source directory inside the container: `/var/www/html`.
- Upload directory inside the container: `/var/www/upload`.
- Docker Compose service: `web`.
- HTTPS mapping: host port `4443` to container port `443`.
- Source code and upload directories are bind-mounted for local development.

## 5. To-be system specification

- Upgrade PHP from `7.4` to `8.5`.
- Upgrade CodeIgniter from `3.1.4` to `4`.

## 6. Database connection configuration

The self-development database connection is provided by Docker Compose environment variables.

1. Copy `.env.example` to `.env` in the repository root.
2. Enter the SQL Server connection values in `.env`:

   ```text
   DB_HOSTNAME=<sql-server-host-or-ip>
   DB_USERNAME=<sql-server-username>
   DB_PASSWORD=<sql-server-password>
   DB_DATABASE=<database-name>
   DB_DRIVER=sqlsrv
   ```

3. Start the application with:

   ```powershell
   docker compose up --build
   ```

Compose reads `.env` and passes these variables into the web container. The application reads them from `src/public_html/application/config/self-development/database.php` using `getenv()`.

The `.env` file is local-only, is excluded from Git, and must not be committed because it contains credentials. The committed `.env.example` contains placeholders only.

The application now supports only the `self-development` environment. `CI_ENV` defaults to `self-development` in Compose and can be left unchanged for local development.

# Laravel  Quiz Application (based on Laravel 10.x)


```
superadmin login
email: admin@admin.com
password : admin123
```

# Installation

1. **Clone or download this Repository.**
2. **Run the command**
   ```
   composer install

   ```

3. **Create `.env` file by copying the `.env.example`, or run the following command**
   ```
   cp .env.example .env
   ```

4. **Update the database name and credentials in `.env` file**  
   ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE="Your database name"
    DB_USERNAME="your database username"
    DB_PASSWORD="your database password"
   ```
5. **Run the following command**
   ```
   php artisan migrate
   ```
6. **Finally run the application**
   ```
   php artisan serve
   ```


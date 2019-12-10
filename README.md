# Login application

1. Clone repository
    `git clone https://github.com/fureszpeter/loginTest.git`
2. Run composer install
    `composer install`
3. Create database (MySQL)
    - Database name is: `login_test`
    - You can modify connection parameters in `.env` file
4. Run database migration and seeder
    - `php artisan migrate:fresh --seed`
    
# Configuration

The `.env` file is the main configuration file. You need to fill `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` values from Google.

## Captcha

`cartalyst.sentinel.php` contains the configuration and can setup how many attempts are allowed with wrong login.
You can change values by:
 - IP based, 
 - user based or 
 - global based.


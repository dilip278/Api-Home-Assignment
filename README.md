# Rest Api in Php FrameWork(Laravel)
# Setup project on Ubuntu
1. Install Composer
    1. sudo apt update
    2. sudo apt install php-cli unzip
    3. cd ~
    4. curl -sS https://getcomposer.org/installer -o composer-setup.php
    5. HASH=`curl -sS https://composer.github.io/installer.sig`
    6. echo $HASH
    7. Install composer globally (sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer)
2. Create laravel project
    1. sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    2. cd example-app
    3. php artisan serve
3. Generate Migrations
    1. php artisan make:migration create_departments_table / create_employees_table
4. Generate Models
    1. php artisan make:model Department / Employee
5. Generate Controllers
    1. php artisan make:controller ApiController
6. Write Database connection details in env file
7. Run Migrations
    1. php artisan migrate
8. Create Apis
    1. create-employees-details
    2. create-department-details
    3. get-employee-details/{emp_code}
    4. update-employee-details
    5. delete-employee-details/{emp_code}
    6. search-employee-details/{search_value}
9. Create Unit test 
    1. create separate .env.test file for db and app connection details
    2. generate test component for test command(php artisan make:test CompanyTest)
    3. create methods for testing apis in generated test component(method name must start with test)
    4. run test with ./vendor/bin/phpunit      


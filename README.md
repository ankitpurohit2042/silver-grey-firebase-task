## Pre-Requirements

| Module      | Version |
| ----------- | ------- |
| PHP         | 8.1     |
| BCMath      | LTS     |
| Ctype       | LTS     |
| JSON        | LTS     |
| Mbstring    | LTS     |
| OpenSSL     | LTS     |
| PDO         | LTS     |
| Tokenizer   | LTS     |
| XML         | LTS     |
| Node        | 20.9.0  |
| NPM         | 10.1.0  |


``` bash

# To run below command, Copy the environment file

> cp .env.example .env

# Open .env file by any editor nano, gedit, vim

> nano .env

# Before you update the .env file please create a database and link here
- Update DB

    set DB_HOST
    set DB_DATABASE
    set DB_USERNAME
    set DB_PASSWORD

# For further setup, Execute these below commands in order
> COMPOSER_DISABLE_NETWORK=1 && composer install

# some error found in previous command then use this command
> COMPOSER_DISABLE_NETWORK=1 && composer install --ignore-platform-reqs

# after complete previous command without any errors then run this command
> php artisan key:generate

> php artisan migrate

> php artisan db:seed

 # Give permmision to storage folder before link the storage
    # If you are window user then skip this step :)
    
> sudo chmod -R 777 storage 

> php artisan storage:link

> php artisan serve

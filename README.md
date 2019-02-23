# set up
```
// cd into the project
composer install

// change env.example to .env and change things accordingly
// create database for it & install redis
// run the following to migrate
php artisan migrate:fresh

// install laravel valet
// install all the required dev stuff from: https://laravel.com/docs/5.7/valet
composer global require laravel/valet
valet install
valet restart
// goto the upper folder from your project and run
valet park
// now when you visit http://brick_photo.test, you will see the page

// initiate your key with
php artisan passport:client --personal
// and enter Personal Access Client

done!
```
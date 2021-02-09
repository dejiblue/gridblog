[![Build Status](https://travis-ci.com/HenryLab/blog-application-in-Laravel-5.7.svg?branch=master)](https://travis-ci.com/HenryLab/blog-application-in-Laravel-5.7)
# Blog Application in Laravel

HOW TO USE

1, Clone Repo (git clone https://github.com/dejiblue/testblog.git)

2, Run composer install

    If you run into "Undefined Index Script @php artisan package:discover --ansi handling the post-autoload-dump event returned with error code 1", please downgrade your composer to version 1.10 using the following commmand "composer self-update --1" you can update it back after.

3, Run "php artisan migrate"

4, Set up your virtual host on Apache2 or Nginx to point to the public directory of laravel (not really necessary as you can fireup the app by hiting the public directory of laravel)

5, Restart the server

6, Fireup the application



TO RUN A TEST

You can run the below command in the terminal

./vendor/bin/phpunit --filter name_of_test_case

All the test cases can be found tests/Feature/PostTest.php

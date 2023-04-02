CodeInfinity Tests - Installation and Testing Instructions

PHP Environment Setup

The first step is to install PHP and all required dependencies. I initially tried to use PHP8, but the Laravel installer informed me that some of the default prerequisites were not compatible with PHP8. So, I downgraded to PHP7.

These instructions assume that you are running OpenSUSE, other operating systems will require adaptation of these instructions.

Install PHP7:

> sudo zypper install php8 php8-openssl php8-pdo php8-mbstring php8-tokenizer php8-xmlreader php8-xmlwriter php8-ctype php-json php8-sqlite php-composer php7-fileinfo sqlite3

Optionally, for debugging purposes, you may also install sqlitebrowser

> sudo zypper in sqlitebrowser

https://sqlitebrowser.org/dl/

Edit php.ini:

- enable fileinfo, sqlite3

Change the following settings thus:

memory_limit = 2048M
max_execution_time = 36000
post_max_size = 50M
upload_max_filesize = 50M

MongoDB setup instructions here:

https://www.mongodb.com/developer/languages/php/php-setup/

sudo pecl channel-update pecl.php.net

sudo pecl install mongodb

Further reading:

sudo pecl channel-update pecl.php.net

sudo pecl install mongodb

https://en.opensuse.org/MongoDB

https://www.mongodb.com/compatibility/mongodb-laravel-intergration

Note that for both tests, I have explicitly added the vendor directory and the .env files. These should probably be added by a composer command, and I may provide instructions for that in a future version of this document. This was solely because I was under time pressure.

Your environment should look something like this:

> php --version
PHP 7.4.33 (cli) (built: Feb 17 2023 12:00:00) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies

> mongo --version
MongoDB shell version v3.6.8
git version: 6bc9ed599c3fa164703346a22bad17e33fa913e4
OpenSSL version: OpenSSL 1.1.1l  24 Aug 2021 SUSE release 150400.7.28.1
allocator: tcmalloc
modules: none
build environment:
    distarch: x86_64
    target_arch: x86_64

> sqlite3 --version
3.39.3 2022-09-05 11:02:23 4635f4a69c8c2a8df242b384a992aea71224e39a2ccab42d8c0b0602f1e8alt1

> php artisan --version
Laravel Framework 8.83.27

Test 1:

Assuming that you have a new MongoDB database that has never been used:

log into the mongo shell:

> mongo

From inside the shell, execute:

db.createUser({
    user: "root",
    pwd: "password",
    roles: [ "root" ]
})

exit

Log in again:

> mongo --authenticationDatabase admin -u root -p

Execute:

db.createUser({
    user: "test1",
    pwd: "test1.password",
    roles: [ "readWrite", "dbAdmin" ]
})

exit

From the command shell, run:

> cd test1/codeinfinity.test1/

> cd storage/
> mkdir -p framework/{sessions,views,cache}
> chmod -R 775 framework
> cd ..

> php artisan migrate

To run the webserver:

> php artisan serve

Then load the link displayed in this output to load the Add Person Page.

Test 2:

> cd ../..
> cd test2/codeinfinity.test2/

> cd storage/
> mkdir -p framework/{sessions,views,cache}
> chmod -R 775 framework
> cd ..

> php artisan storage:link

> cd /public/
> mkdir {uploads,temp}
> chmod -R 775 .
> cd ../..

Edit .env:

You should only need to change the following environment variable, should look something like this, depending on where you cloned this repo.

CSV_FILEPATH=/home/steven/dev/CodeInfinity/CodeInfinity.Tests/test2/codeinfinity.test2/public/storage/

Run the following three commands, to create a fresh SQLite database:

> php artisan command:touchDatabase

> php artisan migrate

> php artisan command:createNames

NOTE: You will need to run these three commands every time you do a new import, to prevent collisions with unique constraints from previous imports!

To generate and import a 20-line CSV file from the command line:

> php artisan command:generateCsv 20

> php artisan command:importCsv

To run the webserver:

> php artisan serve

Then load the link displayed in this output to load the main entry page.

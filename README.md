# Server status page
A simple, lightweight, modular and automatic server status page.

![Screenshot](/docs/screenshot.png?raw=true)

## Requirements
* A web server (Apache, Nginx...)
* PHP
* PHP-JSON

## Installation
Simply copy those files into your server folder. Then skip to the configuration section

## Configuration

Add the server name into config.php and choose an update method (request if you want to get results at every request or cron if you want to fetch data periodically)

### Tests

Tests are used to retrieve information regarding the status of a server. Edit the file config.json to add them. Check out this page to get started.

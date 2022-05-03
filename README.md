# CS 395 Honors Thesis - Implementing a Secure OAuth 2.0 Client
This repository holds the code for a simple PHP application which implements an OAuth 2.0 client to login into the website using Google API. The purpose is to implement the client using basic tutorials and examine what common security vulnerabilities it has. To accomplish this, I used a tool called OAuthGuard. The tool detected the following two vulnerabilities:

1. Unsafe Token Transfer
2. Vulnerable to CSRF Attack

Through branches of this repository, I will be implementing fixes to these issues. Below, I have included basics command to work and use the application.

## Composer Commands
The following command sets up a Docker container which runs the web server:
 ```docker-compose up web```

The following command runs PHP Composer through Docker and installs/updates packages specified in app/composer.json:
```docker-compose up composer install```


## Github Command Reminders:
This command creates a new branch, so I can create a new feature without changing the main branch:
```git checkout -b [branch-name]```

NOTE: In previous versions of this repository, there is a client secret, but that secret no longer works for this application. If this code to be used by another application, those sections should be populated with the client secret of the registered application.

There are two branches of this repository: the main and the patch branch. The main branch is the application as I first implemented it without considering best practices for preventing vulnerabilities. The patch branch implements recommended preventatives to combat the CSRF attack vulnerability. It has an extra csrf_test with a state parameter in the request to show that the application is no longer vulnerable to the attack. 
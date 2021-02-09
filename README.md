Deepser API
===============

Let's consume the Deepser API ([issues](https://github.com/deepser/api-php/issues))

Deepser is a [help desk software](https://www.deepser.com/) and you can find more information in [Deepser API Docs](https://www.deepser.com/api/)

Installation
------------

This library can be found on [Packagist](https://packagist.org/packages/deepser/api-php).
The recommended way to install this is through [composer](http://getcomposer.org).
We support PHP >=7.0. This library is no longer tested on HHVM.

Run these commands to install composer, the library and its dependencies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar require deepser/api-php
```

You then need to install **one** of the following:
```bash
$ php composer.phar update
```

Or edit `composer.json` and add:

```json
{
    "require": {
        "deepser/api-php": "^1.0.1"
    }
}
```


Example
-------
Login with Basic Authentication
```php
<?php

require 'vendor/autoload.php';

$host = 'https://your.deepser.net';
$username = 'username';
$password = 'password';
// create a deep desk object
\Deepser\Deepser::init($host, $username, $password);

// ...
```
Login with Token Based Authentication
```php
<?php

require 'vendor/autoload.php';

$host = 'https://your.deepser.net';
$username = 'username';
$token = 'mytokenhere';
// create a deep desk object
\Deepser\Deepser::init($host, $token);

// ...
```

Operation (Ticket)
-------

```php
// ...
// load an existing operation by id
$operation = new \Deepser\Entity\Service\Operation();
$operation->load(1000);
//...
// create new operation object
$operation = new \Deepser\Entity\Service\Operation();
$operation->setTitle('My new ticket');
$operation->setDescription('can you help me?');
$operation->setType(123);
$operation->save();

````

User
-------

```php
// ...
// load an existing user by id
$user = new \Deepser\Entity\User();
$user->load(600);

// load user by username
$user = new \Deepser\Entity\User();
$user->load('myusername', 'username');

//...
// load user collection
$userCollection = \Deepser\Entity\User::getCollection();
$userCollection->addFilter('company_id', 'eq', 123);
foreach($userCollection as $user){
    echo $user->getFirstname();
}

````

Company
-------

```php
// ...
// load an existing company by id
$company = new \Deepser\Entity\Company();
$company->load(600);
//...
// load company collection
$companyCollection = \Deepser\Entity\Company::getCollection();
$companyCollection->addFilter('name', 'like', '%ACME%');
foreach($companyCollection as $company){
    echo $company->getName();
}

````


Credits
-------

* [Serman Nerjaku](https://github.com/serman84)

Support
-------

[Please open an issue in github](https://github.com/deepser/api-php/issues)

Contributor Code of Conduct
---------------------------

As contributors and maintainers of this project, we pledge to respect all people
who contribute through reporting issues, posting feature requests, updating
documentation, submitting pull requests or patches, and other activities.

We are committed to making participation in this project a harassment-free
experience for everyone, regardless of level of experience, gender, gender
identity and expression, sexual orientation, disability, personal appearance,
body size, race, age, or religion.

Examples of unacceptable behavior by participants include the use of sexual
language or imagery, derogatory comments or personal attacks, trolling, public
or private harassment, insults, or other unprofessional conduct.

Project maintainers have the right and responsibility to remove, edit, or reject
comments, commits, code, wiki edits, issues, and other contributions that are
not aligned to this Code of Conduct. Project maintainers who do not follow the
Code of Conduct may be removed from the project team.

Instances of abusive, harassing, or otherwise unacceptable behavior may be
reported by opening an issue or contacting one or more of the project
maintainers.

This Code of Conduct is adapted from the [Contributor
Covenant](http:contributor-covenant.org), version 1.0.0, available at
[http://contributor-covenant.org/version/1/0/0/](http://contributor-covenant.org/version/1/0/0/).

License
-------

Deepser API is released under the MIT License. See the bundled
[LICENSE](https://github.com/deepser/api-php/blob/master/LICENSE) file for details.

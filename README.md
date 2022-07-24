# Start REST API project

Quick start REST API project based on Symfony.

### Under the hood
- listen for the `kernel.exception` event
- multiple firewalls
- separate authenticator for a Fake User
- preparation of the SQLIte database
- examples of http-requests from ["http"](/http) folder
- main page on Bootstrap 5.2
- to be continued :-)

### API Routes
- **/api**: free access
- **/api/fake**: access only for a Fake User

# Usage

Request example
```shell
GET http://localhost:8000/api/fake
Accept: application/json
Authorization: Bearer good.fake.user.token
```

# Installation
You can install the project in two ways

From packagist.org
```shell
composer create-project reiterus/api-starter-symfony
```

From GitHub repository
```json
{
 "repositories": [
  {
   "type": "vcs",
   "url": "https://github.com/reiterus/api-starter-symfony.git"
  }
 ]
}
```

# Tests

![Coverage](coverage.png)

To run tests with visual code coverage, launch the command as follows:

```shell
XDEBUG_MODE=coverage ./vendor/phpunit/phpunit/phpunit \
--configuration phpunit.xml.dist \
--testsuite default \
--coverage-html coverage/
```

Test results will be saved in the `coverage` directory.

# License

This library is released under the [MIT license](LICENSE).

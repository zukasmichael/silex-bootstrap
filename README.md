silex-bootstrap
===============
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/cf420dea-49e1-4a97-a9a8-7f47f8349843/mini.png)](https://insight.sensiolabs.com/projects/cf420dea-49e1-4a97-a9a8-7f47f8349843)
[![Build Status](https://travis-ci.org/satrun77/silex-bootstrap.svg?branch=master)](https://travis-ci.org/satrun77/silex-bootstrap)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/satrun77/silex-bootstrap/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/satrun77/silex-bootstrap/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/satrun77/silex-bootstrap/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/satrun77/silex-bootstrap/?branch=master)

A simple bootstrap to get started with a new Silex project.

## Instalation

1. Clone the project
  * git clone git@github.com:satrun77/silex-bootstrap.git project_name
2. Download & Install composer
  * Read composer [Getting Started](https://getcomposer.org/doc/00-intro.md)
3. Run tests.
  * phpunit -c app
4. Run behat tests.
  * Download Selenium server from http://seleniumhq.org/download/
  * Open a command line interface and execute
  ```bash
  $ java -jar /path/to/your/selenium/server/selenium-server-standalone-2.NN.N.jar
  ```
  * Start php local server
  * Open another command line interface and navigate to silex-bootstrap root directory and execute
  ```bash
  $ php -S localhost:8000 -t web
  ```
  * Execute behat tests
  ```bash
  $ bin/behat --config src/MyApp/behat.yml
  ```

## License

This bundle is under the MIT license. View the [LICENSE.md](Resources/doc/LICENSE.md) file for the full copyright and license information.

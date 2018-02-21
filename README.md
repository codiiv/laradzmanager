### 1 Requirements

- Composer - http://www.getcomposer.org
- Laravel 5.6.* - http://www.laravel.com

### 2. INSTALLATION

Add the composer repository to your Laravel *composer.json* file:

```json
  "codiiv/laradzmanager" : "~1.0.*"
```
And run ```composer update```.

Add Provider class to config/app.php

  ```php
      'providers' = [
          // ...
          Codiiv\Laradzmanager\LaradzmanagerServiceProvider::class,
          // ...
      ]
  ```

Then,

And run ```composer dump-autoload -o```.

```bash
    php artisan vendor:publish --tag=laradzmanager --force
```
This publishes the ```laradzmanager.php``` file in your installation's ```config/``` directory   >>     ```config/laradzmanager.php```.

### 3. CONFIGURATION

You can adjust some of the parameters in ```config\laradzmanager.php``` as needed

### 4. USAGE

Simply go to ```your_app_url/dzmanager```

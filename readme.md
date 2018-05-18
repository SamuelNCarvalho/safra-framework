# Safra Framework (Alpha)

## Introduction

A micro PHP Framework

## Installation

To run this alpha version, you need to clone it and install dependencies:

```
git clone https://github.com/SamuelNCarvalho/safra-framework.git safra
cd safra/
composer install
```

You can then run the web application using PHP's built-in server:
```
php -S localhost:8000 -t public/

```

## Helpers

### app()

Return an application instance.

### base_path()

Return application base path.

### config()

The config function gets the value of a configuration variable. The configuration values may be accessed using "dot" syntax, which includes the name of the file and the option you wish to access.

```php
config('app.name');
```

### view()

Render view file with [Twig](https://twig.symfony.com/) Template Engine.

```php
view('home.twig', ['foo' => 'bar'])
```
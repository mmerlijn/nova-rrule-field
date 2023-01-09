# A rrule field for Nova apps

This package contains a Nova field to make iCal recurring rules.

![screenshot of the tags field](https://raw.githubusercontent.com/mmerlijn/nova-rrule-field/master/screenshot.png)

## Requirements

- Laravel Nova

## Installation

You can install this package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require mmerlijn/nova-rrule-field
```

For Nova <= 3

```bash
composer require mmerlijn/nova-rrule-field v1.4
```

## Usage

```php
Tags::make('Recurring rule'),
```

## Optional methods

```php
locale('nl')    //default 'en', optional 'nl'

hide(false)          //hide the rrule, default hidden
```

### Security

If you discover any security related issues, please email menno@mmerlijn.nl instead of using the issue tracker.

## Credits

- [Menno Merlijn](https://github.com/mmerlijn)

## License

This software is absolutely free to use. Please leave a message if you going to use it.

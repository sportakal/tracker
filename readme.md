# tracker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require sportakal/tracker
```

And, for publish migrations

``` bash
$ php artisan vendor:publish --provider=sportakal\tracker
```

And migrate visits table to database
``` bash
$ php artisan migrate
```

If you want to track visitors on all pages, add this line on kernel.php
``` bash
    ...
    protected $middlewareGroups = [
        'web' => [
           ...
           \sportakal\tracker\middlewares\Tracker::class,
        ],
    ];
```

Or if you don't want to track visitors on all pages, you should define on "routeMiddleware" like this line. And you can use middleware as 'track' in your routes.
``` bash
    ...
    protected $routeMiddleware = [
        ...
        'track' => \sportakal\tracker\middlewares\Tracker::class,
    ];
```

Example Route
``` bash
Route::get('/', function () {
    return view('welcome');
})->middleware(['track']);
```
## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sportakal/tracker.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sportakal/tracker.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sportakal/tracker/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/sportakal/tracker
[link-downloads]: https://packagist.org/packages/sportakal/tracker
[link-travis]: https://travis-ci.org/sportakal/tracker
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/sportakal
[link-contributors]: ../../contributors]
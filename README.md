# Joy VoyagerDataTypeSettings

This [Laravel](https://laravel.com/)/[Voyager](https://voyager.devdojo.com/) module adds VoyagerDataTypeSettings support to Voyager.

By 🐼 [Ramakant Gangwar](https://github.com/rxcod9).

[![Screenshot](https://raw.githubusercontent.com/rxcod9/joy-voyager-data-type-settings/main/cover.jpg)](https://joy-voyager.herokuapp.com/)

[![Latest Version](https://img.shields.io/github/v/release/rxcod9/joy-voyager-data-type-settings?style=flat-square)](https://github.com/rxcod9/joy-voyager-data-type-settings/releases)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/rxcod9/joy-voyager-data-type-settings/run-tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/joy/voyager-data-type-settings.svg?style=flat-square)](https://packagist.org/packages/joy/voyager-data-type-settings)

---

## Prerequisites

*   Composer Installed
*   [Install Laravel](https://laravel.com/docs/installation)
*   [Install Voyager](https://github.com/the-control-group/voyager)

---

## Installation

```bash
# 1. Require this Package in your fresh Laravel/Voyager project
composer require joy/voyager-data-type-settings

# 2. Publish
php artisan vendor:publish --provider="Joy\VoyagerDataTypeSettings\VoyagerDataTypeSettingsServiceProvider" --force
# 3. Migrate
php artisan migrate
# 4. Generate Permissions
php artisan db:seed --class="\Joy\VoyagerDataTypeSettings\Database\Seeders\DataTypeSettingsPermissionsTableSeeder"
# 5. Attach Permissions with roles
php artisan db:seed --class=PermissionRoleTableSeeder
# 6. Seed data type setting types
php artisan db:seed --class="\Joy\VoyagerDataTypeSettings\Database\Seeders\DataTypeSettingsTableSeeder"
```

---


## Working Example

You can try laravel demo here [https://joy-voyager.herokuapp.com/admin/users/settings](https://joy-voyager.herokuapp.com/admin/users/settings) OR [https://joy-voyager.herokuapp.com/admin/roles/settings](https://joy-voyager.herokuapp.com/admin/roles/settings).

## Documentation

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving the joy voyager-data-type-settings? Feel free to [create an issue on GitHub](https://github.com/rxcod9/joy-voyager-data-type-settings/issues), we'll try to address it as soon as possible.

If you've found a bug regarding security please mail [gangwar.ramakant@gmail.com](mailto:gangwar.ramakant@gmail.com) instead of using the issue tracker.

## Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```

## Upgrading

Please see [UPGRADING](UPGRADING.md) for details.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email [gangwar.ramakant@gmail.com](mailto:gangwar.ramakant@gmail.com) instead of using the issue tracker.

## Credits

- [Ramakant Gangwar](https://github.com/rxcod9)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

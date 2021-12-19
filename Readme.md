# Migration of calendar_feature for Contao Open Source CMS

Since Contao 4.10 the featured events have been part of the contao core, so you no longer need the extension [calendar_feature](https://packagist.org/packages/erdmannfreunde/calendar_feature).
This Bundle provides a migration for the config of the event modules of the deprecated extension.

## Installation

Install the bundle via Composer:

```
composer require bwein-net/contao-migrate-calendar-feature
```

## Run the migration

After the installation you can run the migration via console `contao:migrate` or you open the contao install tool.

## Uninstall extension

After running the migration you can savely and should uninstall both extensions:

```
composer remove bwein-net/contao-migrate-calendar-feature
composer remove erdmannfreunde/calendar_feature
```

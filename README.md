# Zabbix PHP SDK builder

This package is used to build the classes for the [`confirm-it-solutions/php-zabbix-api`](https://github.com/confirm/PhpZabbixApi) library.
It uses scaffolding around the **Zabbix API** source classes in order to create the required methods for that specific Zabbix version.
The current version of this package is compatible and tested with Zabbix from version [3.0.0](https://repo.zabbix.com/zabbix/3.0/ubuntu/pool/main/z/zabbix/zabbix_3.0.0.orig.tar.gz) up to [3.4.15](https://repo.zabbix.com/zabbix/3.4/ubuntu/pool/main/z/zabbix/zabbix_3.4.15.orig.tar.gz).
The support for higher versions will be handled following the **Semantic Versioning Specification** ([SemVer](https://semver.org/)).

:bulb: Note

Previously, the capabilities and responsibilities covered by this package were provided directly from `confirm-it-solutions/php-zabbix-api`. They were moved here because this way we can keep separated the dependencies required to build the classes from the ones required to use the resulting library.

## Install

This command will check all the required dependencies before installing anything, so you can be sure that if the install process is successfully completed, you will have a fully functional setup.

    composer create-project confirm-it-solutions/zabbix-php-sdk-builder

## Usage

In order to create the classes, you must execute the following script, indicating the path to your Zabbix sources in the argument 1:

    php bin/build </path/to/zabbix/frontends/php>

For example, let's suposse you have downloaded the [Zabbix 3.4.15 source files](https://repo.zabbix.com/zabbix/3.4/ubuntu/pool/main/z/zabbix/zabbix_3.4.15.orig.tar.gz) in the `/opt/zabbix/` directory:

    https://repo.zabbix.com/zabbix/3.4/ubuntu/pool/main/z/zabbix/zabbix_3.4.15.orig.tar.gz | tar xvz -C /opt/zabbix

Then, you should indicate `/opt/zabbix/zabbix-3.4.15/frontends/php/` as path:

    php bin/build /opt/zabbix/zabbix-3.4.15/frontends/php/

The resulting files will be placed at `build/` directory in the root of this repository. They are:

* `Exception.php`
* `TokenCacheAwareInterface.php`
* `ZabbixApi.php`
* `ZabbixApiInterface.php`

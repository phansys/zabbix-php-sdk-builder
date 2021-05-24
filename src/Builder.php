<?php

/*
 * This file is part of PhpZabbixApi.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @copyright The MIT License (MIT)
 * @author confirm IT solutions GmbH, Rathausstrase 14, CH-6340 Baar
 */

namespace ZabbixSdkBuilder;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
class Builder
{
    /**
     * Class name for the abstract API class.
     */
    public const CLASSNAME_INTERFACE = 'ZabbixApiInterface';

    /**
     * Filename for the Zabbix API interface.
     */
    public const FILENAME_INTERFACE = self::CLASSNAME_INTERFACE.'.php';

    /**
     * Class name for the concrete API class.
     */
    public const CLASSNAME_CONCRETE = 'ZabbixApi';

    /**
     * Filename for the abstract API class.
     */
    public const FILENAME_CONCRETE = self::CLASSNAME_CONCRETE.'.php';

    /**
     * Class name for the abstract API class.
     */
    public const CLASSNAME_EXCEPTION = 'Exception';

    /**
     * Filename for the abstract API class.
     */
    public const FILENAME_EXCEPTION = self::CLASSNAME_EXCEPTION.'.php';

    /**
     * Filesystem path to templates directory.
     *
     * This directory contains all templates to build the class files.
     */
    public const PATH_TEMPLATES = __DIR__.'/templates';

    /**
     * Filesystem path to build directory.
     *
     * This directory contains the built class files.
     */
    public const PATH_BUILD = __DIR__.'/../build';

    /**
     * Filesystem path to the Zabbix PHP front-end root.
     *
     * Trailing slash not required!
     *
     * This constant is used to set the constants below. So if you've installed
     * the Zabbix PHP front-end (v2) on the same server, you probably only have
     * to update this constant.
     */
    public const PATH_ZABBIX = '/opt/zabbix/frontend';

    /**
     * @var string
     */
    private $zabbixPath = self::PATH_ZABBIX;

    /**
     * Path to the `API.php` class file of the Zabbix PHP front-end.
     * This class file will be used, to determine all available API classes.
     *
     * @var string
     */
    private $zabbixApiClassFilename;

    public function __construct(?string $zabbixPath = null)
    {
        if (null !== $zabbixPath) {
            $this->zabbixPath = $zabbixPath;
        }

        $this->zabbixApiClassFilename = $this->zabbixPath.'/include/classes/api/API.php';

        // Define some paths and do some sanity checks for existence of the paths.
        if (!is_dir($this->zabbixPath)) {
            throw new \RuntimeException('ERROR: Zabbix path "'.$this->zabbixPath.'" is not a directory! Please check the $this->zabbixPath configuration constant.');
        }

        $this->loadZabbixClasses();
    }

    public function getZabbixPath(): string
    {
        return $this->zabbixPath;
    }

    /**
     * Fetch the class map directly from the Zabbix classes.
     *
     * There are some differences between the Zabbix versions:
     *
     *  < 2.4:  The class map is stored as a static property directly in the
     *          origin API class.
     *
     *  >= 2.4: The class map is stored as an instance property in the
     *          origin CApiServiceFactory class.
     *
     * @return array<string, class-string>
     */
    public function getApiClassMap(): array
    {
        if (version_compare(\ZABBIX_API_VERSION, '2.4') >= 0) {
            $getClassMap = \Closure::bind(function (): array {
                return $this->objects;
            }, new \CApiServiceFactory(), \CApiServiceFactory::class);
        } else {
            $getClassMap = \Closure::bind(static function (): array {
                return self::$classMap;
            }, null, \API::class);
        }

        return $getClassMap();
    }

    /**
     * Replace placeholders in a string.
     *
     * Placeholders in the string are surrounded by '<' and '>' (e.g. '<FOOBAR>').
     *
     * @param array<string, string> $placeholders array with placeholders (key-value pair)
     */
    public function replacePlaceholders(string $string, array $placeholders): string
    {
        foreach ($placeholders as $placeholder => $value) {
            $string = str_replace('<'.strtoupper($placeholder).'>', $value, $string);
        }

        return $string;
    }

    /**
     * Register SPL autoloader.
     *
     * The API class files always inherit from other classes. Most of the classes
     * inherit from the CZBXAPI class, but there are a bunch of classes which
     * are extended by other API classes.
     *
     * So that we don't have to "follow" the right order on loading API class files,
     * we're register an API autoloader right here.
     *
     * Later the get_class_methods() function will automatically invoke this
     * autoloader.
     */
    private function loadZabbixClasses(): void
    {
        // Load Zabbix internal constants, to access ZABBIX_API_VERSION.
        require $this->zabbixPath.'/include/defines.inc.php';

        if (!file_exists($this->zabbixApiClassFilename)) {
            throw new \RuntimeException('ERROR: API class file "'.$this->zabbixApiClassFilename.'" not found! Please check the $this->zabbixApiClassFilename configuration constant');
        }

        // Path to the api/classes/ directory of the Zabbix PHP front-end.
        // This directory and the contained class files will be used, to determine all
        // available methods for each API class.
        if (version_compare(\ZABBIX_API_VERSION, '2.4') >= 0) {
            require $this->zabbixPath.'/include/classes/core/CRegistryFactory.php';
            require $this->zabbixPath.'/include/classes/api/CApiServiceFactory.php';
            require $this->zabbixPath.'/include/classes/api/CApiService.php';

            $pathZabbixApiClassesDirectory = $this->zabbixPath.'/include/classes/api/services';
        } else {
            require $this->zabbixPath.'/include/classes/api/CZBXAPI.php';

            $pathZabbixApiClassesDirectory = $this->zabbixPath.'/api/classes';
        }

        if (!is_dir($pathZabbixApiClassesDirectory)) {
            throw new \RuntimeException('ERROR: API class directory "'.$pathZabbixApiClassesDirectory.'" not found!');
        }

        // Load API.
        require $this->zabbixApiClassFilename;

        spl_autoload_register(static function (string $className) use ($pathZabbixApiClassesDirectory): void {
            require $pathZabbixApiClassesDirectory.'/'.$className.'.php';
        });
    }
}

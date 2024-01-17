<?php
namespace Bakkerit\PhpRipedbApi\Blueprints;

use Bakkerit\PhpRipedbApi\Utils\Config;
use Bakkerit\PhpRipedbApi\Utils\QueryBuilder;

class ModelBlueprint
{
    protected static QueryBuilder $queryBuilder;

    private static function resolveObjectType() {
        $className = get_called_class();

        $classNameParts = explode('\\', $className);
        $className = end($classNameParts);

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $className));
    }

    public static function initQueryBuilder($key = null) {
        $baseUri = Config::get('baseUri');
        $source = Config::get('source');
        $objectType = self::resolveObjectType();

        static::$queryBuilder = new QueryBuilder($baseUri, $source, $objectType, $key);
    }

    public static function get($key) {
        self::initQueryBuilder($key);
        return static::$queryBuilder->get();
    }
}

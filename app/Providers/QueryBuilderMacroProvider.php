<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;

// from https://medium.com/fattihkoca/laravel-auto-save-timestamps-with-query-builder-without-using-eloquent-123f7ebfeb92
class QueryBuilderMacroProvider extends ServiceProvider
{
    protected static $methods = ["insertTs", "insertGetIdTs", "updateTs", "deleteTs"];

    protected static function timestampValues($funcName, array $colNames)
    {
        Builder::macro($funcName, function (array $values, $withBy = false) use ($colNames) {
            // created_by or updated_by
            $user_id = $withBy ? auth()->user()->uid : null;
            // created_at or updated_at
            $now = \Carbon\Carbon::now();

            if (array_key_exists(0, $values) && is_array($values[0])) {
                foreach ($values as &$value) {
                    $value[$colNames[1]] = $now;
                    if ($colNames[2] != null) {
                        $value[$colNames[2]] = $now;
                    }

                    if ($withBy) {
                        $value[$colNames[3]] = $user_id;
                    }
                }
            } else {
                $values[$colNames[1]] = $now;
                if ($colNames[2] != null) {
                    $values[$colNames[2]] = $now;
                }

                if ($withBy) {
                    $values[$colNames[3]] = $user_id;
                }
            }

            return Builder::{$colNames[0]}($values);
        });
    }

    /**
     * Insert with timestamp
     */
    protected static function insertTs()
    {
        return self::timestampValues(__FUNCTION__, ["insert", "updated_at", "created_at", "created_by"]);
    }

    /**
     * Insert with timestamp and return id
     */
    protected static function insertGetIdTs()
    {
        return self::timestampValues(__FUNCTION__, ["insertGetId", "updated_at", "created_at", "created_by"]);
    }

    /**
     * Update with timestamp
     */
    protected static function updateTs()
    {
        return self::timestampValues(__FUNCTION__, ["update", "updated_at", null, "updated_by"]);
    }

    /**
     * Soft delete (with timestamp)
     */
    protected static function deleteTs()
    {
        Builder::macro(__FUNCTION__, function ($withBy = false) {
            $values = [
                "deleted_at" => \Carbon\Carbon::now()
            ];
            // deleted_by
            if ($withBy) {
                $values["deleted_by"] = auth()->user()->id;
            }

            return Builder::update($values);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (self::$methods as $method) {
            self::{$method}();
        }
    }
}
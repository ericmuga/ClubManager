<?php // app/Traits/LogsChanges.php
namespace App\Traits;

use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;


trait LogsChanges
{
    public static function bootLogsChanges()
    {
        static::updated(function ($model) {
            $loggableFields = self::getLoggableFields($model->getTable());

            foreach ($model->getDirty() as $field => $newValue) {
                if (in_array($field, $loggableFields)) {
                    $oldValue = $model->getOriginal($field);
                    ChangeLog::create([
                        'table_name' => $model->getTable(),
                        'field_name' => $field,
                        'change_type' => 'update',
                        'old_value' => json_encode($oldValue),
                        'new_value' => json_encode($newValue),
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        });

        static::created(function ($model) {
            $loggableFields = self::getLoggableFields($model->getTable());

            foreach ($model->attributesToArray() as $field => $newValue) {
                if (in_array($field, $loggableFields)) {
                    ChangeLog::create([
                        'table_name' => $model->getTable(),
                        'field_name' => $field,
                        'change_type' => 'insert',
                        'old_value' => null,
                        'new_value' => json_encode($newValue),
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        });

        static::deleted(function ($model) {
            $loggableFields = self::getLoggableFields($model->getTable());

            foreach ($model->attributesToArray() as $field => $oldValue) {
                if (in_array($field, $loggableFields)) {
                    ChangeLog::create([
                        'table_name' => $model->getTable(),
                        'field_name' => $field,
                        'change_type' => 'delete',
                        'old_value' => json_encode($oldValue),
                        'new_value' => null,
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        });
    }

    private static function getLoggableFields($table)
    {
        // This should be replaced with the actual logic to get loggable fields
        // For example, it could be a static list, a database query, or a call to a service
        // return ['field1', 'field2', 'field3'];

        // Example of dynamic retrieval (replace this with your actual implementation)
        $settings = \App\Models\Setting::where('table_name', $table)
                           ->where('log_changes', true)
                           ->get();

        $loggableFields = [];
        foreach ($settings as $setting) {
            // Assuming you have a method in your Setting model to get loggable fields dynamically
            $loggableFields = array_merge($loggableFields, $setting->getLoggableFields());
        }

        return $loggableFields;
    }
}

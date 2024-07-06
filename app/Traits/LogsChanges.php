<?php
// app/Traits/LogsChanges.php
namespace App\Traits;

use App\Models\ChangeLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;


trait LogsChanges
{
    public static function bootLogsChanges()
    {
        static::updated(function ($model) {
            $settings = Setting::where('table_name', $model->getTable())
                               ->where('log_changes', true)
                               ->pluck('field_name')
                               ->toArray();

            foreach ($model->getDirty() as $field => $newValue) {
                if (in_array($field, $settings)) {
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
            $settings = Setting::where('table_name', $model->getTable())
                               ->where('log_changes', true)
                               ->pluck('field_name')
                               ->toArray();

            foreach ($model->attributesToArray() as $field => $newValue) {
                if (in_array($field, $settings)) {
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
            $settings = Setting::where('table_name', $model->getTable())
                               ->where('log_changes', true)
                               ->pluck('field_name')
                               ->toArray();

            foreach ($model->attributesToArray() as $field => $oldValue) {
                if (in_array($field, $settings)) {
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


}

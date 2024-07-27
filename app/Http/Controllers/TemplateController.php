<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    public function downloadTemplate($model)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Invalid model type'], 404);
        }

        $modelInstance = App::make($modelClass);
        $headings = $modelInstance->getFillable();

        Log::info('Model Class:', ['class' => $modelClass]);
        Log::info('Fillable Fields:', ['fields' => $headings]);

        if (empty($headings)) {
            return response()->json(['error' => 'No fillable fields found'], 400);
        }

        return Excel::download(new TemplateExport($headings), "{$model}_template.xlsx");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
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

        return Excel::download(new TemplateExport([],$headings), "{$model}_template.xlsx");
    }

   public function downloadList($model)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Invalid model type'], 404);
        }

        $modelInstance = App::make($modelClass);
        $data = $modelInstance::all()->toArray();

        Log::info('Model Class:', ['class' => $modelClass]);
        Log::info('Model Data:', ['data' => $data]);

        if (empty($data)) {
            return response()->json(['error' => 'No data found'], 404);
        }

        return Excel::download(new TemplateExport($data), "{$model}_data.xlsx");
    }

    public function downloadPDFList($model)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Invalid model type'], 404);
        }

        $modelInstance = App::make($modelClass);
        $data = $modelInstance::all()->toArray();

        Log::info('Model Class:', ['class' => $modelClass]);
        Log::info('Model Data:', ['data' => $data]);

        if (empty($data)) {
            return response()->json(['error' => 'No data found'], 404);
        }

        // Extract headings
        $headings = !empty($data) ? array_keys($data[0]) : [];

        // Render the view and get the HTML content
        $html = view('pdf.list', [
            'model' => $model,
            'headings' => $headings,
            'data' => $data
        ])->render();

        // Initialize mPDF
        // $mpdf = new Mpdf();
         // Initialize mPDF with a custom temporary directory
       $mpdf = new \Mpdf\Mpdf([
                'tempDir' => storage_path('mpdf_tmp')
            ]);


        // Write HTML to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF as a download
        return $mpdf->Output("{$model}_data.pdf", 'D');
    }


}

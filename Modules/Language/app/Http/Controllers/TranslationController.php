<?php

namespace Modules\Language\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends Controller
{
    public function translateAll(Request $request)
    {
        try {
            if (checkAdminHasPermission('language.translate')) {
                $filePath = base_path('lang/' . $request->code . '.json');
                if (File::exists($filePath)) {

                    $jsonData = json_decode(File::get($filePath), true);
                    $keys = array_keys($jsonData);
                    $values = array_values($jsonData);

                    $delimiter = "\n\t";
                    $allText = implode($delimiter, $values);

                    // Split the text into chunks
                    $chunks = $this->splitIntoChunksWithDelimiter($allText, 5000, $delimiter);

                    $translatedChunks = $this->translateChunks($chunks, $request->code);
                    // Combine the translated chunks back into a single string
                    $translatedText = implode($delimiter, $translatedChunks);
                    $translatedValues = explode($delimiter, $translatedText);
                    if (count($translatedValues) == count($keys)) {
                        $translatedData = array_combine($keys, $translatedValues);

                        // Save the translated JSON back to the file
                        File::put($filePath, json_encode($translatedData, JSON_PRETTY_PRINT));

                        return response()->json([
                            'success' => true,
                            'message' => __('All texts translated successfully!'),
                        ]);
                    }

                    return response()->json([
                        'success' => false,
                        'message' => __('Something went wrong while translating the file.'),
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => __('File Not Found!'),
                ], 404);
            }

            return response()->json([
                'success' => false,
                'message' => __('Permission Denied!'),
            ], 403);
        } catch (\Exception $e) {
            logger($e);
            return response()->json([
                'success' => false,
                'message' => __('An error occurred while translating the file.') . ' ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Split the text into chunks of a specified size, ensuring chunks end with a delimiter.
     * @prams $text
     * @prams $maxChunkSize
     * @prams $delimiter
     */
    private function splitIntoChunksWithDelimiter($text, $maxChunkSize, $delimiter)
    {
        $chunks = [];
        $textLength = strlen($text);
        $start = 0;

        while ($start < $textLength) {
            $end = $start + $maxChunkSize;
            if ($end >= $textLength) {
                $chunks[] = substr($text, $start);
                break;
            }

            // Find the last occurrence of the delimiter before the end point
            $end = strrpos(substr($text, $start, $maxChunkSize), $delimiter) + $start + strlen($delimiter);

            if ($end <= $start) {
                // If no delimiter is found, use the maxChunkSize as the end point
                $end = $start + $maxChunkSize;
            }

            $chunks[] = substr($text, $start, $end - $start);
            $start = $end;
        }

        return $chunks;
    }
    // translate chunks
    private function translateChunks($chunks, $lang_code)
    {
        $translatedChunks = [];
        foreach ($chunks as $chunk) {
            $tr = new GoogleTranslate($lang_code);
            $translatedData = $tr->translate($chunk);
            $translatedChunks[] = $translatedData;
        }
        return $translatedChunks;
    }

    public function translateSingleText(Request $request)
    {
        if (checkAdminHasPermission('language.single.translate')) {
            $tr = new GoogleTranslate($request->lang);
            $afterTrans = $tr->translate($request->text);

            return response()->json($afterTrans);
        }

        return response()->json(__('Permission Denied!'), 403);
    }
}

<?php

namespace Modules\Language\app\Traits;

use Exception;

trait LanguageTrait
{
    private function deleteFolder($folderPath)
    {
        if (is_dir($folderPath)) {
            $files = scandir($folderPath);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $this->deleteFolder($folderPath.'/'.$file);
                }
            }
            rmdir($folderPath);
        } else {
            unlink($folderPath);
        }
    }

    private function copyPasteFile($code, $file, $dataArray)
    {
        $originalFileContent = file_get_contents(base_path("lang/{$code}/{$file}.php"));

        try {
            file_put_contents(base_path("lang/{$code}/{$file}.php"), '');
            $dataArray = var_export($dataArray, true);
            file_put_contents(base_path("lang/{$code}/{$file}.php"), "<?php\n return {$dataArray};\n ?>");
        } catch (Exception $e) {
            file_put_contents(base_path("lang/{$code}/{$file}.php"), $originalFileContent);
        }

    }
}

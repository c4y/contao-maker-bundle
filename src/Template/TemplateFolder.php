<?php

namespace App\Template;

class TemplateFolder
{
    public static function createFromFolder($tplFolder, $bundleFolder, array $options = [])
    {
        $cliFolder = trim(shell_exec("pwd"));

        $searchFolder = __DIR__ . '/../../skeleton/'.$tplFolder;
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($searchFolder, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);

        foreach($files as $file) {
            $destRelativePath = str_replace(__DIR__. '/../../skeleton/'.$tplFolder."/", "", $file);
            $destAbsoluteBundleFolder = $cliFolder . '/' . $bundleFolder;
            $destAbsolutePath = $destAbsoluteBundleFolder . '/' . $destRelativePath;

            // create initial bundle folder
            if(!file_exists($destAbsoluteBundleFolder)) {
                mkdir($destAbsoluteBundleFolder, 0777, true);
            }
            
            // create empty folders
            if(is_dir($file) && !file_exists($destAbsolutePath)) {
                mkdir($destAbsolutePath, 0777, true);
            }

            // only process files
            if(is_dir($file)) {
                continue;
            }

            $options['bundleFolder'] = $bundleFolder;

            $tpl = new Template($tplFolder.'/'.$destRelativePath);
            $tpl->setOptions($options);
            
            $tpl->saveTo($destAbsolutePath);
            
            unset($tpl);
        }
    }
}
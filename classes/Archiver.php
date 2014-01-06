<?php

/**
 * @class Archiver
 */
class Archiver 
{
    /**
     *
     */
    protected $output = array();
 
    /**
     *
     */
    public function pack($source, $destination=null)
    {
        $source = realpath($source);
        $sourcePath = dirname($source);
        $sourceBaseName = basename($source);
 
        if (is_null($destination)) {
            $destination = $sourcePath . DIRECTORY_SEPARATOR . $sourceBaseName . '.zip';
        } 
        
        $zip = new ZipArchive();
        $zip->open($destination, ZipArchive::CREATE);
 
        if (is_dir($source)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($iterator as $item) {
                if ($item->isDir()) {
                    if ($item->getRealpath() !== $sourcePath) {
                        $dir = str_replace($sourcePath . DIRECTORY_SEPARATOR, '', $item->getRealpath());
                        $zip->addEmptyDir(ltrim($dir, DIRECTORY_SEPARATOR)); 
                    }
                } else if ($item->isFile()) {
                    $this->output[] = str_replace($sourcePath . DIRECTORY_SEPARATOR, '', $item->getRealpath());
                    $file = str_replace($source . DIRECTORY_SEPARATOR, '', $item->getRealpath());
                    $zip->addFile($item->getRealpath(), $sourceBaseName . DIRECTORY_SEPARATOR . $file);   
                } 
            }
        } else if (is_file($source)) {
            $this->output[] = basename($source);
            $zip->addFile($source, basename($source));
        } 
        
        return $zip->close();
    }
    
    /**
     *
     */
    public function unpack($source, $destination=null) 
    {
        
        $source = realpath($source);
        $sourcePath = dirname($source);
        
        if (is_null($destination)) {
            $extractPath = realpath($sourcePath) . DIRECTORY_SEPARATOR;
        }
        
        $zip = new ZipArchive();
        
        if ($zip->open($source) === true) {
            $zip->extractTo($destination);
        } else { 
            return false;
        }
 
        return $zip->close();
    }
    
    /**
     *
     */
    public function getOutput()
    {
        return $this->output;
    }   
}
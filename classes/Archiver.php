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
    public function pack($source, $destination=null, $isNeedOwerwrite=true)
    {
        $source = realpath($source);
        $sourcePath = dirname($source);
        $sourceBaseName = basename($source);
 
        if (is_null($destination)) {
            $destination = $sourcePath . DIRECTORY_SEPARATOR . $sourceBaseName . '.zip';
        } else {
            $fileName = basename($destination);
            $destination = realpath(dirname($destination)) . DIRECTORY_SEPARATOR . $fileName;
        }

        if (is_file($destination)) {
            if ($isNeedOwerwrite) {
                unlink($destination);
            } else {
                return false;
            }
        }

        $zip = new ZipArchive();
        $zip->open($destination, ZipArchive::CREATE);
 
        if (is_dir($source)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($iterator as $item) {
                if (strpos($item->getFileName(), '.') === 0
                    || strpos($item->getRealpath(), DIRECTORY_SEPARATOR . '.') !== false)
                {
                    continue;
                }

                if ($item->isDir()) {
                    if ($item->getRealpath() !== $sourcePath) {
                        $dir = str_replace($sourcePath . DIRECTORY_SEPARATOR, '', $item->getRealpath());
                        $zip->addEmptyDir(ltrim($dir, DIRECTORY_SEPARATOR)); 
                    }
                } else if ($item->isFile()) {
                    $this->output[] = $item->getRealpath();
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
    public function unpack($source, $destination=null, $isNeedOwerwrite=true) 
    { 
        $source = realpath($source);
        $sourcePath = dirname($source);

        if (is_null($destination)) {
            $destination = realpath(dirname($sourcePath)) . DIRECTORY_SEPARATOR;
        }

        // if (is_dir($destination)) {
            // if ($isNeedOwerwrite) {
                // Fs::remove($destination);
            // } else {
                // return false;
            // }
        // }

        if (! is_dir($destination)) {
            Fs::mkdir($destination);
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
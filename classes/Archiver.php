<?php
 
class Archiver 
{
 
    protected $files = array();
 
    public function pack($source, $archivePath=null)
    {   
 
        $source = realpath($source);
        $sourcePath = dirname($source);
 
        if (is_null($archivePath)) {
            $archiveName = explode(DIRECTORY_SEPARATOR, $source);
            $archiveName = array_pop($archiveName);
            $archivePath = implode(DIRECTORY_SEPARATOR, array_slice(explode(DIRECTORY_SEPARATOR, $source), 0, -1)) . DIRECTORY_SEPARATOR . $archiveName . '.zip';
        } else {
            $archiveName = explode('/', $archivePath);
            $archiveName = array_pop($archiveName);
            $archivePath = realpath(implode('/', array_slice(explode('/', $archivePath), 0, -1))) . DIRECTORY_SEPARATOR . $archiveName;
        }
        
        $zip = new ZipArchive();
        $zip->open($archivePath, ZipArchive::OVERWRITE);
 
        if (is_dir($source)) {
 
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::CHILD_FIRST);
                
            foreach($iterator as $item) {
                if ($item->isDir()) {                    
                    if($item->getRealpath() !== $sourcePath) {
                        $dir = str_replace($sourcePath  . DIRECTORY_SEPARATOR, '', $item->getRealpath());
                        $zip->addEmptyDir(iconv('cp1251', 'cp866', $dir)); 
                    }
                } else if ($item->isFile()) {
 
                    $this->files[] = str_replace($sourcePath . DIRECTORY_SEPARATOR, '', $item->getRealpath());
                    $file = str_replace($sourcePath . DIRECTORY_SEPARATOR, '', $item->getRealpath());
                    $zip->addFile($item->getRealpath(), iconv('cp1251', 'cp866', $file));   
                } 
            }
        } else if (is_file($source)) {
        
            $path = str_replace($sourcePath, '', $source);
            $this->files[] = $path;
            $zip->addFile($source, $path);   
            
        } else {
            return false;
        }
        
        return $zip->close();
    }
    
    public function unpack($fileSource, $extractPath=null) 
    {
        $fileSource = realpath($fileSource);
        $fileSourcePath = dirname($fileSource) . DIRECTORY_SEPARATOR;
        var_dump($fileSourcePath);
        $zip = new ZipArchive();
        
        if ($zip->open($fileSource) === true) {
 
            for($i = 0; $i < $zip->numFiles; $i++) {             
                $zip->extractTo('./zip/', array($zip->getNameIndex($i)));
            }
 
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator('./zip/'), RecursiveIteratorIterator::CHILD_FIRST);
                
            foreach($iterator as $item) {
                $filename = iconv('cp866', 'cp1251', $item->getRealpath());
                if ($filename !== $item->getRealpath() && !empty($filename)) {
                    @rename($item->getRealpath(), $filename);
                }
            }
        } 
        return $zip->close();
 
        
    }
    
    public function getOutput()
    {
        return $this->files;
    
    }
    
}
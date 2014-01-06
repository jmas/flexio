<?php

/**
 * @class Fs
 */
class Fs
{
	/**
	 *
	 */
	static public function copy($src, $dst, $mode=0777)
	{
	    $dir = opendir($src);
	    
	    @mkdir($dst, $mode);
	    @chmod($dst, $mode);

	    while (false !== ($item = readdir($dir))) {
	        if ($item==='.' || $item==='..') {
	        	continue;
	        };

            if (is_dir($src . DIRECTORY_SEPARATOR . $item)) {
                self::copy($src . DIRECTORY_SEPARATOR . $item, $dst . DIRECTORY_SEPARATOR . $item);
            } else {
                copy($src . DIRECTORY_SEPARATOR . $item, $dst . DIRECTORY_SEPARATOR . $item);
                @chmod($dst . DIRECTORY_SEPARATOR . $item, $mode);
            }
	    }

	    closedir($dir);
	}


	/**
	 *
	 */
	static public function remove($path)
	{
	    $it = new RecursiveIteratorIterator(
	        new RecursiveDirectoryIterator($path),
	        RecursiveIteratorIterator::CHILD_FIRST
	    );
	    
	    foreach ($it as $file) {
	    	if (in_array($file->getBasename(), array('.', '..'))) {
	            continue;
	        } elseif ($file->isDir()) {
	    		chmod($file->getPathname(), 0777);

	            rmdir($file->getPathname());
	        } elseif ($file->isFile() || $file->isLink()) {
	    		chmod($file->getPathname(), 0777);

	            unlink($file->getPathname());
	        }
	    }

	    rmdir($path);
	}

	/**
	 *
	 */
	static public function mkdir($path, $mode = 0777)
	{
		$dirs = explode(DIRECTORY_SEPARATOR , $path);
		$count = count($dirs);
		$path = '.';

		for ($i = 0; $i < $count; ++$i) {
			$path .= DIRECTORY_SEPARATOR . $dirs[$i];
			
			if (! is_dir($path) && ! mkdir($path)) {
				return false;
			}
		}

		return true;
	}
}
<?php

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

	    while (false !== ($file = readdir($dir))) {
	        if ($file!=='.' && $file!=='..') {
	            if (is_dir($src . DIRECTORY_SEPARATOR . $file)) {
	                self::copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
	            } else {
	                copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
	                @chmod($dst . DIRECTORY_SEPARATOR . $file, $mode);
	            }
	        }
	    }

	    closedir($dir);
	}


	/**
	 *
	 */
	public function remove($path)
	{
	    $it = new RecursiveIteratorIterator(
	        new RecursiveDirectoryIterator($path),
	        RecursiveIteratorIterator::CHILD_FIRST
	    );
	    
	    foreach ($it as $file) {
	        if (in_array($file->getBasename(), array('.', '..'))) {
	            continue;
	        } elseif ($file->isDir()) {
	            rmdir($file->getPathname());
	        } elseif ($file->isFile() || $file->isLink()) {
	            unlink($file->getPathname());
	        }
	    }

	    rmdir($path);
	}

	/**
	 *
	 */
	function mkdir($path, $mode = 0777)
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
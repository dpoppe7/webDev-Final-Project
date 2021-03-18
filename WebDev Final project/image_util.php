<?php

// This code is combined from a number of locations and modified
// by Frank McCown, Harding University, 2009.


// Returns an empty string if uploaded image is successfully saved as
// $image_filename or an error message.
// $image_filename should be saved in a directory that the web
// server can write to.
function UploadSingleImage($image_filename)
{
	// This function is greatly modified code from
	// http://www.webdeveloper.com/forum/showthread.php?t=101466
	
	
	// possible PHP upload errors
	$errors = array(1 => 'php.ini max file size exceeded (' . ini_get('upload_max_filesize') . ' limit)',
                2 => 'html form max file size exceeded',
                3 => 'file upload was only partial',
                4 => 'no file was attached');
    
	/*
print "<pre>";
print_r($_FILES);
print "</pre>\n";
*/

	// check if any files were uploaded and if
	// so store the active $_FILES array keys
	$active_keys = array();
	foreach($_FILES as $key => $file)
	{
		if (!empty($file['name']))
		{
			$active_keys[] = $key;
		}
	}

	// check at least one file was uploaded
	if (count($active_keys) == 0)
		return 'No files were uploaded';
        
	// check for standard uploading errors
	foreach ($active_keys as $key)
	{
		if ($_FILES[$key]['error'] > 0)
			return $_FILES[$key]['tmp_name'] . ': ' . $errors[$_FILES[$key]['error']];
	}
    
	// check that the file we are working on really was an HTTP upload
	foreach ($active_keys as $key)
	{
		if (!is_uploaded_file($_FILES[$key]['tmp_name']))
			return $_FILES[$key]['tmp_name'] . ' not an HTTP upload';
	}
    
	// validation... since this is an image upload script we
	// should run a check to make sure the upload is an image
	foreach ($active_keys as $key)
	{
		if (!getimagesize($_FILES[$key]['tmp_name']))
			return $_FILES[$key]['tmp_name'].' is not an image';
	}
    	

	// Save every uploaded file to the same filename (normally we'd want to
	// save each file with its own unique name, but we are assuming there
	// is only one file).
	foreach ($active_keys as $key)
	{
		if (!move_uploaded_file($_FILES[$key]['tmp_name'], $image_filename))
			return 'receiving directory (' . $image_filename . ') has insuffiecient permission';
	}
    
	// If you got this far, everything has worked and the file has been successfully saved.

	return '';
}  


// Returns true if at least one image was uploaded, false otherwise.
function ImageUploaded()
{
	$image_uploaded = false;
	
	$active_keys = array();
	foreach($_FILES as $key => $file)
	{
		if (!empty($file['name']))
			$image_uploaded = true;
	}

	return $image_uploaded;
}

// Code from https://davidwalsh.name/create-image-thumbnail-php
function CreateThumbnailImage($src_filename, $dest_filename, $desired_width)
{
	$source_image = imagecreatefromjpeg($src_filename);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	// create height based on desired width, keeping the same aspect ratio
	$desired_height = floor($height * ($desired_width / $width));
	
	// create a new, "virtual" image
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	// copy source image at a resized size 
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, 
		$desired_height, $width, $height);
	
	// create the physical thumbnail image to its destination 
	imagejpeg($virtual_image, $dest_filename);
}

?> 


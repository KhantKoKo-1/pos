<?php
switch ($extension) {
    case 'jpg':
    case 'jpeg':
        $sourceImage = imagecreatefromjpeg($full_path_img);
        break;
    case 'png':
        $sourceImage = imagecreatefrompng($full_path_img);
        break;
    case 'gif':
        $sourceImage = imagecreatefromgif($full_path_img);
        break;
    default:
        die('Unsupported file format.');
}

$sourceWidth = imagesx($sourceImage);
$sourceHeight = imagesy($sourceImage);
$newWidth = $image_width;
$newHeight = 300;

// Create a new true-color image for the resized version
$resizedImage = imagecreatetruecolor($newWidth, $newHeight);

// Preserve transparency for PNG and GIF images
if ($extension == 'png' || $extension == 'gif') {
    imagealphablending($resizedImage, false);
    imagesavealpha($resizedImage, true);
    $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
    imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
}

// Resize the image
imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

// Save the resized image to a new file
$resizedImagePath = $full_path_img; // Replace with your destination path
imagejpeg($resizedImage, $resizedImagePath, 100); // 100 is the image quality

// Free up memory by destroying the image resources
imagedestroy($sourceImage);

?>

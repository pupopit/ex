<?php
require_once 'image_processor.php';

// Check if file was uploaded
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    die("No image uploaded or upload error occurred.");
}

// Create ImageProcessor instance
$processor = new ImageProcessor($_FILES['image']);

// Resize if dimensions provided
if (!empty($_POST['resize_width']) && !empty($_POST['resize_height'])) {
    $processor->resize(
        intval($_POST['resize_width']), 
        intval($_POST['resize_height'])
    );
}

// Crop if coordinates and dimensions provided
if (!empty($_POST['crop_x']) && !empty($_POST['crop_y']) && 
    !empty($_POST['crop_width']) && !empty($_POST['crop_height'])) {
    $processor->crop(
        intval($_POST['crop_x']), 
        intval($_POST['crop_y']), 
        intval($_POST['crop_width']), 
        intval($_POST['crop_height'])
    );
}

// Watermark processing
if (isset($_FILES['watermark']) && $_FILES['watermark']['error'] === UPLOAD_ERR_OK) {
    $processor->addWatermark(
        $_FILES['watermark'], 
        $_POST['watermark_position']
    );
}

// Output format conversion
$outputFormat = $_POST['output_format'] ?? 'original';
$processor->outputImage($outputFormat);
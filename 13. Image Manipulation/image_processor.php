<?php
class ImageProcessor {
    private $image;
    private $originalPath;
    private $imageType;
    private $width;
    private $height;

    public function __construct($imageFile) {
        $this->originalPath = $imageFile['tmp_name'];
        
        // Determine image type and create resource
        $imageInfo = getimagesize($this->originalPath);
        $this->imageType = $imageInfo[2];
        $this->width = $imageInfo[0];
        $this->height = $imageInfo[1];

        // Create image resource based on type
        switch ($this->imageType) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($this->originalPath);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($this->originalPath);
                break;
            case IMAGETYPE_WEBP:
                $this->image = imagecreatefromwebp($this->originalPath);
                break;
            default:
                throw new Exception("Unsupported image type");
        }
    }

    public function resize($newWidth, $newHeight) {
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Handle transparency for PNG
        if ($this->imageType === IMAGETYPE_PNG) {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
        }

        imagecopyresampled(
            $resizedImage, $this->image, 
            0, 0, 0, 0, 
            $newWidth, $newHeight, 
            $this->width, $this->height
        );

        $this->image = $resizedImage;
        $this->width = $newWidth;
        $this->height = $newHeight;
        return $this;
    }

    public function crop($x, $y, $cropWidth, $cropHeight) {
        $croppedImage = imagecrop(
            $this->image, 
            ['x' => $x, 'y' => $y, 'width' => $cropWidth, 'height' => $cropHeight]
        );

        if ($croppedImage !== false) {
            $this->image = $croppedImage;
            $this->width = $cropWidth;
            $this->height = $cropHeight;
        }
        return $this;
    }

    public function addWatermark($watermarkFile, $position = 'bottom-right') {
        // Load watermark image
        $watermarkPath = $watermarkFile['tmp_name'];
        $watermarkInfo = getimagesize($watermarkPath);
        $watermarkType = $watermarkInfo[2];

        // Create watermark resource
        switch ($watermarkType) {
            case IMAGETYPE_JPEG:
                $watermark = imagecreatefromjpeg($watermarkPath);
                break;
            case IMAGETYPE_PNG:
                $watermark = imagecreatefrompng($watermarkPath);
                break;
            default:
                throw new Exception("Unsupported watermark image type");
        }

        $watermarkWidth = imagesx($watermark);
        $watermarkHeight = imagesy($watermark);

        // Calculate watermark position
        switch ($position) {
            case 'bottom-right':
                $destX = $this->width - $watermarkWidth - 10;
                $destY = $this->height - $watermarkHeight - 10;
                break;
            case 'top-left':
                $destX = 10;
                $destY = 10;
                break;
            case 'center':
                $destX = ($this->width - $watermarkWidth) / 2;
                $destY = ($this->height - $watermarkHeight) / 2;
                break;
        }

        // Merge watermark with transparency support
        imagecopymerge(
            $this->image, $watermark, 
            $destX, $destY, 
            0, 0, 
            $watermarkWidth, $watermarkHeight, 
            50  // 50% opacity
        );

        return $this;
    }

    public function outputImage($format = 'original') {
        // Set headers to prevent caching
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Expires: 0');

        // Determine output format
        switch ($format) {
            case 'jpg':
                header('Content-Type: image/jpeg');
                imagejpeg($this->image);
                break;
            case 'png':
                header('Content-Type: image/png');
                imagepng($this->image);
                break;
            case 'webp':
                header('Content-Type: image/webp');
                imagewebp($this->image);
                break;
            default:
                // Output original format
                switch ($this->imageType) {
                    case IMAGETYPE_JPEG:
                        header('Content-Type: image/jpeg');
                        imagejpeg($this->image);
                        break;
                    case IMAGETYPE_PNG:
                        header('Content-Type: image/png');
                        imagepng($this->image);
                        break;
                    case IMAGETYPE_WEBP:
                        header('Content-Type: image/webp');
                        imagewebp($this->image);
                        break;
                }
        }

        // Free up memory
        imagedestroy($this->image);
    }
}
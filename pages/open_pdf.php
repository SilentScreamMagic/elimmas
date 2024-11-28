<?php
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];
    // Check if the file exists
    if (file_exists($filePath) && mime_content_type($filePath) == 'application/pdf') {
        // Set headers to display the PDF in the browser
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        
        // Read the file and output its contents
        @readfile($filePath);
    } else {
        echo "File not found or not a PDF.";
    }
} else {
    echo "No file specified.";
}
?>

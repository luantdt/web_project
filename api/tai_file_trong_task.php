<?php
    if(isset($_REQUEST["file"])){
        // Get parameters
        $filepath = urldecode($_REQUEST["file"]); // Decode URL-encoded string
        $filepath = '..' . $filepath;

        // Process download
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); 
            readfile($filepath);
            echo json_encode(
                array(
                    "error" => false,
                    "message" => "Tải xuống file thành công",
                )
            );
        } else {
            echo json_encode(
                array(
                    "error" => true,
                    "message" => "File is does not exist",
                )
            );
        }
    }
    
?>
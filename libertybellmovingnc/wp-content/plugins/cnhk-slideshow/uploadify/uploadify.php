<?php
        
if (isset($_POST['sid'])) {
	session_id($_POST['sid']);
	session_start();
} else {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (isset($_POST['nonce']) && $_POST['nonce'] == $_SESSION['cnhk']['nonce']){
    if (!empty($_FILES)) {
    
        $tmp_file = $_FILES['Filedata']['tmp_name'];
        $target_folder = rawurldecode($_POST['dir']);

        $nb = 1;
        while (file_exists($target_folder . "slide{$nb}.jpg") || file_exists($target_folder . "slide{$nb}.png")) {
            $nb++;
        }
        
        $has_error = false;
        $error_html = '';
        
        $file_types = array('jpeg', 'jpg', 'png');
        $file_parts = pathinfo($_FILES['Filedata']['name']);
        $file_ext = strtolower($file_parts['extension']);
        
        if (!in_array($file_ext, $file_types)) {
            $has_error = true;
            $error_html = $_POST['file_type_error'];
        }
        
        $extension = 'png';
        
        if ('jpeg' == $file_ext || 'jpg' == $file_ext)
            $extension = 'jpg';
        
        $target_file_name = 'slide' . $nb . '.' . $extension;
        $target = $target_folder . $target_file_name;
        
        if (!$has_error) {
            
            $css = false;
            
            $size = getimagesize($tmp_file);
            if ($size[0] >= $size[1]) {
                $css = 'thumb-400';
            } else {
                $css = 'thumb-300';
            }
            
            if (move_uploaded_file($tmp_file, $target)) {
                $_SESSION['cnhk']['uploaded'] = array('fileName' => $target_file_name);
                $response = json_encode(array(
                        'status' => true,
                        'name' => 'slide' . $nb,
                        'extension' => $extension,
                        'css' => $css,
                    )
                    , JSON_FORCE_OBJECT
                );
                header("Content-Type: application/json");
                echo $response;
                exit;
            } else {
                $response = json_encode(array(
                        'status' => false,
                        'error' => 'File not moved',
                    )
                    , JSON_FORCE_OBJECT
                );
                header("Content-Type: application/json");
                echo $response;
                exit;   
            }
        } else {
            $error = 'Security error';
            $response = json_encode(array(
                    'status' => false,
                    'error' => $error_html,
                    'modal' => true,
                )
                , JSON_FORCE_OBJECT    
            );
            header("Content-Type: application/json");
            echo $response;
            exit;
        }
    }
} else {
	$error = 'Security error';
	$response = json_encode(array(
            'status' => false,
            'error' => $error,
            'modal' => true,
        )
        , JSON_FORCE_OBJECT    
    );
	header("Content-Type: application/json");
	echo $response;
	exit;
}

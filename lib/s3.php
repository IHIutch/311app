<?php

define('ACCESS_KEY', getenv('ACCESS_KEY'));
define('SECRET_KEY', getenv('SECRET_KEY'));
define('S3_BUCKET', getenv('S3_BUCKET'));
    
function s3_image_upload($file, $orig) {
	$parts = explode('.', $orig);
	$ext = strtolower(end($parts));
	$name = 'uploads/'.str_replace('.', '', microtime(true)).substr(md5(mt_rand(1,99999999999999)), 0, 5).'.'.$ext;
    
    move_uploaded_file($file, $name);
    
	$s3 = new Aws\S3\S3Client([
        'region'  => 'us-east-2',
        'version' => 'latest',
        'credentials' => [
            'key'    => ACCESS_KEY,
            'secret' => SECRET_KEY,
        ]
    ]);	
    try {
        $result = $s3->putObject([
            'Bucket' => S3_BUCKET,
            'Key'    => $name,
            'Body' => file_get_contents($name),
            'ContentType' => 'image/'.$ext,
            'ACL'    => 'public-read'
        ]);

        // Print the URL to the object.
        echo $result['ObjectURL'] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";  
    }
    unlink($name);
	return 'https://s3.us-east-2.amazonaws.com/'.S3_BUCKET.'/'.$name;
}


//	if(isset($_FILES['image'])){
//		$file_name = $_FILES['image']['name'];   
//		$temp_file_location = $_FILES['image']['tmp_name']; 
//
//		$s3 = new Aws\S3\S3Client([
//            'region'  => 'us-east-2',
//            'version' => 'latest',
//            'credentials' => [
//                'key'    => "AKIAI46P2BFC3MKOPONA",
//                'secret' => "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",
//            ]
//        ]);	
//
//		$result = $s3->putObject([
//			'Bucket' => 'buffalo311',
//			'Key'    => $file_name,
//			'SourceFile' => $temp_file_location			
//		]);
//
//		var_dump($result);
//	}

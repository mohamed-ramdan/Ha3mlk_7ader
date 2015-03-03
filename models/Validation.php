<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function __autoload($classname) {
    $filename = $classname . ".php";
    include_once($filename);
}


	session_start();
	class Validation{
		public $errors =array();
		public function validate($data, $rules){
			$valid = TRUE;
			foreach ($rules as $fieldname => $rule) {
				$callbacks = explode('|', $rule);
				foreach ($callbacks as $callback) {

					$value = isset($data[$fieldname])? $data[$fieldname] : NULL;
					if ($this->$callback($value,$fieldname) == false){
						$valid=FALSE;

					}
				}
			}
			return $valid;

		}
		public function validateimg($data,$fieldname){
			$imgvalid=TRUE;

			if ($data[$fieldname]['error'] > 0)
			{
				switch ($data[$fieldname]['error'])
				{
					case 1: $this->errors[] = 'File exceeded upload_max_filesize';
					break;
					case 2: $this->errors[] = 'File exceeded max_file_size';
					break;
					case 3: $this->errors[] = 'File only partially uploaded';
					break;
					case 4: $this->errors[] = 'No file uploaded';
					break;
					case 6: $this->errors[] = 'Cannot upload file: No temp directory specified';
					break;
					case 7: $this->errors[] = 'Upload failed: Cannot write to disk';
					break;
				}
				$imgvalid= FALSE;
				return $imgvalid;
			}
			if($data[$fieldname]['type'] != 'image/jpeg'){
				$this->errors[] = 'Problem: file is not an image';
				$imgvalid= FALSE; 
			}
			return $imgvalid;
		}
		function email($value, $fieldname){
			$valid = filter_var($value,FILTER_VALIDATE_EMAIL);
			if($valid == FALSE){
				$this->errors[] = "The $fieldname needs to be valid email";
				return $valid;
			}		
		}
		function required($value, $fieldname){
			$valid = !empty($value);
			if($valid == FALSE){
				$this->errors[] = "The $fieldname is required";
				return $valid;
			}
		}
		function match($value, $fieldname){
			
			if($value != $_SESSION['digit']){
				$valid=FALSE;
				$this->errors[] = "The $fieldname doesn't match the image text";
				return $valid;
			}
		}
                function unique($value, $fieldname){
			include_once "../controllers/AuthenticationController.php";
                        $authobj=new Authenticate;
                        $users=$authobj->getUserWithEmail();
                                    
			if(count($users)>=1){
                            
				$valid=FALSE;
				$this->errors[] = "The $fieldname already taken";
				return $valid;
			}
		}
                function matchvalues($value, $fieldname){
			
			if($value != $_SESSION['passwd']){
				$valid=FALSE;
				$this->errors[] = "The $fieldname doesn't match the passsword";
				return $valid;
			}
		}
	}
?>
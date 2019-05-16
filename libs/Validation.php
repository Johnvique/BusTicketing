<?php
class Validation{
	public static $regexes = Array(
    		'date' => "^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2}\$",
    		'amount' => "^[-]?[0-9]+\$",
    		'number' => "^[-]?[0-9,]+\$",
    		'alfanum' => "^[0-9a-zA-Z ,.-_\\s\?\!]+\$",
    		'not_empty' => "[a-z0-9A-Z]+",
    		'words' => "^[A-Za-z]+[A-Za-z \\s]*\$",
    		'phone' => "^[0-9]{10,11}\$",
    		'zipcode' => "^[1-9][0-9]{3}[a-zA-Z]{2}\$",
    		'plate' => "^([0-9a-zA-Z]{2}[-]){2}[0-9a-zA-Z]{2}\$",
    		'price' => "^[0-9.,]*(([.,][-])|([.,][0-9]{2}))?\$",
    		'2digitopt' => "^\d+(\,\d{2})?\$",
    		'2digitforce' => "^\d+\,\d\d\$",
    		'anything' => "^[\d\D]{1,}\$"
    );
	private $default_error_msg=array(
		"ipv4"=>"Invalid IPv4",
		"ipv6"=>"Invalid IPv6",
		"string"=>"Invalid String",
		"integer"=>"Invalid Interger",
		"numeric"=>"Invalid number",
		"url"=>"Invalid url",
		"alphanumeric"=>"Invalid alphanumeric",
		"bool"=>"is invalid",
		"date"=>" is not correct date"
		);
    /*
    * @errors array
    */
    public $errors = array();

    /*
    * @the validation rules array
    */
    private $validation_rules = array(); /*
	
	/*
    * @the validation Error Messages array
    */
    private $validation_error_msgs = array(); /*

    /*
     * @the sanitized values array
     */
    public $sanitized = array();
     
    /*
     * @the source 
     */
    private $source = array();


    /**
     *
     * @the constructor, duh!
     *
     */
    public function __construct()
    {
    }

    /**
     *
     * @add the source
     *
     * @paccess public
     *
     * @param array $source
     *
     */
    public function addSource($source, $trim=false)
    {
        $this->source = $source;
    }


    /**
     *
     * @run the validation rules
     *
     * @access public
     *
     */
    public function run()
    {
        /*** set the vars ***/
        foreach( new ArrayIterator($this->validation_rules) as $var=>$opt)
        {
            
			if(!isset($this->source[$var]) && $opt['required'] == true){
				$this->errors[$var] = $var . ' is not set';
			}
			
			if (array_key_exists($var,$this->source)){
				/*** Trim whitespace from beginning and end of variable ***/
				if( array_key_exists('trim', $opt) && $opt['trim'] == true )
				{
					$this->source[$var] = trim( $this->source[$var] );
				}
				
				$this->validation_error_msgs[$var]=$opt["error_msg"];
				
				switch(strtolower($opt['type']))
				{
					case 'email':
						$this->validateEmail($var, $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeEmail($var);
						}
						break;

					case 'url':
						$this->validateUrl($var);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeUrl($var);
						}
						break;

					case 'numeric':
						$this->validateNumeric($var, $opt['min'], $opt['max'], $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeNumeric($var);
						}
						break;

					case 'string':
						$this->validateString($var, $opt['min'], $opt['max'], $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeString($var);
						}
					break;
					
					case 'anything':
						$this->validateAnything($var, $opt['min'], $opt['max'], $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeAnything($var);
						}
					break;

					case 'integer':
						$this->validateInteger($var, $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeInteger($var);
						}
						break;

					case 'ipv4':
						$this->validateIpv4($var, $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeIpv4($var);
						}
						break;

					case 'ipv6':
						$this->validateIpv6($var, $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeIpv6($var);
						}
						break;

					case 'bool':
						$this->validateBool($var, $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitized[$var] = (bool) $this->source[$var];
						}
						break;
						
					case 'aphanumeric':
						$this->validateString($var, $opt['min'], $opt['max'], $opt['required']);
						if(!array_key_exists($var, $this->errors))
						{
							$this->sanitizeString($var);
						}
						break;
				}
			
			}
		}
    }


    /**
     *
     * @add a rule to the validation rules array
     *
     * @access public
     *
     * @param string $varname The variable name
     *
     * @param string $type The type of variable
     *
     * @param bool $required If the field is required
     *
     * @param int $min The minimum length or range
     *
     * @param int $max the maximum length or range
     *
     */
    public function addRule($varname, $type, $required=false, $min=0, $max=0, $trim=false,$error_msg=null)
    {
        $this->validation_rules[$varname] = array('type'=>$type, 'required'=>$required, 'min'=>$min, 'max'=>$max,'trim'=>$trim, 'error_msg'=>$error_msg);
        /*** allow chaining ***/
        return $this;
    }


    /**
     *
     * @add multiple rules to teh validation rules array
     *
     * @access public
     *
     * @param array $rules_array The array of rules to add
     *
     */
    public function AddRules(array $rules_array)
    {
        $this->validation_rules = array_merge($this->validation_rules, $rules_array);
    }
	
	private function SetValidationError($var,$type){
		if($this->validation_error_msgs[$var]!=null){
			$this->errors[$var] = $this->validation_error_msgs[$var];
		}
		else{
			$this->errors[$var] =  $this->default_error_msg[$type];
		}
	}
    /**
     *
     * @Check if POST variable is set
     *
     * @access private
     *
     * @param string $var The POST variable to check
     *
     */
    private function is_set($var)
    {
        if(!isset($this->source[$var]))
        {
            $this->errors[$var] = $var . ' is Required';
        }
    }



    /**
     *
     * @validate an ipv4 IP address
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateIpv4($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === FALSE)
        {
			$this->SetValidationError($var,"ipv4");
        }
    }

    /**
     *
     * @validate an ipv6 IP address
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    public function validateIpv6($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if(filter_var($this->source[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === FALSE)
        {
			$this->SetValidationError($var,"ipv6");
           
        }
    }
	
    /**
     *
     * @validate a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param int $min the minimum string length
     *
     * @param int $max The maximum string length
     *
     * @param bool $required
     *
     */
    private function validateString($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if(isset($this->source[$var]))
        {
            if(strlen($this->source[$var]) < $min)
            {
               $this->SetValidationError($var,"string");
            }
            elseif(strlen($this->source[$var]) > $max)
            {
                $this->SetValidationError($var,"string");
            }
            elseif(!is_string($this->source[$var]))
            {
				$this->SetValidationError($var,"string");
            }
        }
    } 
	private function validateAnything($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if(isset($this->source[$var]))
        {
            if(strlen($this->source[$var]) < $min)
            {
               $this->SetValidationError($var,"string");
            }
            elseif(strlen($this->source[$var]) > $max)
            {
                $this->SetValidationError($var,"string");
            }
        }
    } 
	
	private function validateAlphanumeric($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if(isset($this->source[$var]))
        {
            if(strlen($this->source[$var]) < $min)
            {
                $this->errors[$var] = $var . ' is too short';
            }
            elseif(strlen($this->source[$var]) > $max)
            {
                $this->errors[$var] = $var . ' is too long';
            }
            else{
				$returnval =  filter_var($var, FILTER_VALIDATE_REGEXP, array("options"=> array("regexp"=>'!'.self::$regexes['alfanum'].'!i'))) !== false;
				if(!$returnval)
					$this->SetValidationError($var,"alphanumeric");
            }
        }
    }

    /**
     *
     * @validate an integer number
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param int $min The minimum number range
     *
     * @param int $max The maximum number range
     *
     * @param bool $required
     *
     */
    private function validateInteger($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))===FALSE)
        {
			$this->SetValidationError($var,"integer");
        }
    }
	
	/**
     *
     * @validate a numeric value
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param int $min The minimum number range
     *
     * @param int $max The maximum number range
     *
     * @param bool $required
     *
     */
    private function validateNumeric($var, $min=0, $max=0, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_FLOAT, array("options" => array("min_range"=>$min, "max_range"=>$max)))===FALSE)
        {
			$this->SetValidationError($var,"numeric");
        }
    }

    /**
     *
     * @validate a url
     *
     * @access private
     *
      * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateUrl($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_URL) === FALSE)
        {
			$this->SetValidationError($var,"url");
        }
    }


    /**
     *
     * @validate an email address
     *
     * @access private
     *
     * @param string $var The variable name 
     *
     * @param bool $required
     *
     */
    private function validateEmail($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if(filter_var($this->source[$var], FILTER_VALIDATE_EMAIL) === FALSE)
        {
			$this->SetValidationError($var,"email");
        }
    }


    /**
     * @validate a boolean 
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param bool $required
     *
     */
    private function validateBool($var, $required=false)
    {
        if($required==false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        filter_var($this->source[$var], FILTER_VALIDATE_BOOLEAN);
        {
			$this->SetValidationError($var,"boolean");
        }
    }

    ########## SANITIZING METHODS ############
    

    /**
     *
     * @santize and email
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @return string
     *
     */
    public function sanitizeEmail($var)
    {
        $email = preg_replace( '((?:\n|\r|\t|%0A|%0D|%08|%09)+)i' , '', $this->source[$var] );
        $this->sanitized[$var] = (string) filter_var($email, FILTER_SANITIZE_EMAIL);
    }


    /**
     *
     * @sanitize a url
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeUrl($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var],  FILTER_SANITIZE_URL);
    }

    /**
     *
     * @sanitize a Interger value
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeInteger($var)
    {
        $this->sanitized[$var] = (int) filter_var($this->source[$var], FILTER_SANITIZE_NUMBER_INT);
    }
	
	
	/**
     *
     * @sanitize a numeric value
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
	private function sanitizeNumeric($var)
    {
        $this->sanitized[$var] = (int) filter_var($this->source[$var], FILTER_SANITIZE_NUMBER_FLOAT);
    }

    /**
     *
     * @sanitize a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeString($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var], FILTER_SANITIZE_STRING);
    }
	
	/**
     *
     * @sanitize any character
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeAnything($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var]);
    }

} /*** end of class ***/
?>
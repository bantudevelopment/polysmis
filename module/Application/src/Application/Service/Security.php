<?php

namespace Application\Service;

/**
 * Handles all security functions in the system
 *
 * @author hkumwembe
 */
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\Query\ResultSetMapping;


class Security implements ServiceLocatorAwareInterface{
    
    protected $authserv;
    protected $servicelocator;
    private $password;
    private $username;
    private $IPaddress;
    private $passwordLastChanged;
    private $loginTimes;
    private $lastLoginIp;
    private $lastLoginDate;
    private $loginDate;


    public function __construct() {
        
    }
    
    public function getServiceLocator() {
        return $this->servicelocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->servicelocator = $serviceLocator;
    }
    
    /*
     * Set the values of password
     */
    
    public function setPassword($password){
        $this->password = $password;
    }
    
    /*
     * Get password
     */
    
    public function getPassword(){
        return $this->password;
    }
    
    /*
     * Set the values of username
     */
    
    public function setUsername($username){
        $this->username = $username;
    }
    
    /*
     * Get username
     */
    
    public function getUsername(){
        return $this->username;
    }
    
    
    /*
     * Check if user account password has expired
     * @return boolean
     */
    public function hasPasswordExpired($userid,$em){
        
        $settings = $em->getRepository("\Application\Entity\Settings")->find(1);
        
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('Application\Entity\User', 'u');
        $rsm->addFieldResult('u', 'PASSWORDLASTCHANGED', 'passwordlastchanged');

        $query = $em->createNativeQuery("SELECT PASSWORDLASTCHANGED FROM user "
                                      . " where DATEDIFF(CURDATE(),PASSWORDLASTCHANGED) > :num1 AND PK_USERID = :num2  ",$rsm);
                 $query->setParameter('num1',$settings->getPasswordExpireydays());
                 $query->setParameter('num2',$userid);
        
        return (count($query->getResult())>0)?true:false;
    } 
    
    /*
     * Check if provided password is strong
     * @retun boolean
     */
    public function isStrongPassword($password){
        return true;
    } 
    
    /*
     * Authenticate user login 
     */
    public function auth($username,$password){

        $errors= "";
        
        $sm = $this->getServiceLocator();
        $this->authserv = $sm->get('Zend\Authentication\AuthenticationService');
        
        $adapter = $this->authserv->getAdapter();
        $adapter->setIdentityValue($username);
        $adapter->setCredentialValue($password);
        
        $authResult = $this->authserv->authenticate();
        
        if ($authResult->isValid()) {
            
            
            
            //If false, log access. Set the account into session
            
            $identity = $authResult->getIdentity();
            $this->authserv->getStorage()->write($identity);
            
        }else{
            //Authentication has errors
            $errors = $this->_authenticationErrors($authResult->getCode());
        }
        
        return $errors;
    }
    
    
    /*
     * Authenticate new student
     */
    public function authNewStudent($username,$password,$em){

        $exist = $em->getRepository("\Application\Entity\Enrollment")->findOneBy(array("emailaddress"=>$username,"temppwd"=>$password));
        return $exist;
    }


    public function _hashing($str){
        $salt = '';
  	for ($i=1;$i<=10;$i++) {
    		$salt .= substr('0123456789abcdef',rand(0,15),1);
  	}
  	/* This encryption works if PHP version >= 5 */
  	//$hash[0] = "{SHA}".base64_encode(sha1( $str, TRUE ));
        $hash = "{SHA}".base64_encode(sha1( $str, TRUE ));

  	/* This encryption works if PHP version < 5 */	
  	//$hash[0] = "{SSHA}".base64_encode(pack("H*",sha1($pass.$salt)).$salt);

  	//$hash[1] = bin2hex(mhash(MHASH_MD4,iconv("UTF-8","UTF-16LE",$str)));

  	return $hash;
    }
    
    
    function tempPassword($length=6, $strength=2) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
    }
    
    
    
    
    public function _authenticationErrors($errorCode){
        $errors = "";
        switch ($errorCode) {
            case \Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND:
                    $errors['username'] =  'Username not found';
                break;
            case \Zend\Authentication\Result::FAILURE_IDENTITY_AMBIGUOUS:
                    $errors['username'] =  'Multiple users found with this identity!';
                break;
            case \Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID:
                    $errors['password'] = 'Invalid password';
                break;
            default:
                $errors[] = "Login failure"; //$result->getMessages();
        }
        
        return $errors;
    }

   

}

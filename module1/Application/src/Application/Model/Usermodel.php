<?php
namespace Application\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usermodel
 *
 * @author hkumwembe
 */
use Doctrine\Common\Collections\Criteria;

abstract class Usermodel extends Commonmodel {
    
    private $surname;
    private $firstname;
    private $gender;
    private $userid;
    private $password;
    private $username;
    private $title;
    private $accountType;
    private $role;
    
    /*
     * Setters
     */
    public function setSurname($surname){
        $this->surname = $surname;
    }
    
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }
    
    public function setGender($gender) {
        $this->gender = $gender;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function setUserid($userid) {
        $this->userid = $userid;
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function setAccountType($accountType) {
        $this->accountType = $accountType;
    }
    
   
    /*
     * Getters
     */
    public function getSurname(){
        return $this->surname;
    }
    
    public function getFirstname() {
        return $this->firstname;
    }
    
    public function getGender() {
        return $this->gender;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getUserid() {
        return $this->userid;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getAccountType() {
        return $this->accountType;
    }
    
    /*
     * Save user information
     */
//    public function saveUserObject($userobject){
//        
//        if(!$userobject->getPkUserid()){
//            $user = new \Application\Entity\User();
//        }else{
//            $user = $this->em->getRepository("\Application\Entity\User")->find($userobject->getPkUserid());
//        }
//        
//        //Set user object values to be saved
//        $user->setTitle($userobject->getTitle());
//        $user->setFirstname($userobject->getFirstname());
//        $user->setSurname($userobject->getSurname());
//        $user->setFkRoleid($userobject->getFkRoleid());
//        $user->setUsername($userobject->getUsername());
//        $user->setEmailAddress($userobject->getEmailAddress());
//        $user->setGender($userobject->getGender());
//        $user->setInitial($userobject->getInitial());
//        $user->setPhotoUrl($userobject->getPhotoUrl());
//        $user->setDateCreated($userobject->getDateCreated());
//        $user->setLastLoginDate($userobject->getLastLoginDate());
//        $user->setIpaddress($userobject->getIpaddress());
//        $user->setPassword($userobject->getPassword());
//        
//        try{
//            //Commit values set to the object 
//            if(!$userobject->getPkUserid()){
//                $this->em->persist($user);
//            }
//            
//            //Save values if just updating record
//            $this->em->flush($user);
//            return $user;
//            
//        }catch(Exception $e){
//            throw("Failed to save");
//        }
//        
//    }
    
    
    /*
     * Sets user object values
     */
//    public function setUserObject($arrayval){
//        //Set parameters
//        $object = new \Application\Entity\User();
//        
//        $object->setFkRoleid($arrayval['role']);
//        $object->setUsername($arrayval['username']);
//        $object->setTitle($arrayval['title']);
//        $object->setPhotoUrl($arrayval['url']);
//        $object->setSurname($arrayval['surname']);
//        $object->setFirstname($arrayval['firstname']);
//        $object->setGender($arrayval['gender']);
//        $object->setInitial($arrayval['initial']);
//        $object->setDateCreated($arrayval['datecreated']);
//        $object->setEmailAddress($arrayval['emailaddress']);
//        $object->setPassword($arrayval['password']);
//        $object->setIpaddress($arrayval['ipaddress']);
//        $object->setLastLoginDate($arrayval['logindate']);
//        
//        return $object;
//    }
    
    
    
    abstract function registerUser($object);
    
    abstract function assignModule($moduleparams);
    
    
    
}

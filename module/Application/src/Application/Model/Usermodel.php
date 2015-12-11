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
    
    abstract function registerUser($object);
    
    abstract function assignModule($moduleparams);
    
    
    
}

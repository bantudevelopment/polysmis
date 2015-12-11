<?php
namespace Application\Model;

/**
 * Description of Admission
 *
 * @author hkumwembe
 */
use \Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Zend\Paginator\Paginator;
class Admission extends Commonmodel {

    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->em = $em;
    }
    
    /*
     * Get enrolled student list
     */
    public function getEnrolledList($post){

        $itemsperpage = !empty($post['itemcount'])?$post['itemcount']:50;
        $currentdate = new \DateTime();

        //Get current academic periods
        $criteriap = Criteria::create()
                    ->where(Criteria::expr()->lte('startDate',$currentdate))
                    ->andWhere(Criteria::expr()->gte('endDate',$currentdate))
                    ->orderBy(array("startDate"=> Criteria::ASC));
        $academicperiods = $this->getEntity("\Application\Entity\Academicperiod",$criteriap);
        
        //Get classes or groups
        $condition = Criteria::create()
                    ->orderBy(array("groupName"=> Criteria::ASC));
        $classes = $this->getEntity("\Application\Entity\Programgroup",$condition);
        
        //Set criteria for student enrollment
        $criteria = Criteria::create()
                    ->orderBy(array("surname"=> Criteria::ASC,"firstname"=>  Criteria::ASC));            
        if($post['search']){
            //Get search parameter values
            
            if(!empty($post['period'])){
                
                $period = $this->em->getRepository('\Application\Entity\Academicperiod')->find($post['period']);
                $criteria->where(Criteria::expr()->eq('fkPeriodid', $period));
            }
            if(!empty($post['class'])){
                $class = $this->em->getRepository('\Application\Entity\Programgroup')->find($post['class']);
                $criteria->andWhere(Criteria::expr()->eq('fkGroupid', $class));
            }
        }
        
        $students = $this->getEntity("\Application\Entity\Enrollment",$criteria); 
        
        $paginator = new Paginator(
                     new Adapter($students)
                );
        
        $paginator->setCurrentPageNumber(1)
                  ->setItemCountPerPage($itemsperpage);
        
        
        return  array("enrolledlist"=>$paginator,"academicperiod"=>$academicperiods,"classes"=>$classes);
        
    }
    
    public function enrollmentUploadValidator($rowarray){
        
       //Set validation chain
       $validationchain = new \Zend\Validator\ValidatorChain();
         //Attach not empty validation  
        $emptyValidator = new \Zend\Validator\NotEmpty();
        $emptyValidator->setMessage("Required");
        $validationchain->attach($emptyValidator);
        
        if($rowarray['status'] == 'email'){ 
            
            $emailValidator          = new \Zend\Validator\EmailAddress();
            
            $emailmsg = array(\Zend\Validator\EmailAddress::INVALID  => "Invalid email",
                                               \Zend\Validator\EmailAddress::INVALID_FORMAT  => "Invalid email");
            $emailValidator->setMessages($emailmsg);
            
           //Attach email validation  
            $validationchain->attach($emailValidator);
        }    
            return $validationchain;
    }
    
    /*
     * Populate enrolled student array
     */
    public function getEnrolledStudentsArray($rowdata){
        $error = $class = array();

        $rowarray = array("surname"=>array("val"=>$rowdata[0],"status"=>"required"),
                          "firstname"=>array("val"=>$rowdata[1],"status"=>"required"),
                          "gender"=>array("val"=>$rowdata[3],"status"=>"required"),
                          "class"=>array("val"=>$rowdata[4],"status"=>"required"),
                          "period"=>array("val"=>$rowdata[5],"status"=>"required"),
                          "emailaddress"=>array("val"=>$rowdata[6],"status"=>"email"),
                          "entrymanner"=>array("val"=>$rowdata[7],"status"=>"required"),
                          "studymode"=>array("val"=>$rowdata[8],"status"=>"required"));
        foreach($rowarray as $name=>$row){
            $vchain = $this->enrollmentUploadValidator($row);
            if(!$vchain->isValid($row['val'])){
                $error[$name] = implode(" ", $vchain->getMessages());
            }
        }

        //Get group or class entity object
        $class                   = $this->em->getRepository("\Application\Entity\Programgroup")->findOneBy(array('groupCode'=>$rowdata[4])); //    $this->getEntity("\Application\Entity\Programgroup",$criteria); 
        
        
        $group                   = $class->getPkGroupid();
        $groupname               = $class->getGroupcode();

        
        //Get entry manner object
        $entrymannercriteria     = Criteria::create()
                                    ->where(Criteria::expr()->eq('entrycode', $rowdata[8]));
        $entry                   = $this->getEntity("\Application\Entity\Entrymanner",$entrymannercriteria);
        
        //Get study mode
        $mode                   = $this->em->getRepository("\Application\Entity\Studymode")->find($rowdata[7]);
        
        
        //Check if email address already exist in enrolled table            
        $emailcriteria           = Criteria::create()
                                   ->where(Criteria::expr()->eq('emailaddress', $rowdata[6]));
        $emailrows               = $this->getEntity("\Application\Entity\Enrollment",$emailcriteria); 
        if(count($emailrows)>0){
              $error['emailaddress'] = "Email address already exists";
        }
        
        //Check if student number already exists in the system
        $enrollment             = $this->em->getRepository("\Application\Entity\Enrollment")->findBy(array("tempstudentno"=>$rowdata[9]));
        if(count($enrollment)>0){
              $error['studentno'] = "Student number already exists";
        }
       
        $studentdata =  array("surname"=>$rowdata[0],"firstname"=>$rowdata[1],"initial"=>$rowdata[2],"gender"=>$rowdata[3],"fkGroupid"=>$group,"groupname"=>$groupname,"fkPeriodid"=>$rowdata[5],"emailaddress"=>$rowdata[6],"fkEntrymannerid"=>$entry[0]->getPkEntrymannerid(),"entrymanner"=>$entry[0]->getEntryName(),"fkStudymodeid"=>$mode->getPkStudymodeid(),"studymodetitle"=>$mode->getTitle(),"studentno"=>$rowdata[9]);

        return array("studentdata"=>$studentdata,"error"=>$error);
    }

    /*
    * Save user information
    */
    public function enrollstudent($studentobject){
        if(!$studentobject->getPkEnrollmentid()){
            $student = new \Application\Entity\Enrollment();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkEnrollmentid", $studentobject->getPkEnrollmentid()));
            //$student = $this->getEntity('\Application\Entity\Enrollment',$criteria)->find(array("pkEnrollmentid"=>$studentobject->getPkEnrollmentid()));
            $student = $this->getEntity('\Application\Entity\Enrollment',$criteria);
        }
        
        //Set user object values to be saved
        $student->setEmailaddress($studentobject->getEmailaddress());
        $student->setFirstname($studentobject->getFirstname());
        $student->setSurname($studentobject->getSurname());
        $student->setFkEntrymannerid($studentobject->getFkEntrymannerid());
        $student->setFkGroupid($studentobject->getFkGroupid());
        $student->setFkPeriodid($studentobject->getFkPeriodid());
        $student->setFkStudymode($studentobject->getFkStudymode());
        $student->setInitial($studentobject->getInitial());
        $student->setTempstudentno($studentobject->getTempstudentno());
        $student->setYearjoined($studentobject->getYearjoined());
        $student->setTemppwd($studentobject->getTemppwd());
        $student->setGender($studentobject->getGender());
  
        //Commit values set to the object 
        if(!$studentobject->getPkEnrollmentid()){
            $this->em->persist($student);
        }
        
        //Save values if just updating record
        $this->em->flush($student);
    }
    
    /*
     * Sets enrollment object values
     */
    public function setEnrollmentObject($arrayval){
        
        //Get class/group detail
        $class    = $this->em->getRepository('\Application\Entity\Programgroup')->find($arrayval['fkGroupid']);
        //Get entry manner
        $entry    = $this->em->getRepository('\Application\Entity\Entrymanner')->find($arrayval['fkEntrymannerid']);
        //Get study mode
        $mode     = $this->em->getRepository('\Application\Entity\Studymode')->find($arrayval['fkStudymodeid']);
        //Get academic period
        $period     = $this->em->getRepository('\Application\Entity\Academicperiod')->find($arrayval['fkPeriodid']);
        
        //Set parameters
        $studentobject = new \Application\Entity\Enrollment();
        $studentobject->setFkGroupid($class);
        $studentobject->setFkEntrymannerid($entry);
        $studentobject->setFkStudymode($mode);
        $studentobject->setFkPeriodid($period);
        $studentobject->setSurname($arrayval['surname']);
        $studentobject->setFirstname($arrayval['firstname']);
        $studentobject->setGender($arrayval['gender']);
        $studentobject->setTempstudentno($arrayval['studentno']);
        $studentobject->setInitial($arrayval['initial']);
        $studentobject->setYearjoined(new \DateTime());
        $studentobject->setEmailaddress($arrayval['emailaddress']);
        $studentobject->setTemppwd('testing');
        
        return $studentobject;
    }
    
    /*
     * Save student
     */
    public function autoregisterstudent($enrollmentid){
        
        //Search for enrollmentid
        $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq('pkEnrollmentid', $enrollmentid));
        $enrollmentobject = $this->getEntity("\Application\Entity\Enrollment", $criteria);

        //Search for student role
        $rolecriteria = Criteria::create()
                        ->where(Criteria::expr()->eq('roleName', 'STUD'));
        $roleobject = $this->getEntity("\Application\Entity\Role", $rolecriteria);
        
        //Search for a country
        $countrycriteria = Criteria::create()
                       ->where(Criteria::expr()->eq('countryCode', 'MWI'));
        $countryobject = $this->getEntity("\Application\Entity\Country", $countrycriteria);
        
        //Search entry manner
        $campuscriteria = Criteria::create()
                      ->where(Criteria::expr()->eq('campusName', 'Blantyre'));
        $campusobject = $this->getEntity("\Application\Entity\Campus", $campuscriteria);
        
        //District entity
        $district     = $this->em->getRepository('\Application\Entity\District')->find(1);
          
        $date = new \DateTime();
        
        //Set all array values for the object
        $student                =  new \Application\Model\Student($this->em);
        
        //Assign user table values
        $userdata               =  array("username"=>$enrollmentobject[0]->getEmailaddress(),"title"=>"","role"=>$roleobject[0],"surname"=>$enrollmentobject[0]->getSurname(),"firstname"=>$enrollmentobject[0]->getFirstname(),"initial"=>$enrollmentobject[0]->getInitial(),"gender"=>$enrollmentobject[0]->getGender(),"password"=>"test2","url"=>"","emailaddress"=>$enrollmentobject[0]->getEmailaddress(),"ipaddress"=>"","logindate"=>$date,"datecreated"=>$date);
        $userobject             =  $student->setUserObject($userdata);
        
        //Set  student object
        $studentdata            =  array("dob"=>$date,"country"=>$countryobject[0],"maritalstatus"=>"Single","district"=>$district);
        //Set student program object
        $studentprogramdata     =  array("entrymanner"=>$enrollmentobject[0]->getFkEntrymannerid(),"entryyear"=>$date,"program"=>$enrollmentobject[0]->getFkGroupid()->getFkProgramid(),"repeatinglevel"=>'1',"registrationnumber"=>$enrollmentobject[0]->getTempstudentno());
        
        //Set student class object
        $studentclassdata       =  array("examnumber"=>null,"campus"=>$campusobject[0],"class"=>$enrollmentobject[0]->getFkGroupid(),"period"=>$enrollmentobject[0]->getFkPeriodid(),"isregistered"=>"1","studymode"=>$enrollmentobject[0]->getFkStudymode(),"registrationdate"=>$date);
        
        $allocateobjects        = array("user"=>$userobject,"student"=>$studentdata,"program"=>$studentprogramdata,"class"=>$studentclassdata);
        
        $student->allocate($allocateobjects); 
        
        //Delete in enrollment record for the student
        $student->deletefromdb('\Application\Entity\Enrollment',$enrollmentid);
    }
    
    
    
    
    
    
    
    
    
}

<?php
namespace AdminModule;
use Nette;
use Nette\Security\User;

class BasePresenter extends \Nette\Application\UI\Presenter {
   
       
   public function startup() {
        parent::startup();
           if(!$this->user->isLoggedIn()){
               $this->redirect('Start:default');
              
            }
           $roles = $this->user->getRoles();
           if($roles[0] != 1){
               
                $this->redirect('Start:default');
           }
   }   
   public function beforeRender() {
        $this->setLayout('layoutSignAdmin');          
   }
   
   public function handlelogout() {
      $this->user->logout();
      $this->redirect('Start:default');
   }




   public function __construct()
        {
            
            
        }  
}     


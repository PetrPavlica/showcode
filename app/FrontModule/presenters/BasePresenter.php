<?php
namespace FrontModule;

class BasePresenter extends \Nette\Application\UI\Presenter {
   
       
   public function startup() {
        parent::startup();
           if(!$this->user->isLoggedIn()){
               $this->redirect('Starts:default');
           }
   }   
   public function beforeRender() {
        $this->setLayout('layoutSignFront');
              
   }
   
   public function handlelogout() {
      $this->user->logout();
      $this->redirect('Starts:default');
   }
   
   public function __construct()
        {
            
            
        }  
}     


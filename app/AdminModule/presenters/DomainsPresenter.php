<?php
namespace AdminModule;

class DomainsPresenter extends BasePresenter{
        
    /** @var \IDomainsFactory @inject */
    public $domainsControl;
    
    /** @var \IDbFactory @inject */
    public $dbControl;
    
    /** @var \IDomainsFormFactory @inject */
    public $domainsFormControl;
    
    /** @var \IDbFormFactory @inject */
    public $dbFormControl;
    
    /** @var \IAddDbLoginFormFactory @inject */
    public $addDbLoginFormControl;
    
     /** @var \IAddDbUserFormFactory @inject */
    public $addDbUserFormControl;
    
     /** @var \IAddDomainsUserFormFactory @inject */
    public $addDomainsUserFormControl;
    
     /** @var \IPassFormFactory @inject */
    public $passFormControl;
    
     /** @var \ISendPassFormFactory @inject */
    public $sendPassFormControl;
    
    /** @var \App\Model\DomainsModel @inject */
    public $domainsData;
     
    protected function createComponentDomains(): \DomainsComponent {
        
        $component = $this->domainsControl->create();
        
        return $component;
    }
    
    protected function createComponentDomainsForm(): \DomainsForm {
        
        $component = $this->domainsFormControl->create();
        return $component;
    }
    
    protected function createComponentDbForm(): \DbForm {
        
        $component = $this->dbFormControl->create();
        return $component;
    }
    
     protected function createComponentDb(): \DbComponent {
        
        $component = $this->dbControl->create($this->getParameter('domain_id'));
        return $component;
    }
    
     protected function createComponentAddDbUserForm(): \AddDbUserForm {
        
        $component = $this->addDbUserFormControl->create();
        return $component;
    }
    
        protected function createComponentAddDomainsUserForm(): \AddDomainsUserForm {

           $component = $this->addDomainsUserFormControl->create();
           return $component;
       }
       
       protected function createComponentSendPassForm(): \SendPassForm {

           $component = $this->sendPassFormControl->create();
           return $component;
       }
    
     protected function createComponentAddDbLoginForm(): \AddDbLoginForm {
        
        $component = $this->addDbLoginFormControl->create();
        return $component;
    }
    
     protected function createComponentPassForm(): \PassForm {
        $component = $this->passFormControl->create();
         $component->onPassSave[] = function (array $data_form) {
                    if($this->user->getIdentity()){
                        $hash = uniqid();
                        $data = ['id_send'=>$data_form['id_send'],'to_send'=>$data_form['to_send'],'hash'=>$hash,'users_id'=>$this->user->getId()];
                         $this->domainsData->addHash($data);
                         $this->redirect('Domains:show',['id_send'=>$data_form['id_send'],'to_send'=>$data_form['to_send'],'hash'=>$hash]);                    }
                    else{
                        $this->flashMessage('Chybné jméno nebo heslo');
                        $this->redirect('Start:default');
                    }
		};
        return $component;
    }
    
    public function renderDomains():void{
       
    }
    
    public function renderDb($domain_id=null):void{
        
        $this->template->domain_id = $domain_id;
    }
    
    public function renderShow($id_send,$to_send,$hash):void{
        
        $pass_id = $this->domainsData->getPassId($id_send,$hash,$this->user->getId());
      if($to_send == 'domain'){
        $pass = $this->domainsData->domainsById($pass_id['id_send']); 
 
      }
      else{
        $pass = $this->domainsData->passById($pass_id['id_send']);
      }
        $this->template->pass = $pass['pass'];
    }
    
    public function renderLog() {
        $this->template->allLog = $this->domainsData->allLog();
    }
    
}

<?php
namespace FrontModule;

class DomainsFrontPresenter extends BasePresenter{
        
    /** @var \IDomainsFrontFactory @inject */
    public $domainsFrontControl;
    
    /** @var \IDbFrontFactory @inject */
    public $dbFrontControl;
    
     /** @var \IPassFrontFormFactory @inject */
    public $passFrontFormControl;
    
    /** @var \App\Model\DomainsModel @inject */
    public $domainsData;
     
    protected function createComponentDomainsFront(): \DomainsFrontComponent {
        
        $component = $this->domainsFrontControl->create();
        
        return $component;
    }
    
     protected function createComponentDbFront(): \DbFrontComponent {
        
        $component = $this->dbFrontControl->create($this->getParameter('domain_id'));
        return $component;
    }
    
     
     protected function createComponentPassFrontForm(): \PassFrontForm {
        $component = $this->passFrontFormControl->create();
         $component->onPassFrontSave[] = function (array $data_form) {
                    if($this->user->getIdentity()){
                        $hash = uniqid();
                        $data = ['id_send'=>$data_form['id_send'],'to_send'=>$data_form['to_send'],'hash'=>$hash,'users_id'=>$this->user->getId()];
                         $this->domainsData->addHash($data);
                         $this->redirect('DomainsFront:show',['id_send'=>$data_form['id_send'],'to_send'=>$data_form['to_send'],'hash'=>$hash]);                    }
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
        bdump($to_send);
      }
      else{
        $pass = $this->domainsData->passById($pass_id['id_send']);
      }
        $this->template->pass = $pass['pass'];
    }
    
    
    
}

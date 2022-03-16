<?php

class DomainsForm extends Nette\Application\UI\Control
{
    private $domainsData;
    
    private $factory;
    private $passwords;        
    public $onDomainFormSave;
    
    private $id=0;
    private $action = 'new';     
    public function __construct(Nette\Security\Passwords $passwords,App\Model\DomainsModel $domainsData,\App\Forms\FormFactory $factory)
    {
        $this->passwords = $passwords;
        $this->domainsData = $domainsData;
        $this->factory = $factory;
    }
    
    public function handleedit($id){
        $data_default = $this->domainsData->domainsById($id);
        $this['domainsForm']->setDefaults($data_default);
        $this->id = $id;
        $this['domainsForm']['action']->setDefaultValue('edit');
    }
    
    
    
    public function createComponentDomainsForm() 

    {
        $form = $this->factory->create();
        
        $form->addText('domain','Doména:')
                        ->setRequired('Zadejte doménu');
        
       $form->addText('ftp','FTP:')
                        ->setRequired('Zadejte FTP');
                
        $form->addText('login','Login:')
                        ->setRequired('Zadejte telefon');
          
        $form->addText('pass','Heslo:')
                        ->setRequired('Zadejte heslo');
               
        $form->addHidden('id',$this->id);
        $form->addHidden('action',$this->action);
        
        $form->addSubmit('send', 'Uložit')
        ->setAttribute('class', 'btn btn-info btn-sm');   

       
        $form->onSuccess[] = [$this, 'processForm'];
        return $form;
    }

    public function processForm($form)
    {
             
        $data = $form->getValues();
        unset($data['action']);
        if($form['action']->getValue() == 'new'){
           unset($data['id']);
           unset($data['domain_id']);
           $save = $this->domainsData->addDomain($data);
        }
        else{
           $save = $this->domainsData->updateDomains($form['id']->getValue(),$data);
        }
        $this->domainsData->addLog(['text'=>'Doména uložena','users_id'=>$this->presenter->getUser()->getId()]);
        $this->presenter->flashMessage('Uloženo');
        $this->onDomainFormSave($save);

    }
    
    public function render(){
       $this->template->render(__DIR__ .'/domainsform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IDomainsFormFactory
{
    /** @return \DomainsForm */
    function create();
}

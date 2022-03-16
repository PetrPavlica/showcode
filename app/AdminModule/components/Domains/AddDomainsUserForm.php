<?php

class AddDomainsUserForm extends Nette\Application\UI\Control
{
    private $domainsData;
    
    private $factory;
    private $passwords;        
    public $onAddDomainsUserFormSave;
    
    private $id=0;
    private $db_id;
    private $action = 'new';     
    public function __construct(Nette\Security\Passwords $passwords,App\Model\DomainsModel $domainsData,\App\Forms\FormFactory $factory)
    {
        $this->passwords = $passwords;
        $this->domainsData = $domainsData;
        $this->factory = $factory;
    }
    
    public function handleadd($domain_id){
        $this->domains_id = $domain_id;
        $this->action = 'update';
    }
    
    public function handledel($id){
        $this->domainsData->updateDomainsUserLogin($id,['del'=>1,'date_del'=>date('Y-m-d H:i:s')]);
        $this->action = 'delete';
    }
    
    
    public function createComponentAddDomainsUserForm() 

    {
        $form = $this->factory->create();
        $people = $this->domainsData->selectorPeople();
        $form->addHidden('domains_id');
        $form->addSelect('people_id','Login:',$people)
             ->setRequired('Zadejte Login');
                
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
        $save = $this->domainsData->addDomainsUser($data);
        $this->onAddDomainsUserFormSave($save);

    }
    
    public function render(){
       $this->template->render(__DIR__ .'/adddomainsuserform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IAddDomainsUserFormFactory
{
    /** @return \AddDomainsUserForm*/
    function create();
}

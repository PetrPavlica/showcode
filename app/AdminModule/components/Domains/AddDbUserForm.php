<?php

class AddDbUserForm extends Nette\Application\UI\Control
{
    private $domainsData;
    
    private $factory;
    private $passwords;        
    public $onAddDbUserFormSave;
    
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
        $this->domainsData->updateDbUserLogin($id,['del'=>1,'date_del'=>date('Y-m-d H:i:s')]);
        $this->action = 'delete';
    }
    
    public function createComponentAddDbUserForm() 

    {
        $form = $this->factory->create();
        $people = $this->domainsData->selectorPeople();
        $form->addHidden('db_login_id');
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
        if($form['action']->getValue() == 'new'){
           $save = $this->domainsData->addDbUser($data);
        }
        else{
           $save = $this->domainsData->updateDbLogin($form['id']->getValue(),$data);
        }
        $this->onAddDbUserFormSave($save);

    }
    
    public function render(){
       $this->template->render(__DIR__ .'/adddbuserform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IAddDbUserFormFactory
{
    /** @return \AddDbUserForm*/
    function create();
}

<?php

class AddDbLoginForm extends Nette\Application\UI\Control
{
    private $domainsData;
    
    private $factory;
    private $passwords;        
    public $onAddDbLoginFormSave;
    
    private $id=0;
    private $db_id;
    private $action = 'new';     
    public function __construct(Nette\Security\Passwords $passwords,App\Model\DomainsModel $domainsData,\App\Forms\FormFactory $factory)
    {
        $this->passwords = $passwords;
        $this->domainsData = $domainsData;
        $this->factory = $factory;
    }
    
    public function handleedit($id){
        $data_default = $this->peopleData->peopleById($id);
        $this['peopleForm']->setDefaults($data_default);
        $this->id = $id;
        $this->action = 'update';
    }
    
    public function handleadd($domain_id){
        $this->domains_id = $domain_id;
        $this->action = 'update';
    }
    
    public function createComponentAddDbLoginForm() 

    {
        $form = $this->factory->create();
        $dbs = $this->domainsData->selectorDb();
        $form->addSelect('db_id',$this->db_id,$dbs);
        
        $form->addText('login','Login:')
                        ->setRequired('Zadejte Login');
                
        $form->addText('pass','Heslo:')
                        ->setRequired('Zadejte server');
        
        $form->addText('login_for','Popis:');
                 
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
           $save = $this->domainsData->addDbLogin($data);
        }
        else{
           $save = $this->domainsData->updateDbLogin($form['id']->getValue(),$data);
        }
        $this->onAddDbLoginFormSave($save);

    }
    
    public function render(){
       $this->template->render(__DIR__ .'/adddbloginform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IAddDbLoginFormFactory
{
    /** @return \AddDbLoginForm */
    function create();
}

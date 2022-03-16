<?php

class DbForm extends Nette\Application\UI\Control
{
    private $domainsData;
    
    private $factory;
    private $passwords;        
    public $onDbFormSave;
    
    private $id=0;
    private $domains_id;
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
    
    public function createComponentDbForm() 

    {
        $form = $this->factory->create();
        $domains = $this->domainsData->selectorDomains();
        $form->addSelect('domains_id',$this->domains_id,$domains);
        
        $form->addText('db','Db:')
                        ->setRequired('Zadejte Db');
                
        $form->addText('server','Server:')
                        ->setRequired('Zadejte server');
          
        $form->addText('admin_adress','Adresa administrace');
               
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
           $save = $this->domainsData->addDb($data);
        }
        else{
           $save = $this->domainsData->updateDb($form['id']->getValue(),$data);
        }
        $this->onDbFormSave($save);

    }
    
    public function render(){
       $this->template->render(__DIR__ .'/dbform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IDbFormFactory
{
    /** @return \DbForm */
    function create();
}

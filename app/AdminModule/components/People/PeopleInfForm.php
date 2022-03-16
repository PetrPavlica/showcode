<?php

use App\Model\PeopleModel;
use Nette\Utils\Image;

class PeopleInfForm extends Nette\Application\UI\Control
{
    private $peopleData;
    private $factory;
    private $passwords;        
    public $onPeopleInfSave;
    private $action='new';
    private $id;
            
    public function __construct(Nette\Security\Passwords $passwords,App\Model\PeopleModel $peopleData,\App\Forms\FormFactory $factory,$id)
    {
        $this->passwords = $passwords;
        $this->peopleData = $peopleData;
        $this->factory = $factory;
        $this->id = $id;
    }
    
    public function handleedit($id){
        $data_default = $this->peopleData->peopleInfById($id);
        $this['peopleInfForm']->setDefaults($data_default);
        $this->id = $id;
        $this->action = 'edit';
    }
    
    public function createComponentPeopleInfForm() 

    {
        $form = $this->factory->create();
        
        $form->addHidden('people_id',$this->id);
               
        $form->addText('city','Mesto:');
         
        $form->addText('street','Ulice:');
          
        $form->addText('cp','Cp:');
        
        $form->addText('psc','Psc:');
        
        $form->addText('bank_number','Cislo uctu:');
        
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
            $save = $this->peopleData->addPeopleInf($data);
        }
        else{
            $save = $this->peopleData->updatePeopleInf($form['id']->getValue(),$data);
        }
        $this->onPeopleInfSave($this, $save);

    }
    
    public function render(){
       $this->template->id = $this->id;  
       $this->template->render(__DIR__ .'/peopleinfform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IPeopleInfFormFactory
{
    /** @return \PeopleInfForm */
    function create($id);
}

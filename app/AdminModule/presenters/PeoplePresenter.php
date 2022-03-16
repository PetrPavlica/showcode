<?php
namespace AdminModule;

class PeoplePresenter extends BasePresenter{
        
    /** @var \IPeopleFactory @inject */
    public $peopleControl;
    
    /** @var \IPeopleFormFactory @inject */
    public $peopleFormControl;

    /** @var \IPeopleInfFormFactory @inject */
    public $peopleInfFormControl;
    
    /** @var \App\Model\PeopleModel @inject */
    public $peopleData;
     
    protected function createComponentPeople(): \PeopleComponent {
        
        $component = $this->peopleControl->create();
        
        return $component;
    }
    
    protected function createComponentPeopleInfForm(): \PeopleInfForm {
        
        $component = $this->peopleInfFormControl->create($this->getParameter('id'));
        $component->onPeopleInfSave[] = function ($data) {
                    $this->redirect('People:people');
		};
        return $component;
    }
    
    protected function createComponentPeopleForm(): \PeopleForm {
        
        $component = $this->peopleFormControl->create();
        $component->onPeopleFormSave[] = function ($data) {
                    $this->redirect('People:peopleinf',['id' =>$data['id']]);
		};
        return $component;
    }
     
    public function renderPeople():void{
         $this->template->action = $this->getParameter('do');  
         bdump($this->getParameter('do'));
    }
    
    public function renderPeopleInf($id):void{
        
        
    }
    
    
}

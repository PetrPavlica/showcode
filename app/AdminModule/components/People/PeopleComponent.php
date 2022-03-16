<?php

class PeopleComponent extends Nette\Application\UI\Control
{
    private $peopleData;
    
    public function __construct(App\Model\PeopleModel $peopleData)
    {
        $this->peopleData = $peopleData;
    }
    
     public function handleactive($id,$active){
        $people = $this->peopleData->peopleById($id);
        if($active == 1){
          $save = $this->peopleData->updatePeople($id,['id'=>$id,'active'=>0]); 
           $this->peopleData->addLog(['text'=>'User '.$people['email']. ' activated','users_id'=>$this->presenter->getUser()->getId()]);
        }
        else{
          $save = $this->peopleData->updatePeople($id,['id'=>$id,'active'=>1]);
          $this->peopleData->addLog(['text'=>'User '.$people['email']. ' deactivated','users_id'=>$this->presenter->getUser()->getId()]);
        }       
    }
    
    public function render():void{
        
        $allPeople = $this->peopleData->allPeople();
        $this->template->allPeople = $allPeople;
        $this->template->render(__DIR__ .'/allpeople.latte');
    }
}

/** creator */
interface IPeopleFactory
{
    /** @return \PeopleComponent */
    function create();
}


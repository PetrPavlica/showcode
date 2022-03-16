<?php
declare(strict_types=1);

namespace AdminModule;

use Nette;


final class StartPresenter extends Nette\Application\UI\Presenter
{
  
    /** @var \ISignFormFactory @inject */
	public $signFormFactory;

    
    public function beforeRender() {
        $this->setLayout('layoutAdmin');
    }
        
	protected function createComponentSignForm()
	{
		$control = $this->signFormFactory->create();
		$control->onSignSave[] = function () {
                    if($this->user->getIdentity()){
                         $this->redirect('People:people');                    }
                    else{
                        $this->flashMessage('Chybné jméno nebo heslo');
                        $this->redirect('Start:default');
                    }
		};

		return $control;
	}
    
    function renderDefault():void{
        
    }
    
}



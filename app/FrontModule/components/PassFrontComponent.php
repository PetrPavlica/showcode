<?php

use Nette\Security\User;
    
class PassFrontForm extends Nette\Application\UI\Control
{
	private $database;

	public $onPassFrontSave;
        
           
        /** @var User */
	private $user;
        
	public function __construct(App\Model\AdminSignModel $database,User $user)
	{
		$this->database = $database;
                $this->user = $user;
	}

	protected function createComponentPassFrontForm()
	{
		$form = new Nette\Application\UI\Form;
                $form->addText('id_send');
                $form->addPassword('password','Heslo');
		$form->addSubmit('send', 'Odeslat');
		$form->onSuccess[] = [$this, 'processForm'];

		return $form;
	}

	public function processForm($form)
	{
                $values = $form->getValues();
              
    
                try {
                  $this->user->login($this->user->getIdentity()->name, $values['password']);
                } catch (Nette\Security\AuthenticationException $e) {
                        $this->flashMessage('Uživatelské jméno nebo heslo je nesprávné');
                }

                $id_send = explode('.', $values['id_send']);
		$this->onPassFrontSave(['id_send'=>$id_send[0],'to_send'=>$id_send[1]]);
	}


        public function render(){
             
              $template = $this->template;
              $template->setFile(__DIR__ . '/passfront.latte');
              $this->template->render();
        }
}

/** rozhraní pro generovanou továrničku */
interface IPassFrontFormFactory
{
	/** @return \PassFrontForm */
	function create();
}

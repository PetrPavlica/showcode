<?php
    
class SendPassForm extends Nette\Application\UI\Control
{
	private $domainsData;

	public $onSendPassSave;
        
	public function __construct(App\Model\DomainsModel $domainsData)
	{
		$this->domainsData = $domainsData;
	}

	protected function createComponentSendPassForm()
	{
		$form = new Nette\Application\UI\Form;
                $form->addHidden('id_send_email');
                $form->addText('email','email')
                        ->setRequired('Zadejte email');
		$form->addSubmit('send', 'Odeslat');
		$form->onSuccess[] = [$this, 'processForm'];

		return $form;
	}

	public function processForm($form)
	{       
          $values = $form->getValues();
          $what_id = explode('.', $values['id_send_email']);
          $hash = uniqid();
          $cthash = $this->domainsData->settingsByName('hash');
          $id_mail = $this->domainsData->addEmailHash(['email'=>$values['email'],'hash'=>$hash,'what_sended'=>$what_id[1],'pass_id'=>$what_id[0]]);
          $url = $this->getPresenter()->link(':Api:Api:pass',['cthash'=>$cthash['value'],'hash'=>$hash,'sid'=>$id_mail['id']]);
          $host = $this->getPresenter()->getHttpRequest()->getUrl()->getHostUrl();
          bdump($host.$url);
 	$mail = new Nette\Mail\Message;
        $mail->setFrom('test@gmail.com')
             ->addTo($values['email'])
             ->setSubject('Vyžádaný email')
             ->setHtmlBody('Heslo najdete zde:'.$host.$url);
            $mailer = new Nette\Mail\SendmailMailer;
            $mailer->send($mail);
	}


        public function render(){
             
              $template = $this->template;
              $template->setFile(__DIR__ . '/sendpass.latte');
              $this->template->render();
        }
}

/** rozhraní pro generovanou továrničku */
interface ISendPassFormFactory
{
	/** @return \SendPassForm */
	function create();
}

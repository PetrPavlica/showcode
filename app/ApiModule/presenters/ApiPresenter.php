<?php
declare(strict_types=1);

namespace ApiModule;

use Nette;



final class ApiPresenter extends Nette\Application\UI\Presenter
{      
    private $control_hash = 'ch240222S';
    
    /** @var \App\Model\ApiModel @inject */
    public $apiData; 
    
    
    function renderPass($cthash,$hash,$sid):void{
        
    if($cthash != $this->control_hash){
      $text='Neprošlokontrolou';  
    }
    else{
        $pass = $this->apiData->selectPassMail($hash,$sid);
        $text = 'Login: '.$pass['login'].' Password: '.$pass['pass'];
    }
    $this->template->text=$text;
    }
    
    
}



<?php
use Nette\Security\User;

class DomainsFrontComponent extends Nette\Application\UI\Control
{
    private $domainsData;
    private $user;
    
    public function __construct(App\Model\DomainsModel $domainsData,User $user)
    {
        $this->domainsData = $domainsData;
        $this->user = $user;
    }
    
   
    
    public function render():void{
        
        $allDomainsUser = $this->domainsData->allDomainsUser($this->user->getId());
        $allDomains = $this->domainsData->allDomains();
        $this->template->allDomains = $allDomains;
        $this->template->allDomainsUser = $allDomainsUser;

        $this->template->render(__DIR__ .'/alldomainsfront.latte');
    }
}

/** creator */
interface IDomainsFrontFactory
{
    /** @return \DomainsFrontComponent */
    function create();
}


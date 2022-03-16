<?php

class DomainsComponent extends Nette\Application\UI\Control
{
    private $domainsData;
    
    public function __construct(App\Model\DomainsModel $domainsData)
    {
        $this->domainsData = $domainsData;
    }
    
   
    
    public function render():void{
        
        $allDomains = $this->domainsData->allDomains();
        foreach ($allDomains as $domain){
            $logins = $this->domainsData->allUsersLoginsDomain($domain['id']);
            $allLogins[$domain['id']] = $logins;
            
        }
        bdump($allLogins);
        $this->template->allDomains = $allDomains;
        $this->template->allUsers = $allLogins;
        $this->template->selectorPeople = $this->domainsData->selectorPeople();
        $this->template->render(__DIR__ .'/alldomains.latte');
    }
}

/** creator */
interface IDomainsFactory
{
    /** @return \DomainsComponent */
    function create();
}


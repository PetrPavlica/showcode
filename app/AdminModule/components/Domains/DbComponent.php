<?php

class DbComponent extends Nette\Application\UI\Control
{
    private $domainsData;
    private $domain_id;
    
    public function __construct(App\Model\DomainsModel $domainsData,$domain_id)
    {
        $this->domainsData = $domainsData;
        $this->domain_id = $domain_id;
    }
    
    
    public function render():void{
        $allUsersLogin=null;
        $allLogins=null;
        $allDbs = $this->domainsData->allDbByDomain($this->domain_id);
        foreach ($allDbs as $db){
            $logins = $this->domainsData->allLoginByDb($db['id']);
            $allLogins[$db['id']] = $logins;
            foreach($logins as $login){
               $allUsersLogin[$db['id']][$login['id']] = $this->domainsData->allUsersLogins($login['id']); 
            }
            
        }
        $this->template->selectorPeople = $this->domainsData->selectorPeople();
        $this->template->allUsersLogin = $allUsersLogin;
        $this->template->allLogins = $allLogins;
        $this->template->allDbs = $allDbs;
        $this->template->render(__DIR__ .'/dbsdomain.latte');
    }
}

/** creator */
interface IDbFactory
{
    /** @return \DbComponent */
    function create($domain_id);
}


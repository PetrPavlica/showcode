<?php

class DbFrontComponent extends Nette\Application\UI\Control
{
    private $domainsData;
    private $domain_id;
    private $user;


    public function __construct(App\Model\DomainsModel $domainsData, \Nette\Security\User $user,$domain_id)
    {
        $this->domainsData = $domainsData;
        $this->domain_id = $domain_id;
        $this->user = $user;
    }
    
    
    public function render():void{
        
        $allDbs = $this->domainsData->allDbByDomain($this->domain_id);
        foreach ($allDbs as $db){
            $logins = $this->domainsData->allLoginByDb($db['id']);
            $allLogins[$db['id']] = $logins;
            foreach($logins as $login){
               $test = $this->domainsData->isUserLogin($this->user->getId(),$login['id']);
               if($test == 0){
                $allUsersLogin[$db['id']][$login['id']] = $this->domainsData->allUsersLogins($login['id']); 
                
               }
            }
            
        }

        $this->template->selectorPeople = $this->domainsData->selectorPeople();
        $this->template->allUsersLogin = $allUsersLogin;
        $this->template->allLogins = $allLogins;
        $this->template->allDbs = $allDbs;
        $this->template->render(__DIR__ .'/dbsdomainfront.latte');
    }
}

/** creator */
interface IDbFrontFactory
{
    /** @return \DbFrontComponent */
    function create($domain_id);
}


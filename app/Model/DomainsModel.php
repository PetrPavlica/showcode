<?php

namespace App\Model;

class DomainsModel extends BaseModel{
    
    public function allDomains() {
       return $this->database->table('domains')->fetchAll();
    }
    
    public function allDomainsUser($user_id) {
       $domains_user = $this->database->table('people_domains_login')
                ->where('people_id',$user_id)
                ->where('del',0)
                ->fetchPairs('domains_id','id'); 
       $domains = $this->database->table('domains')->fetchAll();
       bdump($domains_user);
       //$array_domains = $domains->toArray();
       foreach($domains as $domain){
           if(array_key_exists($domain['id'],$domains_user)){
               $array_domains[$domain['id']] = true;
           }
           else{
               $array_domains[$domain['id']] = false;
           }          
       }
   
       return $array_domains;
    }
    
    public function allDbByDomain($domain_id){
       return $this->database->table('db')
               ->where('domains_id',$domain_id)
               ->fetchAll();
    }
    
    public function allLoginByDb($db_id){
       return $this->database->table('db_login')
               ->where('db_id',$db_id)
               ->fetchAll();
    }
   
    public function isUserLogin($user_id,$login_id){
        return $this->database->table('people_db_login')
                ->where('db_login_id',$login_id)
                ->where('people_id',$user_id)
                ->where('del',0)
                ->count();
        
    }
    
    public function addDomain($data){
        return $this->database->table('domains')->insert($data);
    }
    
    public function addDb($data){
        return $this->database->table('db')->insert($data);
    }
    
    public function addDbLogin($data){
        return $this->database->table('db_login')->insert($data);
    }
    
    public function addDbUser($data){
        return $this->database->table('people_db_login')->insert($data);
    }
    
    public function addDomainsUser($data){
        return $this->database->table('people_domains_login')->insert($data);
    }
    
    public function addHash($data){
        return $this->database->table('db_login_users')->insert($data);
    }
    
    public function addEmailHash($data){
        return $this->database->table('sended_email')->insert($data);
    }
    
    public function allDomainsActive() {
       return $this->database->table('domains')->where('active',1);
   }
   
   public function selectorDomains() {
       return $this->database->table('domains')->fetchPairs('id','domain');
   }
   
   public function selectorDb() {
       return $this->database->table('db')->fetchPairs('id','db');
   }
   
   
   public function updateDomains($id,$data){
       $select = $this->database->table('domains')->where('id',$id)->fetch();
       return $select->update($data);
   } 
   
   public function updateDbUserLogin($id,$data){
       $select = $this->database->table('people_db_login')->where('id',$id)->fetch();
       return $select->update($data);
   } 

   public function updateDomainsUserLogin($id,$data){
       $select = $this->database->table('people_domains_login')->where('id',$id)->fetch();
       return $select->update($data);
   }
   
   public function domainsById($id){
        return $this->database->table('domains')->where('id',$id)->fetch();
    }
    
   
     public function selectorPeople(){
        return $this->database->table('people')->fetchPairs('id','name');
    }
    
    public function getPassId($pass_id,$hash,$users_id) {
      return $this->database->table('db_login_users')->where('id_send',$pass_id)
                                          ->where('hash',$hash)
                                          ->where('users_id',$users_id)
                                          ->fetch();
    }
    
     public function passById($id){
        return $this->database->table('db_login')->where('id',$id)->fetch();
    }
   
    public function allUsersLogins($db_login_id){
       return $this->database->table('people_db_login')
               ->where('db_login_id',$db_login_id)
               ->where('del',0)
               ->fetchAll();
    }
    
    public function allUsersLoginsDomain($domain_id){
       return $this->database->table('people_domains_login')
               ->where('domains_id',$domain_id)
               ->where('del',0)
               ->fetchAll();
    }
    
    public function getAllLoginsUser($people_id) {
       return $this->database->table('people_db_login')->where('people_id',$people_id)->fetch();
    }
    
    public function allLog() {
       return $this->database->table('log')->fetchAll();
    }
}
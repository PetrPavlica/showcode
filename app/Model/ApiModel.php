<?php

namespace App\Model;

class ApiModel extends BaseModel{
    
   
   public function selectPassMail($hash,$id){
        $pass_mail = $this->database->table('sended_email')->where('id',$id)->where('hash',$hash)->fetch();
        bdump($pass_mail);
        if($pass_mail['what_sended'] == 'domain'){
            $db= $this->database->table('domains')->where('id',$pass_mail['pass_id'])->fetch();
            return ['login'=>$db['login'],'pass'=>$db['pass']];
            
        }
        elseif($pass_mail['what_sended'] == 'db'){
            $db= $this->database->table('db_login')->where('id',$pass_mail['pass_id'])->fetch();
            return ['login'=>$db['login'],'pass'=>$db['pass']];
            
        }
        
   }  
   
}
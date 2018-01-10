<?php
class webServices
{
    public static function servicioGet($url)
    {
       $resp = file_get_contents($url);
        $resp = json_decode($resp,TRUE);
        return $resp;
        
        
    }
    
    public static function servicioPost($url, $data)
    {        
        try { 
                $data = json_encode($data);                
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                // Autenticacion Opcional:
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $retorno = curl_exec($curl);
                return true;            
        } catch (Exception $exc) {
            return false;
        }
    }
}
?>
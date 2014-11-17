<?php

/**
 *  API pour récupérer les stats d'un serveur sur RPG Paradize
 *  @author MineTheCube
 */
Class RpgStats {

    private $id;
    private $html;
    
    private $position;
    private $votes;
    private $out;

    // Magic methods
    
    public function __construct($id) {
        if (!ctype_digit((string)$id) or $id < 1)
            throw new Exception('L\'id du serveur est incorrect.');
        $this->id = (string)$id;
    }
    
    public function __toString() {
        $this->refresh(false);
        $json = new stdClass();
        $json->position = $this->position;
        $json->votes = $this->votes;
        $json->out = $this->out;
        return json_encode($json);
    }
    
    public function __get($name) {
        $this->refresh(false);
        if (isset($this->$name))
            return $this->$name;
        return null;
    }
    
    
    // Public methods
    
    public function refresh($forceRefresh = true) {
        if (!$forceRefresh and !empty($this->html))
            return true;
        $html = $this->query();
        if (empty($html))
            throw new Exception('Impossible d\'obtenir la page.');
        $this->html = $html;
        $this->position = intval($this->textBetween($html, '<br /><br /><b>Position ', '</b><br><br>Clic Sortant : '));
        $this->votes = intval($this->textBetween($html, '">Vote : ', '</a></div></td></tr></table>'));
        $this->out = intval($this->textBetween($html, '</b><br><br>Clic Sortant : ', '</td></tr></table><hr>'));
        return true;
    }
    
    public function getPosition() {
        $this->refresh(false);
        return $this->position;
    }
    
    public function getVotes() {
        $this->refresh(false);
        return $this->votes;
    }
    
    public function getOut() {
        $this->refresh(false);
        return $this->out;
    }
    
    
    // Private methods
    
    private function textBetween($data, $tagOpen, $tagClose) {
        $startIn = strpos($data, $tagOpen) + strlen($tagOpen);
        $endIn = strpos($data, $tagClose, $startIn);
        $result = substr($data, $startIn, $endIn - $startIn);
        return (empty($result) ? false : $result);
    }
    
    private function query() {
        $url = 'http://www.rpg-paradize.com/site--'.$this->id;
        $agent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36';
        $cookie = @tempnam ( '', 'cookie_' );
        if ($cookie === false)
            $cookie = @tempnam ( sys_get_temp_dir(), 'cookie_' );
        if ($cookie === false)
            $cookie = 'cookie.txt';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate,sdch");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}


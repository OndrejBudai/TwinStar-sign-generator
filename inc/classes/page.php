<?php
/*
 * Třída Page pro manipulaci s obsahem stránky s údaji o postavě
 *
 */

require_once('etc/parse_stats.php');

class page {

    public $page;

    /*
     * Konstruktor se pokusí získat zdrojový kód stránky s postavou danou v parametru.
     * Pokud je adresa nedostupná, vypíše chybu a ukončí skript.
     * Poté zkotroluje, jestli postava existuje, pokud ne, metoda vrátí 0, pokud ano, vrátí 1.
     */

    public function __construct(){
        global $armory;
        $this->page = $armory;

    }

    /*
     * Metoda, která zjistí info z javascript
     */

    public function get_infos($strs,$start=0){

        foreach($strs as $value){

            $tmp = $this->get_info($value,$start);

            //Clean "" from chars
            if($tmp[0]=="\"") $return[] = substr($tmp,1,strlen($tmp)-2);
            else $return[] = $tmp;

        }
        return $return;
    }

    private function get_info($parse_str,$start) {
        
        $pos1 = strpos($this->page,$parse_str,$start);
        $pos2 = strpos($this->page,';',$pos1);
        $pos1 += 3 + strlen($parse_str);
        return substr($this->page,$pos1,$pos2-$pos1);
    }

    public function get_race($id){
        static $return = array('Human','Orc','Dwarf','Night Elf','Undead','Tauren','Gnome','Troll','','Blood Elf','Draenei');
        return $return[$id-1];
    }

    public function get_from_html($start,$end){
        $pos1 = strpos($this->page,$start);
        $pos2 = strpos($this->page,$end,$pos1);
        $pos1 += strlen($start);
        return substr($this->page,$pos1,$pos2-$pos1);
    }

    public function check_guild(){
        if(strpos($this->page,"</h2>\r\n<h4>") === false) return 1;
        else return 0;
    }
}
?>
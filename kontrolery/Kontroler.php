<?php

abstract class Kontroler
{   // abstraktní třída pro obecný kontroler, ze kterého budou další kontrolery dědit

    protected $data = array();   // pole s daty pro ukládání dat získaných od modelů, data předá pohledu, pohled data vypíše uživateli - zrealizování předávání dat mezi modelem a pohledem
    protected $pohled = "";     //pro název pohledu, který se má vypsat
    protected $hlavicka = array('klicova_slova' => '', 'popis' => ''); //hlavička html stránky, kterou musí mít každá html stránka





    public function vypisPohled()
    {  //funkce vypíše pohled uživateli
        if ($this->pohled) { // pokud je pohled zadaný
            extract($this->osetri($this->data));  // rozbalí proměnné z pole $data 
            //  extract($this->data, EXTR_PREFIX_ALL, "");
            extract($this->data);
            require("pohledy/" . $this->pohled . ".phtml"); // tak ten pohled požadujeme
        }
    }

    public function presmeruj($url) // metoda pro jednoduché přesměrování
    {
        header("Location: /$url");   // resp. přesměrování na jinou stránku
        header("Connection: close");  // a zastavení zpracování současného skriptu
        exit;
    }
    abstract function zpracuj($parametry); // hlavní metoda ošetřující parametry

    private function osetri($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x)) {
            foreach ($x as $k => $v) {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        } else
            return $x;
    }
    // Ověří, zda je přihlášený uživatel, případně přesměruje na login
    public function overUzivatele($admin = false)
    {
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!$uzivatel || ($admin && !$uzivatel['admin'])) {
            $this->pridejZpravu('Nedostatečná oprávnění.');
            $this->presmeruj('prihlaseni');
        }
    }

    // Přidá zprávu pro uživatele
    public function pridejZpravu($zprava)
    {
        if (isset($_SESSION['zpravy']))
            $_SESSION['zpravy'][] = $zprava;
        else
            $_SESSION['zpravy'] = array($zprava);
    }

    // Vrátí zprávy pro uživatele
    public function vratZpravy()
    {
        if (isset($_SESSION['zpravy'])) {
            $zpravy = $_SESSION['zpravy'];
            unset($_SESSION['zpravy']);
            return $zpravy;
        } else
            return array();
    }
}

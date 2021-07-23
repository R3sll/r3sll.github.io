<?php

class SmerovacKontroler extends Kontroler
{


    protected $kontroler;

    private function upravitNazevKontroleru($text)
    {  // pro převod textu url
        $veta = str_replace('-', ' ', $text); // funkce pro nahrazení pomlčky na mezeru
        $veta = ucwords($veta);  // funkce pro zvětšení počátečního písmena všech slov ve větě
        $veta = str_replace(' ', '', $veta); // funkce pro odstranění mezer

        return $veta . 'Kontroler'; //vrácení výsledku
    }


    private function parsujURL($url)
    {  //metoda pro parsování url
        $naparsovanaURL = parse_url($url);   // parse_url pomůže oddělit část s protokolem a doménou od části s parametry
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");  // vrátí asoc. pole, část dostaneme pod indexem "path" - pozor na "/", tím může tato část začínat, pokud je, tak se odstraní funkcí ltrim
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"]); // pro odstranění bílých znaků kolem url
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]); // rozbití řetězce podle lomítek na pole jednotlivých parametrů
        return $rozdelenaCesta; //vrácení výsledků - tímto kompletní funkce k parsování URL
    }



    public function zpracuj($parametry)
    {
        $naparsovanaURL = $this->parsujURL($parametry[0]);

        if (empty($naparsovanaURL[0])) // pokud není zadán žádný kontroler, resp. 1. parametr url adresy je prázdný nebo chybí
            $tridaKontroleru = $this->upravitNazevKontroleru('hlavniStrana');
        else {
            $tridaKontroleru = $this->upravitNazevKontroleru(array_shift($naparsovanaURL));
        }
        if (file_exists('kontrolery/' . $tridaKontroleru . '.php')) //zjístíme, jestli opravdu název třídy kontroleru existuje 
            $this->kontroler = new $tridaKontroleru; // jestli ano, vytvoříme instanci (nevím co to je)
        else
            $this->presmeruj('chyba');  // pokud ne, vyhodí nám to chybovou stránku

        $this->kontroler->zpracuj($naparsovanaURL);  //provádí nějakou logiku, u članku to bude třeba jejich vyhledáváni v db

        $this->data['popis'] = $this->kontroler->hlavicka['popis']; // Jako hodnoty do šablony vložíme vždy titulek, popis a klíčová slova, která má vložený kontroler
        $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];
        $this->data['zpravy'] = $this->vratZpravy();

        // Nastavení hlavní šablony

        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];


        $this->pohled = 'rozlozeni';
    }
}

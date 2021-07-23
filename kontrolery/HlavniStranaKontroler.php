<?php

class HlavniStranaKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(                        // nastavení hlavičky
            'klicova_slova' => 'Hlavní stránka, florbal, Hradec Králové',
            'popis' => 'Hlavní stránka florbalového webu IBK Hradec Králové.'
        );

        $this->data['posledniClanky'] = (new SpravceClanku())->vratNejnovejsiClanky();

        $this->pohled = 'hlavniStrana';  // nastavení pohledu na kontakt
    }
}

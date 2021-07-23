<?php

class KategorieKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(                        // nastavení hlavičky
            'klicova_slova' => 'kategorie, florbal, Hradec Králové',
            'popis' => 'Kategorie týmu Hradec Králové.'
        );

        $this->data['seznamKategorie'] = (new SpravceKategorii())->vratSeznamKategorii();

        $this->pohled = 'kategorie';  // nastavení pohledu na kontakt
    }
}

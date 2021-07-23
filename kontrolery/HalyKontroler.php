<?php

class HalyKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(                        // nastavení hlavičky
            'klicova_slova' => 'sportovní haly, florbal, Hradec Králové',
            'popis' => 'Haly, kde náš tým trénuje.'
        );

        $this->pohled = 'haly';  // nastavení pohledu na kontakt
    }
}

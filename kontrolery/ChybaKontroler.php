<?php

class ChybaKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        // Hlavička požadavku
        header("HTTP/1.0 404 Not Found");
        // Hlavička stránky
        $this->hlavicka['klicova_slova'] = 'Chyba 404';
        // Nastavení šablony
        $this->pohled = 'chyba';
    }
}

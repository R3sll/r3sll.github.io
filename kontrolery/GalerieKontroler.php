<?php

// Controller pro šablonu pro výpis alb

class GalerieKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {

        $spravceAlb = new SpravceAlba();

        $this->hlavicka = array(                        // nastavení hlavičky
            'klicova_slova' => 'galerie, florbal, Hradec Králové',
            'popis' => 'Galerie týmu.'
        );

        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];

        if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
            $this->overUzivatele(true);
            try {
                $spravceAlb->odstranAlbum($parametry[0]);
                $this->pridejZpravu('Album bylo úspěšně odstraněno.');
            } catch (PDOException $e) {
                $this->pridejZpravu("V albu se nachází fotografie. Pokud chcete vymazat album, vymažte fotografie v něm.");
            }

            $this->presmeruj("galerie/");
        }



        $this->data['seznamAlb'] = (new SpravceAlba())->vratSeznamAlb();


        $this->pohled = 'galerie';  // nastavení pohledu na kontakt



    }
}

<?php

// Controller pro výpis výsledku do dané kategorie

class VysledkyKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s články
		$spravceVysledku = new SpravceVysledku();

		// Je zadáno URL výsledku
		if (!empty($parametry[0])) {

			// Získání výsledku podle URL
			$vysledky = $spravceVysledku->vratSeznamVysledku($parametry[0]);

			// Pokud nebyl výsledek s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$vysledky)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Výsledky zápasu, florbal, IBK Hradec Králové',
				'popis' => 'Výsledky našeho týmu IBK Hradec Králové.'
			);

			// Naplnění proměnných pro šablonu		
			$this->data['domaci'] = $vysledky['domaci'];
			$this->data['hoste'] = $vysledky['hoste'];
			$this->data['domaci_vysledek'] = $vysledky['domaci_vysledek'];
			$this->data['hoste_vysledek'] = $vysledky['hoste_vysledek'];
			$this->data['caskonani'] = $vysledky['caskonani'];
			$this->data['id_zapasu'] = $vysledky['id_zapasu'];
			$this->data['url'] = $vysledky['url'];

			// Nastavení šablony
			$this->pohled = 'typKategorie';
		} else {

			$this->pohled = 'kategorie';
		}
	}
}

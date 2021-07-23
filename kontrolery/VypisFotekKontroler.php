<?php

// Controller pro výpis fotek z daného alba

class VypisFotekKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s fotkami
		$spravceVypisuFotek = new SpravceVypisuFotek();


		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];


		// Je zadáno URL alba, kde se fotky nachází
		if (!empty($parametry[0])) {

			// Získání fotek podle URL alba
			$fotky = $spravceVypisuFotek->vratSeznamFotek($parametry[0]);

			// Pokud nebyla fotka s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$fotky)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Album, florbal, IBK Hradec Kárlové',
				'popis' => 'Fotografie našeho webu.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['cesta'] = $fotky['cesta'];

			// Nastavení šablony
			$this->pohled = 'fotografie';
		} else {

			$this->pohled = 'galerie';
		}
	}
}

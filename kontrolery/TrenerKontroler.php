<?php

// Controller pro výpis členů real. týmu

class TrenerKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s články
		$spravceTrener = new SpravceTrener();


		// Je zadáno URL členů real. týmu
		if (!empty($parametry[0])) {

			// Získání členů real. týmu podle URL
			$trener = $spravceTrener->vratSeznamTreneru($parametry[0]);

			// Pokud nebyl člen s daným URL nalezen, přesměrujeme na ChybaKontroler
			if (!$trener)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Realizační tým, florbal, IBK Hradec Králové',
				'popis' => 'Realizační tým našeho webu.'
			);

			// Naplnění proměnných pro šablonu		
			$this->data['jmeno'] = $trener['jmeno'];
			$this->data['prijmeni'] = $trener['prijmeni'];
			$this->data['pozice'] = $trener['pozice'];
			$this->data['email'] = $trener['email'];
			$this->data['tel_cislo'] = $trener['tel_cislo'];
			$this->data['id_kategorie'] = $trener['id_kategorie'];

			// Nastavení šablony
			$this->pohled = 'typKategorie';
		} else {
			$this->pohled = 'typKategorie';
		}
	}
}

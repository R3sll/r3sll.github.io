<?php

// Controller pro výpis členů real. týmu do administrace

class OnasKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s články
		$spravceFunkcionaru = new SpravceFunkcionaru();


		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];

		// Je zadáno ID členů real. týmu
		if (!empty($parametry[0])) {

			// Získání členů real. týmu podle ID
			$funkcionar = $spravceFunkcionaru->vratFunkcionare();

			// Pokud nebyl člen s daným ID nalezen, přesměrujeme na ChybaKontroler
			if (!$funkcionar)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'kontakt, florbal, IBK Hradec Králové',
				'popis' => 'O našem týmu a kontakt.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['jmeno'] = $funkcionar['jmeno'];
			$this->data['prijmeni'] = $funkcionar['prijmeni'];
			$this->data['pozice'] = $funkcionar['pozice'];
			$this->data['email'] = $funkcionar['email'];
			$this->data['tel_cislo'] = $funkcionar['tel_cislo'];


			// Nastavení šablony
			$this->pohled = 'onas';
		} else {


			$seznamFunkcionaru = $spravceFunkcionaru->vratSeznamFunkcionaru();
			$this->data['seznamFunkcionaru'] = $seznamFunkcionaru;

			$this->pohled = 'onas';
		}
	}
}

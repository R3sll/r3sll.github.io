<?php

// Controller pro výpis trenérů do administrace

class FunkcionariKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s trenéry
		$spravceFunkcionaru = new SpravceFunkcionaru();

		$this->overUzivatele(true);

		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];


		if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
			$this->overUzivatele(true);
			$spravceFunkcionaru->odstranFunkcionare($parametry[0]);
			$this->pridejZpravu('Trenér byl úspěšně odstraněn');
			$this->presmeruj("funkcionari");
		}

		// Je zadáno URL článku
		if (!empty($parametry[0])) {

			// Získání článku podle URL

			$funkcionar = $spravceFunkcionaru->vratFunkcionare();
			// Pokud nebyl článek s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$funkcionar)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Trenéři, florbal, IBK Hradec Králové',
				'popis' => 'Trenéři našeho webu.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['jmeno'] = $funkcionar['jmeno'];
			$this->data['prijmeni'] = $funkcionar['prijmeni'];
			$this->data['email'] = $funkcionar['email'];
			$this->data['tel_cislo'] = $funkcionar['tel_cislo'];
			$this->data['pozice'] = $funkcionar['pozice'];
			$this->data['id_clena'] = $funkcionar['id_clena'];

			$this->pohled = 'funkcionari';
		} else {

			// Nastavení šablony
			$funkcionari = $spravceFunkcionaru->vratSeznamFunkcionaru();
			$this->data['funkcionari'] = $funkcionari;
			$this->pohled = 'funkcionari';
		}
	}
}

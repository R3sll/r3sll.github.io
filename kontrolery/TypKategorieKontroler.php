<?php

// Controller pro výpis dané kategorie

class TypKategorieKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s články
		$spravceKategorii = new SpravceKategorii();
		$spravceHracu = new SpravceHracu();
		$spravceVysledku = new SpravceVysledku();


		$this->data['seznamHracu'] = (new SpravceHracu())->vratSeznamHracu($parametry[0]);
		$this->data['seznamTreneru'] = (new SpravceTrener())->vratSeznamTreneru($parametry[0]);
		$this->data['seznamVysledku'] = (new SpravceVysledku())->vratSeznamVysledku($parametry[0]);

		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];

		if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
			$this->overUzivatele(true);
			$spravceHracu->odstranHrace($parametry[2]);
			$this->pridejZpravu('Hrač byl úspěšně odstraněn');
			$this->presmeruj("typKategorie/$parametry[0]");
		}

		if (!empty($parametry[1]) && $parametry[1] == 'odstranitz') {
			$this->overUzivatele(true);
			$spravceVysledku->odstranVysledek($parametry[2]);
			$this->pridejZpravu('Zápas byl úspěšně odstraněn');
			$this->presmeruj("typKategorie/$parametry[0]");
		}

		// Je zadáno URL kategorie
		if (!empty($parametry[0])) {
			// Získání kategorie podle URL
			$kategorie = $spravceKategorii->vratKategorii($parametry[0]);
			// Pokud nebyla kategorie s danou URL nalezena, přesměrujeme na ChybaKontroler
			if (!$kategorie)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Kategorie, florbal, IBK Hradec Králové',
				'popis' => 'Kategorie našeho týmu IBK Hradec Králové.'
			);

			// Naplnění proměnných pro šablonu		
			$this->data['nazev_kategorie'] = $kategorie['nazev_kategorie'];
			$this->data['url'] = $kategorie['url'];

			// Nastavení šablony
			$this->pohled = 'typKategorie';
		} else {
			// Není zadáno URL článku, vypíšeme všechny
			$this->pohled = 'kategorie';
		}
	}
}

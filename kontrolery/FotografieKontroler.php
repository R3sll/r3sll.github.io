<?php

// Controller pro výpis alb

class FotografieKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s fotografiemi
		$spravceAlb = new SpravceAlba();
		$spravceVypisuFotek = new SpravceVypisuFotek();


		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];
		if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
			$this->overUzivatele(true);
			try {
				$spravceVypisuFotek->odstranFotku($parametry[2]);
				$this->pridejZpravu('Fotografie byla úspěšně odstraněn');
			} catch (PDOException $e) {
				$this->pridejZpravu("Fotografie je používána v článku. Pokud chcete tuto fotografii smazat, změnte úvodní fotku v článku.");
			}
			$this->presmeruj("fotografie/$parametry[0]");
		}

		$this->data['seznamFotek'] = (new SpravceVypisuFotek())->vratSeznamFotek($parametry[0]);


		// Je zadáno URL albumu
		if (!empty($parametry[0])) {

			// Získání albumu podle URL

			$album = $spravceAlb->vratAlbum($parametry[0]);

			// Pokud nebyl album s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$album)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'galerie, florbal, Hradec Králové',
				'popis' => 'Galerie našeho webu.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['nazev_alba'] = $album['nazev_alba'];
			$this->data['datum_pridani'] = $album['datum_pridani'];


			// Nastavení šablony
			$this->pohled = 'alba';
		} else
		// Není zadáno URL alba, vypíšeme všechny
		{

			$this->pohled = 'galerie';
		}
	}
}

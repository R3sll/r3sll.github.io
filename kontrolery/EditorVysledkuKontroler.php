<?php
// Controller pro výpis výsledků

class EditorVysledkuKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		// Vytvoření instance modelu
		$spravceVysledku = new SpravceVysledku();
		$spravceTymu = new SpravceTymu();
		$spravceKategorii = new SpravceKategorii();

		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];

		// Příprava prázdného zápasu
		$vysledek = array(
			'id_zapasu' => '',
			'domaci' => '',
			'hoste' => '',
			'caskonani' => '',
			'domaci_vysledek' => '',
			'hoste_vysledek' => '',
			'kategorie_id' => '',

		);
		// Je odeslán formulář
		if ($_POST) {
			// Získání zápasu z $_POST
			$klice = array('domaci', 'hoste', 'caskonani', 'domaci_vysledek', 'hoste_vysledek', 'kategorie_id');
			$vysledek = array_intersect_key($_POST, array_flip($klice)); 
			// Uložení zápasu do DB
			$spravceVysledku->ulozVysledek($_POST['id_zapasu'], $vysledek);
			$this->pridejZpravu('Zápas byl úspěšně uložen.');
			$this->presmeruj('kalendar/');
		}
		// Je zadané ID zápasu k editaci

		else if (!empty($parametry[0])) {

			$nactenyVysledek = $spravceVysledku->vratEditVysledek($parametry[0]);
			if ($nactenyVysledek)
				$vysledek = $nactenyVysledek;
			else
				$this->pridejZpravu('Zápas nebyl nalezen');
		}
		$this->data['vysledek'] = $vysledek;
		$this->data['seznamKategorii'] = $spravceKategorii->vratSeznamKategorii();
		$this->data['tymy'] = $spravceTymu->vratSeznamTymu();

		$this->pohled = 'editorVysledku';
	}
}

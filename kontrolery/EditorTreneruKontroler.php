<?php
// Controller pro výpis trenérů

class EditorTreneruKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		// Vytvoření instance modelu
		$spravceTreneru = new SpravceTrener();
		$spravceClenu = new SpravceClenu();
		$spravceKategorii = new SpravceKategorii();

		// Příprava prázdného trenéra
		$trener = array(
			'id_trenera' => '',
			'id_kategorie' => '',

		);
		// Je odeslán formulář
		if ($_POST) {
			// Uložení trenéra do DB
			$spravceTreneru->ulozTrenera($_POST['trener'], $_POST['kategorie']);
			$this->pridejZpravu('Trenér byl úspěšně uložen.');
			$this->presmeruj('treneri/');
		}
		// Je zadané ID trenéra k editaci

		else if (!empty($parametry[0])) {

			$nactenyTrener = $spravceTreneru->vratEditTrenera($parametry[0]);
			if ($nactenyTrener)
				$trener = $nactenyTrener;
			else
				$this->pridejZpravu('Trenér nebyl nalezen');
		}
		$this->data['trener'] = $trener;
		$this->data['seznamKategorii'] = $spravceKategorii->vratSeznamKategorii();
		$this->data['seznamClenu'] = $spravceClenu->vratSeznamClenu();

		$this->pohled = 'editorTreneru';
	}
}

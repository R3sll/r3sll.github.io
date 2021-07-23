<?php
// Controller pro výpis týmů

class EditorTymuKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		// Vytvoření instance modelu
		$spravceTymu = new SpravceTymu();

		// Příprava prázdného týmu
		$tym = array(
			'id_tymy' => '',
			'nazev_tymu' => '',

		);
		// Je odeslán formulář
		if ($_POST) {
			// Získání týmu z $_POST
			$klice = array('nazev_tymu');
			$tym = array_intersect_key($_POST, array_flip($klice)); 
			// Uložení týmu do DB
			$spravceTymu->ulozTym($_POST['id_tymy'], $tym);
			$this->pridejZpravu('Tým byl úspěšně uložen.');
			$this->presmeruj('tymy/');
		}
		// Je zadané ID týmu k editaci

		else if (!empty($parametry[0])) {

			$nactenyHrac = $spravceTymu->vratEditTym($parametry[0]);
			if ($nactenyHrac)
				$tym = $nactenyHrac;
			else
				$this->pridejZpravu('Článek nebyl nalezen');
		}
		$this->data['tym'] = $tym;

		$this->pohled = 'editorTymu';
	}
}

<?php
// Controller pro výpis článků

class EditorKontroler extends Kontroler
{

	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);
		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'Editor';
		// Vytvoření instance modelu
		$spravceClanku = new SpravceClanku();
		$spravceFotek = new SpravceVypisuFotek();

		// Příprava prázdného článku
		$clanek = array(
			'id_clanek' => '',
			'nazev_clanku' => '',
			'text_clanku' => '',
			'uvodnifotka' => '',
			'datum' => '',
			'url' => '',
			'popisek' => '',
		);
		// Je odeslán formulář
		if ($_POST) {
			
			$spravceFotek->ulozFotky(3, $_FILES['img']);

			$spravceClanku->vlozClanek($_POST['id_clanek'],$_POST['nazev_clanku'], $_POST['datum'], $_POST['url'], $_POST['popisek'], $_POST['text_clanku']);
			$this->pridejZpravu('Článek byl úspěšně uložen.');
			$this->presmeruj('clanek/' . $clanek['url']);
			
		}
		// Je zadané URL článku k editaci
		else if (!empty($parametry[0])) {
			$nactenyClanek = $spravceClanku->vratClanek($parametry[0]);
			if ($nactenyClanek)
				$clanek = $nactenyClanek;
			else
				$this->pridejZpravu('Článek nebyl nalezen');
		}


		//	$this->data['seznamAlb'] = $spravceAlb->vratSeznamAlb();
		$this->data['seznamFotek'] = $spravceFotek->vratSeznamVsechFotek();

		$this->data['clanek'] = $clanek;
		$this->pohled = 'editor';
	}
}

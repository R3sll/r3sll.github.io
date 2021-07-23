<?php
// Controller pro výpis týmů

class EditorAlbKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		// Vytvoření instance modelu
		$spravceAlb = new SpravceAlba();

		// Příprava prázdného týmu
		$album = array(
			'id_alba' => '',
			'nazev_alba' => '',
			'datum_pridani' => '',
			'url' => '',

		);
		// Je odeslán formulář
		if ($_POST) {
			// Získání týmu z $_POST
			$klice = array('nazev_alba', 'datum_pridani', 'url');
			$album = array_intersect_key($_POST, array_flip($klice)); 
			// Uložení týmu do DB
			$spravceAlb->ulozAlbum($_POST['id_alba'], $album);
			$this->pridejZpravu('Album bylo úspěšně uloženo.');
			$this->presmeruj('galerie/');
		}
		// Je zadané ID týmu k editaci

		else if (!empty($parametry[0])) {

			$nactenyAlbum = $spravceAlb->vratEditAlba($parametry[0]);
			if ($nactenyAlbum)
				$album = $nactenyAlbum;
			else
				$this->pridejZpravu('Album nebylo nalezeno!');
		}
		$this->data['album'] = $album;

		$this->pohled = 'editorAlb';
	}
}

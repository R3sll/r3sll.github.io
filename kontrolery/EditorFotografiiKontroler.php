<?php

// Controller pro zpracování článku

class EditorFotografiiKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		$spravceFotek = new SpravceVypisuFotek();
		$spravceAlba = new SpravceAlba();

		if ($_POST) {
			
			$spravceFotek->ulozFotky($_POST['album'], $_FILES['img']);

			$this->pridejZpravu('Fotografie úspěšně přidána.');

			$this->presmeruj('galerie');
		}

		// Nastavení šablony
		$this->pohled = 'editorFotografii';

		$this->data['seznamAlb'] = $spravceAlba->vratSeznamAlb();
	}
}

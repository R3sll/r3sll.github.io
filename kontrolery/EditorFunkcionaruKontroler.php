<?php
// Controller pro výpis člena real. týmu

class EditorFunkcionaruKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);
		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';
		// Vytvoření instance modelu
		$spravceFunkcionaru = new SpravceFunkcionaru();
		$spravceClenu = new SpravceClenu();

		// Příprava prázdného člena real. týmu
		$funkcionar = array(
			'id_clena' => '',
			'pozice' => '',
		);


		// Je odeslán formulář
		if ($_POST) {
			// Uložení člena real. týmu do DB
			$spravceFunkcionaru->ulozFunkcionare($_POST['funkcionar'], $_POST['pozice']);
			$this->pridejZpravu('Člen realizačního týmu byl úspěšně uložen.');
			$this->presmeruj('funkcionari/');
		}

		// Je zadané ID člena real. týmu k editaci
		else if (!empty($parametry[0])) {

			$nactenyFunkcionar = $spravceFunkcionaru->vratEditFunkcionare($parametry[0]);
			if ($nactenyFunkcionar)
				$funkcionar = $nactenyFunkcionar;
			else
				$this->pridejZpravu('Člen realizačního týmu nebyl nalezen');
		}
		$this->data['funkcionar'] = $funkcionar;

		$this->data['seznamClenu'] = $spravceClenu->vratSeznamClenu();

		$this->pohled = 'editorFunkcionaru';
	}
}

<?php
// Controller pro výpis týmů

class EditorClenuKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		// Vytvoření instance modelu
		$spravceClenu = new SpravceClenu();

		// Příprava prázdného týmu
		$clen = array(
			'id_realizacni_tym' => '',
			'jmeno' => '',
			'prijmeni' => '',
			'email' => '',
			'tel_cislo' => '',
		);
		// Je odeslán formulář
		if ($_POST) {
			// Získání týmu z $_POST
			$klice = array('jmeno', 'prijmeni', 'email', 'tel_cislo');
			$clen = array_intersect_key($_POST, array_flip($klice)); 
			// Uložení týmu do DB
			$spravceClenu->ulozClena($_POST['id_realizacni_tym'], $clen);
			$this->pridejZpravu('Člen byl úspěšně uložen.');
			$this->presmeruj('editorClenu/');
		}

		// Je zadané ID týmu k editaci
		else if (!empty($parametry[0])) {

			$nactenyClen = $spravceClenu->vratEditClena($parametry[0]);
			if ($nactenyClen)
				$clen = $nactenyClen;
			else
				$this->pridejZpravu('Člen nebyl nalezen');
		}
		$this->data['clen'] = $clen;

		$this->pohled = 'editorClenu';
	}
}

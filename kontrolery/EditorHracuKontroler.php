<?php
// Controller pro výpis hráčů

class EditorHracuKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Editor smí používat jen administrátoři
		$this->overUzivatele(true);

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		// Vytvoření instance modelu
		$spravceHracu = new SpravceHracu();
		$spravceKategorii = new SpravceKategorii();
		$spravceClenu = new SpravceClenu();

		// Příprava prázdného hráče
		$hraci = array(
			'id_hraci' => '',
			'cislo_dresu' => '',
			'post' => '',
			'kategorie_id' => '',
		);
		// Je odeslán formulář
		if ($_POST) {
			// Uložení hráče do DB
			$spravceHracu->ulozHrace($_POST['hrac'], $_POST['post'], $_POST['cislo_dresu'], $_POST['kategorie']);
			$this->pridejZpravu('Hráč byl úspěšně uložen.');
			$this->presmeruj('kategorie/');
		}
		// Je zadané ID hráče k editaci

		else if (!empty($parametry[0])) {

			$nactenyHrac = $spravceHracu->vrateditHrace($parametry[1]);
			if ($nactenyHrac)
				$hraci = $nactenyHrac;
			else
				$this->pridejZpravu('Hráč nebyl nalezen');
		}
		$this->data['hraci'] = $hraci;

		$this->data['seznamKategorii'] = $spravceKategorii->vratSeznamKategorii();
		$this->data['seznamClenu'] = $spravceClenu->vratSeznamClenu();

		$this->pohled = 'editorHracu';
	}
}

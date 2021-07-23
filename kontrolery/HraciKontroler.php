<?php

// Controller pro výpis hráčů

class HraciKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s hráči
		$spravceHracu = new SpravceHracu();

		// Je zadáno ID hráče
		if (!empty($parametry[0])) {

			// Získání hráče podle URL
			$hraci = $spravceHracu->vratSeznamHracu($parametry[0]);

			// Pokud nebyl hráč s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$hraci)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Kategorie, flbrl, ehhe',
				'popis' => 'Kategorie našeho webu.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['jmeno'] = $hraci['jmeno'];
			$this->data['prijmeni'] = $hraci['prijmeni'];
			$this->data['cislo_dresu'] = $hraci['cislo_dresu'];
			$this->data['post'] = $hraci['post'];
			$this->data['url'] = $hraci['url'];
			$this->data['id_hraci'] = $hraci['id_hraci'];


			// Nastavení šablony
			$this->pohled = 'typKategorie';
		} else
		// Není zadáno ID hráče, vrátíme na výpis kategorií
		{

			$this->pohled = 'kategorie';
		}
	}
}

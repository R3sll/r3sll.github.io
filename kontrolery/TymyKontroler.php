<?php

// Controller pro výpis týmů do administrace

class TymyKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s články
		$spravceTymu = new SpravceTymu();

		$this->overUzivatele(true);


		if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
			$this->overUzivatele(true);
			$spravceTymu->odstranTym($parametry[0]);
			$this->pridejZpravu(' tým byl úspěšně odstraněn');
			$this->presmeruj("tymy");
		}

		// Je zadáno ID týmu
		if (!empty($parametry[0])) {

			// Získání týmu podle ID
			$tym = $spravceTymu->vratTym();
			
			// Pokud nebyl tým s daným ID nalezen, přesměrujeme na ChybaKontroler

			if (!$tym)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Týmy, florbal, IBK Hradec Králové',
				'popis' => 'Florbalové týmy.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['nazev_tymu'] = $tym['nazev_tymu'];
			$this->data['id_tymy'] = $tym['id_tymy'];

			// Nastavení šablony
			$this->pohled = 'tymy';
		} else {

			include 'paginace/paginace.php';

			if (isset($_GET['strana']))
				$strana = $_GET['strana'];
			else
				$strana = 1;
			$naStranu = 10;
			$tymy = $spravceTymu->vratPagTymu($strana, $naStranu);
			$cnt = $spravceTymu->vratPocetTymu();
			$stran = ceil($cnt['cnt'] / $naStranu);
			

			$this->data['strankovani'] = paginace($strana, $stran, 'tymy?strana={strana}');
			
			$this->data['tymy'] = $tymy;

			$this->pohled = 'tymy';
		}
	}
}

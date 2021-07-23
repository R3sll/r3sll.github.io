<?php

// Controller pro výpis trenérů do administrace

class TreneriKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s trenéry
		$spravceTreneru = new SpravceTrener();

		$this->overUzivatele(true);

		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];


		if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
			$this->overUzivatele(true);
			$spravceTreneru->odstranTrenera($parametry[0]);
			$this->pridejZpravu('Trenér byl úspěšně odstraněn');
			$this->presmeruj("treneri");
		}

		// Je zadáno URL článku
		if (!empty($parametry[0])) {

			// Získání článku podle URL
			$trener = $spravceTreneru->vratJedenTrener();

			// Pokud nebyl článek s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$trener)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'Trenéři, florbal, IBK Hradec Králové',
				'popis' => 'Trenéři našeho webu.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['jmeno'] = $trener['jmeno'];
			$this->data['prijmeni'] = $trener['prijmeni'];
			$this->data['nazev_kategorie'] = $trener['nazev_kategorie'];
			$this->data['id_kategorie'] = $trener['id_kategorie'];

			$this->pohled = 'treneri';
		} else {

			// Nastavení šablony
			include 'paginace/paginace.php';

			if (isset($_GET['strana']))
				$strana = $_GET['strana'];
			else
				$strana = 1;
			$naStranu = 8;
			$treneri = $spravceTreneru->vratPagTreneru($strana, $naStranu);
			$cnt = $spravceTreneru->vratPocetTreneru();
			$stran = ceil($cnt['cnt'] / $naStranu);
			

			$this->data['strankovani'] = paginace($strana, $stran, 'treneri?strana={strana}');
			
			$this->data['treneri'] = $treneri;
			$this->pohled = 'treneri';
		}
	}
}

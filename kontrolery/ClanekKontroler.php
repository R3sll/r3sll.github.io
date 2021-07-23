<?php

// Controller pro výpis článků

class ClanekKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s články
		$spravceClanku = new SpravceClanku();

		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];

		// Je zadáno URL článku ke smazání
		if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
			$this->overUzivatele(true);
			$spravceClanku->odstranClanek($parametry[0]);
			$this->pridejZpravu('Článek byl úspěšně odstraněn');
			$this->presmeruj('clanek');
		}
		// Je zadáno URL článku
		else if (!empty($parametry[0])) {
			// Získání článku podle URL
			$clanek = $spravceClanku->vratClanek($parametry[0]);
			// Pokud nebyl článek s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$clanek)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'obsah, florbal, florbalhradec',
				'popis' => 'Články florbalového webu.'
			);



			// Naplnění proměnných pro šablonu		
			$this->data['nazev_clanku'] = $clanek['nazev_clanku'];
			$this->data['text_clanku'] = $clanek['text_clanku'];
			$this->data['datum'] = $clanek['datum'];
			$this->data['cesta'] = $clanek['cesta'];



			// Nastavení šablony
			$this->pohled = 'clanek';
		} else
		// Není zadáno URL článku, vypíšeme všechny
		{
			include 'paginace/paginace.php';

			if (isset($_GET['strana']))
				$strana = $_GET['strana'];
			else
				$strana = 1;
			$naStranu = 6;
			$clanky = $spravceClanku->vratPagClanky($strana, $naStranu);
			$cnt = $spravceClanku->vratPocetClanku();
			$stran = ceil($cnt['cnt'] / $naStranu);
			

			$this->data['strankovani'] = paginace($strana, $stran, 'clanek?strana={strana}');
			$this->data['clanky'] = $clanky;
			$this->pohled = 'clanky';
		}
	}
}

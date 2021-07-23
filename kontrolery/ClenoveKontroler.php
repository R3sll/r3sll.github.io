<?php

// Controller pro výpis hráčů

class ClenoveKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s hráči
		$spravceClenu = new SpravceClenu();

		$this->overUzivatele(true);

		$spravceUzivatelu = new SpravceUzivatelu();
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['admin'] = $uzivatel && $uzivatel['admin'];


		if (!empty($parametry[1]) && $parametry[1] == 'odstranit') {
			$this->overUzivatele(true);
			$spravceClenu->odstranClena($parametry[0]);
			$this->pridejZpravu('Člen byl úspěšně odstraněn.');
			$this->presmeruj("clenove");
		}

		// Je zadáno ID hráče
		if (!empty($parametry[0])) {

			// Získání hráče podle URL
			$clen = $spravceClenu->vratClena($parametry[0]);

			// Pokud nebyl hráč s danou URL nalezen, přesměrujeme na ChybaKontroler
			if (!$clen)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'titulek' => 'Ktgr',
				'klicova_slova' => 'Kategorie, flbrl, ehhe',
				'popis' => 'Kategorie našeho webu.'
			);


			// Naplnění proměnných pro šablonu		
			$this->data['jmeno'] = $clen['jmeno'];
			$this->data['prijmeni'] = $clen['prijmeni'];
			$this->data['email'] = $clen['email'];
			$this->data['tel_cislo'] = $clen['tel_cislo'];
			$this->data['id_realizacni_tym'] = $clen['id_realizacni_tym'];

			// Nastavení šablony
			$this->pohled = 'clenove';
		} else {

			include 'paginace/paginace.php';

			if (isset($_GET['strana']))
				$strana = $_GET['strana'];
			else
				$strana = 1;
			$naStranu = 10;
			$clenove = $spravceClenu->vratPagClenu($strana, $naStranu);
			$cnt = $spravceClenu->vratPocetClenu();
			$stran = ceil($cnt['cnt'] / $naStranu);
			

			$this->data['strankovani'] = paginace($strana, $stran, 'clenove?strana={strana}');
			
			
			$this->data['clenove'] = $clenove;
			$this->pohled = 'clenove';
		}
	}
}

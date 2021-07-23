<?php
// Controller pro výpis událostí

class KalendarKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Vytvoření instance modelu, který nám umožní pracovat s články
		$spravceKalendare = new SpravceKalendare();

		// Je zadáno ID události
		if (!empty($parametry[0])) {
			// Získání události podle ID		
			$udalost = $spravceKalendare->vratUdalost();

			// Pokud nebyla událost s daným ID nalezen, přesměrujeme na ChybaKontroler
			if (!$udalost)
				$this->presmeruj('chyba');

			$this->hlavicka = array(                        // nastavení hlavičky
				'klicova_slova' => 'kalendář, florbal, Hradec Králové',
				'popis' => 'Kalendář akcí našeho webu.'
			);

			// Naplnění proměnných pro šablonu		
			$this->data['domaci'] = $udalost['domaci'];
			$this->data['hoste'] = $udalost['hoste'];
			$this->data['domaci_vysledek'] = $udalost['domaci_vysledek'];
			$this->data['hoste_vysledek'] = $udalost['hoste_vysledek'];
			$this->data['caskonani'] = $udalost['caskonani'];
			$this->data['nazev_kategorie'] = $udalost['nazev_kategorie'];

			// Nastavení šablony
			$this->pohled = 'kalendar';
		} else
		// Není zadáno ID události, vypíšeme všechny
		{

			include 'paginace/paginace.php';

			if (isset($_GET['strana']))
				$strana = $_GET['strana'];
			else
				$strana = 1;
			$naStranu = 6;
			$udalosti = $spravceKalendare->vratPagVysledku($strana, $naStranu);
			$cnt = $spravceKalendare->vratPocetVysledku();
			$stran = ceil($cnt['cnt'] / $naStranu);
			
			$this->data['strankovani'] = paginace($strana, $stran, 'kalendar?strana={strana}');



		//	$udalosti = $spravceKalendare->vratSeznamUdalosti();
			$this->data['udalosti'] = $udalosti;
			$this->pohled = 'kalendar';
		}
	}
}

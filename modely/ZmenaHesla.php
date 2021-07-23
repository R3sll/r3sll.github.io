<?php

class ZmenaHesla
{

    public function vratOtisk($heslo)
    {
        return password_hash($heslo, PASSWORD_DEFAULT);
    }

    public function vratUzivateleAsi($jmeno)
    {
        return Db::dotazJeden('
        select * from uzivatel where jmeno = ?', array($jmeno));
    }

    public function zmenUzivateleAsi($jmeno, $heslo)
    {
        $uziv = array(
            'jmeno' => $jmeno,
            'heslo' => $this->vratOtisk($heslo),
        );

        if ($jmeno)
            Db::zmen('uzivatel', $uziv, 'WHERE jmeno = ?', array($jmeno));
    }
}

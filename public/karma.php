<?php

class karma
{
    private $nepesseg = 5;
    private $action_number = 2; //adgató akók
    private $actions = []; //adott kapott actions
    private $max_ciklus = 1000;
    private $akt_ciklus = 1;
    private $ciklus_run_ok = true;
    private $karma_ok = false;

    public function __construct()
    {
        $this->nepesseg = $_POST['nepesseeg'] ?? $this->nepesseg;
        $this->action_number = $_POST['action_number'] ?? $this->action_number;
    }
//human---------
    public function get_action()
    {
        return ['action' => rand(1, $this->action_number), 'cel_id' => rand(1, $this->nepesseg)];

    }
    public function set_action($x, $action)
    {
        $this->actions[$x]['ad'][] = $action['action']; //ad
        $this->actions[$action['cel_id']]['kap'][] = $action['action']; //kap

    }

    public function ertekel($x)
    {
        $res = [];

        for ($x1 = 0; $x1 <= $x; $x1++) {
            $ad_arr = $this->actions[$x1]['ad'] ?? [];
            $kap_arr = $this->actions[$x1]['kap'] ?? [];
            if ($ad_arr == $kap_arr && !empty($ad_arr)) {
                $res[] = $x1;
            }
        }
        return $res;
    }
    public function fut()
    {

        while ($this->ciklus_run_ok) {

            for ($x = 0; $x <= $this->nepesseg; $x++) {
                $action = $this->get_action();
                $this->set_action($x, $action);
            }

            // $karmatomb= $this->ertekel($this->nepesseg);

            // print_r($this->actions);echo '<br>';
            // dump($this->actions);
            // if(count($karmatomb)==$x){$this->ciklus_run_ok=false;}

            if ($this->akt_ciklus > $this->max_ciklus) {$this->ciklus_run_ok = false;}

            $this->akt_ciklus++;
        }

      
        // print_r($this->actions);
    }
    public function kiir()
    {
        echo '<HTML><HEAD></HEAD><BODY>';
        
        
        echo 'ciklus szám:' . $this->max_ciklus . 'akt ciklus:' . $this->akt_ciklus;
        echo '<br>';   

        foreach ($this->actions as $key => $value) {

            $ad = $value['ad'] ?? [];
            $kap = $value['kap'] ?? [];
            echo '<br> person ' . $key . ':<br>  ';
            $adval1 = 0;
            $adval2 = 0;
            foreach ($ad as $adval) {

                if ($adval == 1) {$adval1++;}
                if ($adval == 2) {$adval2++;}
            }
            echo 'ad 1: ' . $adval1 . ', aad:2: ' . $adval2  ;

            $kapval1 = 0;
            $kapval2 = 0;
            foreach ($kap as $kapval) {

                if ($kapval == 1) {$kapval1++;}
                if ($kapval == 2) {$kapval2++;}
                
            }
            echo '<br>  kap1: ' . $kapval1 . ', kap2: ' . $kapval2 . ' AD-KAP 1='.$adval1 - $kapval1;
            if($adval1 == $kapval1){echo '<span style="color:green"> 1-es OK</span>';}else {echo '<span style="color:red"> 1-es NG</span>';}
            echo ' eltérés %:';
            echo' AD-KAP 2='.$adval1 - $kapval1;
            if($adval2 == $kapval2){echo '<span style="color:green"> 2-es OK</span>';}else {echo '<span style="color:red"> 2-es NG</span>';}

        }
echo '<BODY><HTML>';
    }
}

$karma = new karma();
$karma->fut();
$karma->kiir();

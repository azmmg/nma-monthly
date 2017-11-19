<?php
print header("Content-type:application/json");
$nm_names = array(
'20min.ch - D-CH' => 1,
'Blick Online' => 1,
'Bluewin' => 1,
'tagesanzeiger.ch' => 1,
'Newsnet DCH' => 1,
'Newsnet D-CH' => 1,
'watson.ch' => 1,
'Nordwestschweiz Netz' => 1,
'baslerzeitung.ch' => 1,
'Luzerner Zeitung' => 1,
'luzernerzeitung.ch' => 1,
'srf.ch' => 1,
'St. Galler Tagblatt' => 1,
'zsz.ch' => 1,
'zuonline.ch' => 1,
'Der Landbote' => 1,
'swissmom.ch' => 1,
'familienleben.ch' => 1,
'wireltern.ch' => 1,
'wildeisen.ch' => 1,
'saison.ch' => 1,
'lemenu.ch' => 1,
'tageswoche.ch' => 1,
'telezueri.ch' => 1,
'argovia.ch' => 1,
'radio24.ch' => 1,
'radiopilatus.ch' => 1,
'energy.ch' => 1,
'FM1Today' => 1,
'TeleBaern.tv' => 1,
'TeleM1.ch' => 1,
'tv24.ch' => 1
);

function clean_number($str) {
   if (preg_match("/^[0-9']+$/",$str,$matches)) {
      return str_replace("'", "", $str);
   } else {
     return $str;
   };
};
function print_output_plain($arr) {
  $new_arr = array();
  $sz = sizeof($arr);
  for ($i=0;$i<$sz;$i++) {
      array_push($new_arr,clean_number($arr[$i]));
  };
  if ($sz == 7) {
      $insert = array('-','-');
      array_splice($new_arr,3,0,$insert);
  };
  printf("<div>%s</div>",join(",",$new_arr));
};
function print_output_json($arr) {
  $col_names = array("Unique Clients", "Visits", "CH-Visits", "Use Time", "Page Impressions", "Nicht werberel.", "WID", "Offer","nil");
  $new_arr = array();
  $sz = sizeof($arr);
  $json = '"'.$arr[0].'" : {%s},';
  for ($i=1;$i<$sz;$i++) {
      array_push($new_arr,clean_number($arr[$i]));
  };
  if ($sz == 7) {
      $insert = array('-','-');
      array_splice($new_arr,2,0,$insert);
      array_splice($new_arr,5,0,'');
  };
  for ($c=0;$c<sizeof($new_arr);$c++) {
      $new_arr[$c] = sprintf("\"%s\" : \"%s\"",$col_names[$c],$new_arr[$c]);
  }
  printf($json,join(",",$new_arr));
};
$row = 1;
if (($handle = fopen("../csv/NMA_201710.csv", "r")) !== FALSE) {
   print "{";
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
     if (isset($nm_names[$data[0]])) {
        //print_output_plain($data);
        print_output_json($data);
     } else {
        if (preg_match("/Neue.*rcher/",$data[0],$matches) && !preg_match("/^audienzz/",$data[0],$matches)) {
           //Bei Anzeige als utf-8 untenstehende Zeile ebntkommentieren
           $data[0] = 'Neue Zuercher Zeitung';
           //print_output_plain($data);
           print_output_json($data);
        } else if (preg_match("/^audienzz.*NZZ-Netz$/",$data[0],$matches)) {
           $data[0] = 'NZZ-Netz';
           //print_output_plain($data);
           print_output_json($data);
        };
     };
    };
    print "\"END\":null}\n";
    fclose($handle);
}
?>

<?php 
header('Content-Type: application/json');    
// $data = 'countries.xml';

function xml2json($file) {
    if (file_exists($file)) {
        $xml = simplexml_load_file($file);
        $output = [];

        foreach ($xml->country as $key => $value) {
            $filtered_xml = [];
            $filtered_xml['name'] = (string)$value['name'];
            $filtered_xml["currency"] = (string)$value['currency'];
            $filtered_xml["capital"] = (string)$value['capital'];

            $json = json_encode(($filtered_xml), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            // if($output = "") {$output = $json}
            array_push($output, $json); 
        }
        
        return "[" . implode(",", $output) . "]";    
    
    } else {
        exit('Failed to open '.$file);
    }
 }

// loop through directory for each xml file
$xmlfiles = glob('xml/*.{xml}', GLOB_BRACE);

foreach ($xmlfiles as $xmlfile) {
    //set the output file name to .json
    $filename = basename($xmlfile, ".xml").".json";
    $result = xml2json($xmlfile);
    //create new file

    $handle = fopen($_SERVER['DOCUMENT_ROOT'] ."/xml2json/json/". $filename, "w") or die ('Cannot open file: ' .$filename);

    //write json data into new file
    if( fwrite($handle, $result) === FALSE) {
        echo "Cannot write to file.";
        exit;
    }

    echo "Success wrote date to file:" .$filename ."\n";
    fclose($handle);
    }

?>


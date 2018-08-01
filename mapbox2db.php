<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
};


function markers(){
    // Opens a connection to a MySQL server
    include "lib/db.php";

    // Select all the rows in the markers table
    $query = "SELECT * FROM markers";
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error());
    }

    $previous = 0;
    $allMarkers = array();


    $coords = array();
    while ($row = mysqli_fetch_assoc($result)){

        $current = $row['id'];

        // We've switched to a new route, output the set of coords
        if ($current > $previous){
            $marker = array(
                'type' => 'Feature',
                'properties' => array(
//                    'stop_id' => $row['stop_id'],
                    'name' => $row['name'],
                    'address' => $row['address'],
                    'type' => $row['type'],
//                    'specific_type' => $row['specific_type']
                ),
                'geometry' => array(
                    'type' => 'Point',
                    'coordinates' => array($row['lng'], $row['lat'])
                )
            );
            array_push($allMarkers, $marker);
            $coords = array();
        } 
        
        $previous = $current;
    };

    
    // Did we have a set of coords left over from the last row?

    $allPoints = array(
        'id' => 'points',
        'type' => 'circle',
        'source' => array(
            'type' => 'geojson',
            'data' => array(
                'type' => 'FeatureCollection',
                'features' => $allMarkers
            )
        ),
        'paint' => array(
            'circle-radius' => 4,
            'circle-color' => [
                'match',
                ['get', 'type'],
                "bar","#42a0c3",
                "restaurant", "#1b76a4",
                "Forestry", "#a0f5fa",
                "Sanitation","#1b76a4",
                "Housing","#42a0c3",
                "Parking","#004e83",
                "Police", "#a0f5fa",
                "Streets/Sidewalks", "hsl(0, 100%, 47%)",
                "Utilities", "hsl(0, 100%, 47%)",
                /*Default*/ "hsl(125, 100%, 51%)"
                ],
            'circle-stroke-color' => [
                'match',
                ['get', 'type'],
                "bar","#42a0c3",
                "restaurant", "#1b76a4",
                "Forestry", "#a0f5fa",
                "Sanitation","#1b76a4",
                "Housing","#42a0c3",
                "Parking","#004e83",
                "Police", "#a0f5fa",
                "Streets/Sidewalks", "hsl(0, 100%, 47%)",
                "Utilities", "hsl(0, 100%, 47%)",
                /*Default*/ "hsl(125, 100%, 51%)"
                ],
            'circle-stroke-opacity' => 0.2,
            'circle-stroke-width'=> 8,
        )
    );
    
//    $new_array = $allPoints[0];
    echo json_encode($allPoints, JSON_PRETTY_PRINT);
    
};

function test(){
    header("Content-type: application/json");
    markers();
};
//markers();
//test();
?>

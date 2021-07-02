<?php
// Local json array
$local = '[
{
"customerID": "3",
"fname": "Ivan",
"lname": "Rizvi",
"city": "plano",
"state": "TX",
"zipCode": "75025",
"dateUpdated": "2012-08-31 13:39:00"
},
{
"customerID": "5",
"fname": "richard",
"lname": "Cortez",
"city": "McKinney",
"state": "TX",
"zipCode": "75071",
"dateUpdated": "2012-08-31 18:28:00"
},
{
"customerID": "6",
"fname": "Mark",
"lname": "Granberry",
"city": "Sachse",
"state": "TX",
"zipCode": "75048",
"dateUpdated": "2012-08-31 17:30:00"
},
{
"customerID": "7",
"fname": "Raul",
"lname": "Whittington",
"city": "McKinney",
"state": "TX",
"zipCode": "75070",
"dateUpdated": "2020-01-01 00:00:00"
},
{
"customerID": "8",
"fname": "Antonio",
"lname": "Fisher",
"city": "Sachse",
"state": "TX",
"zipCode": "75048",
"dateUpdated": "2012-08-31 17:47:00"
},
{
"customerID": "9",
"fname": "kim",
"lname": "Flores",
"city": "Rowlett",
"state": "TX",
"zipCode": "75070",
"dateUpdated": "2020-01-01 00:00:00"
},
{
"customerID": "10",
"fname": "Gina",
"lname": "Daskas",
"city": "plano",
"state": "TX",
"zipCode": "75025",
"dateUpdated": "2012-08-31 13:49:00"
},
{
"customerID": "11",
"fname": "Dustin",
"lname": "Esparza",
"city": "McKinney",
"state": "TX",
"zipCode": "75069",
"dateUpdated": "2012-08-31 15:18:00"
},
{
"customerID": "12",
"fname": "Beatrices",
"lname": "Dallahs",
"city": "McKinney",
"state": "TX",
"zipCode": "75069",
"dateUpdated": "2012-08-31 20:17:00"
},
{
"customerID": "13",
"fname": "lewis",
"lname": "Leatherman",
"city": "Garland",
"state": "TX",
"zipCode": "75044",
"dateUpdated": "2012-08-31 10:45:00"
}
]';
// remote json array
$remote = '[
{
"CustomerNumber": "7",
"CustomerName": "Raul Whittington",
"CustomerCity": "McKinney",
"CustomerState": "TX",
"CustomerZipCode": "75069",
"dateUpdated": "2012-08-31 13:25:00"
},
{
"CustomerNumber": "8",
"CustomerName": "Antonio Fisher",
"CustomerCity": "Dallas",
"CustomerState": "TX",
"CustomerZipCode": "75252",
"dateUpdated": "2020-02-01 00:00:00"
},
{
"CustomerNumber": "9",
"CustomerName": "kim Flores",
"CustomerCity": "Rowlett",
"CustomerState": "TX",
"CustomerZipCode": "75089",
"dateUpdated": "2012-08-31 18:09:00"
},
{
"CustomerNumber": "10",
"CustomerName": "Gina Daskas",
"CustomerCity": "plano",
"CustomerState": "TX",
"CustomerZipCode": "75025",
"dateUpdated": "2012-08-31 13:49:00"
},
{
"CustomerNumber": "11",
"CustomerName": "Dustin Esparza",
"CustomerCity": "McKinney",
"CustomerState": "TX",
"CustomerZipCode": "75069",
"dateUpdated": "2012-08-31 15:18:00"
},
{
"CustomerNumber": "12",
"CustomerName": "Beatrices Dallahs",
"CustomerCity": "McKinney",
"CustomerState": "TX",
"CustomerZipCode": "75069",
"dateUpdated": "2012-08-31 20:17:00"
},
{
"CustomerNumber": "13",
"CustomerName": "lewis Leatherman",
"CustomerCity": "Garland",
"CustomerState": "TX",
"CustomerZipCode": "75044",
"dateUpdated": "2012-08-31 10:45:00"
},
{
"CustomerNumber": "14",
"CustomerName": "David Johnsons",
"CustomerCity": "wylie",
"CustomerState": "TX",
"CustomerZipCode": "75098",
"dateUpdated": "2012-08-31 20:16:00"
},
{
"CustomerNumber": "15",
"CustomerName": "Ken Salisbury",
"CustomerCity": "Garland",
"CustomerState": "TX",
"CustomerZipCode": "75044",
"dateUpdated": "2012-08-31 20:43:00"
}
]';

// Convert into true array
$localArray = json_decode($local, true);
$remoteArray = json_decode($remote, true);

// initilize local and remote updated array

$localUpdatedArray = [];
$remoteUpdatedArray = [];

// loop through localarray to updated index with customerID
foreach ($localArray as $key=>$localAtt){
    $localUpdatedArray[$localAtt['customerID']] = $localAtt;
}

// unset localarray
unset($localArray);

// loop through remote array to update key with customerID and update allthe array elements with local array elements
foreach ($remoteArray as $key=>$remoteEl){
    $remoteUpdatedArray [$remoteEl['CustomerNumber']]['customerID'] = $remoteEl['CustomerNumber'];
    $remoteUpdatedArray [$remoteEl['CustomerNumber']]['fname'] = strtok($remoteEl['CustomerName'], ' ');
    $remoteUpdatedArray [$remoteEl['CustomerNumber']]['lname'] = strstr($remoteEl['CustomerName'], ' ');
    $remoteUpdatedArray [$remoteEl['CustomerNumber']]['city'] = $remoteEl['CustomerCity'];
    $remoteUpdatedArray [$remoteEl['CustomerNumber']]['state'] = $remoteEl['CustomerState'];
    $remoteUpdatedArray [$remoteEl['CustomerNumber']]['zipCode'] = $remoteEl['CustomerZipCode'];
    $remoteUpdatedArray [$remoteEl['CustomerNumber']]['dateUpdated'] = $remoteEl['dateUpdated'];
}

// unset remote array
unset($remoteArray);

// union local updated array and remote updated array
$mergedArray = $localUpdatedArray + $remoteUpdatedArray;

/**
 *  Customer array merge function
 *  Update the key index with element if second array has same key with rent dateUpdated
 *  @param $firstArray $secondArray
 *  @return array
 *
 */
function custom_array_merge(&$firstArray, &$secondArray) {
    foreach($firstArray as $key => &$value) {
        if(!empty($secondArray[$key])){
            if($value['dateUpdated'] < $secondArray[$key]['dateUpdated'] ){
                $firstArray[$key] = array_merge($value,$secondArray[$key]);
            }
        }
    }
    return $firstArray;
}
// call custom_array_merge function to get the final updated local array
$finalLocal = custom_array_merge($mergedArray, $remoteUpdatedArray);

// unset local updated, remote updated and merged arrays
unset($localArrayUpdated);
unset($remoteArrayUpdated);
unset($mergedArray);

// initilize final route array
$finalRemote = [];

// loop through $finalLocal array to update all the array element as remote intial array had
foreach ($finalLocal as $key=>$element){
    $finalRemote [$key]['CustomerNumber'] = $element['customerID'];
    $finalRemote [$key]['CustomerName'] = strtok($element['fname'], ' ') . ' ' . strstr($element['lname'], ' ');
    $finalRemote [$key]['CustomerCity'] = $element['city'];
    $finalRemote [$key]['CustomerState'] = $element['state'];
    $finalRemote [$key]['CustomerZipCode'] = $element['zipCode'];
    $finalRemote [$key]['dateUpdated'] = $element['dateUpdated'];
}

// print both final local and remote array
print_r('Answer: Local Updated Array - ');
print_r($finalLocal);
print_r('Answer: Remote Updated Array - ');
print_r($finalRemote);
?>

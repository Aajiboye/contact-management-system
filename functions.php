<?php
//PHONEBOOK API
//JSON_ENCODE GETS  AN ARRAY AND ENCODES IT INTO JSON FORMAT AND JSON_DECODES DOES THE  OPPOSITE
$phonebook = json_decode(file_get_contents("phonebook.json"));
//file_get_contents gets values as string from file
//json_decode converts to array
function feedback($success=false,$message=[],$result=[]){
		$response=[
		"success"=>$success,
		"message"=>$message,
		"results"=>$result,
	];

    echo json_encode($response);
}

function checkNumberExistence($phone){
    global $phonebook;
//check by number if contact already exists
foreach ($phonebook as $contact) {
   if (in_array($phone, $contact)) {
       $status=true;
        break;
     }
     else 
     $status=false;
}
return $status;
}
function addContact($name, $phone, $email, $gender, $bio)
{
    //GLOBAL KEYWORD MAKES PHONEBOOK VISIBLE INSIDE THE FUNCTION
    global $phonebook;
    $name = ucfirst($name);
    if ($phone == "") {
        $message[] = 'Number field cannot be empty';
        $success=false;
            } 
    if (!(is_numeric($phone))) {
        $message[] = 'Number field cannot contain letters';
        $success = false;
            }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name))
         {
            $message[] = "Only letters and white space allowed";
            $success=false;
                    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
         {
            $message[] = "Invalid email format";
            $success=false;
        }

    if ($gender=="")
    {
            $message[]='Kindly select a gender';
            $success=false;
         }
    
 

    if($phone!="" && $gender!="" && (is_numeric($phone)) && preg_match("/^[a-zA-Z0-9 ]*$/",$name) && filter_var($email, FILTER_VALIDATE_EMAIL ))
       {
        if(checkNumberExistence($phone)){
        $success = false;
        $message[] = 'Contact already exists with ' . $phone;
        }
        else{
        $contact = array($name, $phone, $email, $gender, $bio);
        $phonebook[] = $contact;
        savePhonebook();
        $success = true;
        $message[] = $name .' has been successfully  added to your contacts';
        }
        
    }
    feedback($success, $message);  
}
     
    


function viewPhonebook()
{
    global $phonebook;
    $success = true;
    $result = $phonebook;
    $message = [];
    feedback($success, $message, $result);
}

function deleteContact($index)
{
    global $phonebook;
    $result = [];
    if ($index == "") {
        $success = false;
        $message[] = 'ID cannot be empty!';
    } elseif (!(isset($phonebook[$index]))) {
        $message[] = 'Invalid ID';
        $success = false;
    } else {
        array_splice($phonebook, $index, 1);
        savePhonebook();
        $success = true;
        $message[] = $phonebook[$index][0] . ' Successfully deleted';
    }
    feedback($success, $message, $result);

}

function search($searchKey)
{
    global $phonebook;
    $searchResult = [];
    $i = 0;
    foreach ($phonebook as $contact) {
        $Temp = [];
        if ((strtolower($searchKey) == strtolower($contact[0]) || ($searchKey == $contact[1]))) {
            $Temp[] = $i;

            foreach ($contact as $key) {
                $Temp[] = $key;
            }
            $searchResult[] = $Temp;
        }
        $i++;
    }
    if (count($searchResult) == 0) {
        $success = false;
        $message[] = 'No contact Found';
    } else {
        $success = true;
        if (count($searchResult) > 1) {
            $message[] = 'found ' . count($searchResult) . ' results';
        } else {
            $message[] = 'found ' . count($searchResult) . ' result';
        }

        $result = $searchResult;
        feedback($success, $message, $result);
    }
}
function editContact($id, $nName, $nNumber)
{
    global $phonebook;
    $nName = ucfirst($nName);
    $result = [];
    if (!(is_numeric($nNumber))) {
        $message[] = 'Number field cannot contain letters';
        $success = false;
    } elseif (!(isset($phonebook[$id]))) {
        $message[] = 'Contact does not exist';
        $success = false;
    } else {
        if ($nName == "") {
            $phonebook[$id][1] = $nNumber;
        } elseif ($nNumber == "") {
            $phonebook[$id][0] = $nName;
        } elseif (!(($nName == "") && ($nNumber == ""))) {
            $phonebook[$id][1] = $nNumber;
            $phonebook[$id][0] = $nName;
        }
        savePhonebook();
        $result = array($id, $nName, $nNumber);
        $message = 'Contact Updated';
        $success = true;
    }
    feedback($success, $message, $result);
}
function savePhonebook()
{
    global $phonebook;
    file_put_contents('phonebook.json', json_encode($phonebook));
}

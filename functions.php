<?php
//PHONEBOOK API
//JSON_ENCODE GETS  AN ARRAY AND ENCODES IT INTO JSON FORMAT AND JSON_DECODES DOES THE  OPPOSITE
$phonebook = json_decode(file_get_contents("phonebook.json"));
//file_get_contents gets values as string from file
//json_decode converts to array
function feedback($success = false, $message = [], $result = [])
{
    $response = [
        "success" => $success,
        "message" => $message,
        "results" => $result,
    ];

    echo json_encode($response);
}

function checkNumberExistence($phone)
{
    global $phonebook;
//check by number if contact already exists
    foreach ($phonebook as $contact) {
        if (in_array($phone, $contact)) {
            $status = true;
            break;
        } else {
            $status = false;
        }

    }
    return $status;
}
function addContact($name, $phone, $email, $gender, $bio)
{
    //GLOBAL KEYWORD MAKES PHONEBOOK VISIBLE INSIDE THE FUNCTION
    global $phonebook;
    $name = ucfirst($name);
    $success = false;
    if ($phone == "") {
        $message[] = 'Number field cannot be empty';
    }
    if (!(is_numeric($phone))) {
        $message[] = 'Number field cannot contain letters';
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
        $message[] = "Only letters and white space allowed";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = "Invalid email format";
    }
    if ($gender == "") {
        $message[] = 'Kindly select a gender';
    }

    if ($phone != "" && $gender != "" && (is_numeric($phone)) && preg_match("/^[a-zA-Z0-9 ]*$/", $name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (checkNumberExistence($phone)) {
            $success = false;
            $message[] = 'Contact already exists with ' . $phone;
        } else {
            $contact = array($name, $phone, $email, $gender, $bio);
            $phonebook[] = $contact;
            savePhonebook();
            $success = true;
            $message[] = $name . ' has been successfully  added to your contacts';
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

function deleteContact($index = '')
{
    global $phonebook;
    $result = [];
    if ($index == "") {
        $success = false;
        $message[] = 'ID cannot be empty!';
    } elseif (!(isset($phonebook[$index]))) {
        $message[] = 'Contact does not exist!';
        $success = false;
    } else {
        $deleted = array_splice($phonebook, $index, 1);
        savePhonebook();
        $success = true;
        $message[] = $deleted[0][0] . ' has been deleted from your phonebook!';
    }
    feedback($success, $message, $result);

}

function searchFields($contact, $searchKey)
{
    foreach ($contact as $field) {
        if (strpos(strtolower($field), strtolower($searchKey)) !== false) {
            return true;
        }
    }
    return false;
}

function search($searchKey)
{
    global $phonebook;
    $searchResult = [];
    $i = 0;
    foreach ($phonebook as $contact) {
        $Temp = [];

        if (searchFields($contact, $searchKey)) {
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
function editContact($id = '', $name = '', $phone = '', $email = '', $gender = '', $bio = '')
{
    global $phonebook;
    $name = ucfirst($name);
    $result = [];
    if (!(is_numeric($phone))) {
        $message[] = 'Number field cannot contain letters';
        $success = false;
    } elseif (!(isset($phonebook[$id]))) {
        $message[] = 'Contact does not exist';
        $success = false;
    } else {

        if ($name == "") {
            $name = $phonebook[$id][0];
        }
        if ($phone == "") {
            $phone = $phonebook[$id][1];
        }
        if ($email == "") {
            $email = $phonebook[$id][2];
        }
        if ($gender == "") {
            $gender = $phonebook[$id][3];
        }
        if ($bio == "") {
            $bio = $phonebook[$id][4];
        }
        $newContact = [$name, $phone, $email, $gender, $bio];
        $phonebook[$id] = $newContact;
        savePhonebook();
        $result = $newContact;
        $message[] = 'Contact Updated';
        $success = true;
    }
    feedback($success, $message, $result);
}
function savePhonebook()
{
    global $phonebook;
    file_put_contents('phonebook.json', json_encode($phonebook));
}

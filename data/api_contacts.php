<?php
require_once '../app/repositories/ContactRepository.php';
header('Content-Type: application/json');

$contactRepository = new ContactRepository();
$contacts = $contactRepository->findAll();

$data = [];

foreach ($contacts as $contact) {
    $data[] = [
        'id' => $contact->getIdContact(),
        'sujet' => $contact->getSujet(),
        'contenu' => $contact->getContenu(),
    ];
}

echo json_encode($data);

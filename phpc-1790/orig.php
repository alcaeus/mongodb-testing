#!/usr/bin/env php
<?php

use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Driver\Exception\BulkWriteException;

require_once 'vendor/autoload.php';

$client = new Client(getenv('MONGODB_URI') ?: 'mongodb://localhost:27017');
$collection = $client->selectCollection('mongodb-testing', 'phpc1790');

$document = [
    '_id' => new ObjectId(),
    'field_a' => 'bbb',
];
$collection->replaceOne($document, ['upsert' => true]);

$criteria = ['_id' => $document['_id']];

$update = [
    '$set' => [
        'field_a' => 'bbb',
    ],
    '$unset' => [],
];

// Exception: not an object
try {
    var_dump($collection->updateOne($criteria, $update));
    var_dump($collection->findOne($criteria));
} catch (BulkWriteException $e) {
    printf("Got %s: %s\n", get_class($e), $e->getMessage());
    var_dump($e->getWriteResult());
}

// Exception: '$unset' is empty
$update['$unset'] = (object) $update['$unset'];
try {
    var_dump($collection->updateOne($criteria, $update));
    var_dump($collection->findOne($criteria));
} catch (BulkWriteException $e) {
    printf("Got %s: %s\n", get_class($e), $e->getMessage());
    var_dump($e->getWriteResult());
}

// Success!
unset($update['$unset']);
var_dump($collection->updateOne($criteria, $update));
var_dump($collection->findOne($criteria));

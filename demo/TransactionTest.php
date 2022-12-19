<?php

require("src/Transaction.php");
require("src/APIException.php");
use IDAnalyzer2\Transaction;
use IDAnalyzer2\APIException;

try {
    $transaction = new Transaction();
    $transaction->throwAPIException(true);
    print_r($transaction->getTransaction("bcefdaf921ca4393a6b9174ba44d3e8f"));
    print_r($transaction->listTransaction());
    print_r($transaction->updateTransaction("bcefdaf921ca4393a6b9174ba44d3e8f", "review"));
    print_r($transaction->deleteTransaction("bcefdaf921ca4393a6b9174ba44d3e8f"));
    $transaction->saveImage("9dd555648a7d594eadda39ea32adbd0fc08a1c79a9e4690cdc8d213f188f5376", "test.jpg");
    $transaction->saveFile("transaction-audit-report_iPYNUSKTD5HhpRb4tZpLdHMsiZKVZgWX.pdf", "test.pdf");
    $transaction->exportTransaction("./test.zip", [
        "a714d58a41874326874c7ce0052717ee",
        "cb45b0898aeb4a3b8fd578f136f4fafa"
    ], "json");

} catch (APIException $e) {
    print_r($e->getMessage());
} catch (InvalidArgumentException $e) {
    print_r($e->getMessage());
} catch (\Exception $e) {
    print_r($e->getMessage());
}

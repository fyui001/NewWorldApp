<?php

return [
    'login_failure' => [
        'type' => 'login_failure',
        'message' => 'Login Failure',
        'response_code' => 400,
    ],
    'duplicate_entry' => [
        'type' => 'duplicate_entry',
        'message' => 'Duplicate entry',
        'response_code' => 409,
    ],
    'invalid_email_address' => [
        'type' => 'invalid_email_address',
        'message' => 'Invalid email address.',
        'response_code' => 400,
    ],
    'invalid_password' => [
        'type' => 'invalid_password',
        'message' => 'Invalid password.',
        'response_code' => 400,
    ],
    'invalid_token' => [
        'type' => 'invalid_token',
        'message' => 'Invalid token.',
        'response_code' => 400,
    ],
    'forbidden' => [
        'type' => 'forbidden',
        'message' => '403 Forbidden.',
        'response_code' => 403,
    ],
    'unauthorized' => [
        'type' => 'unauthorized',
        'message' => '401 Unauthorized.',
        'response_code' => 401,
    ],
    'notfound' => [
        'type' => 'not_found',
        'message' => '404 Notfound.',
        'response_code' => 404,
    ],
    'internal_server_error' => [
        'type' => 'internal_server_error',
        'message' => 'Internal server error.',
        'response_code' => 500,
    ],
    'failed_create_medication_history' => [
        'type' => 'failed_create_medication_history',
        'message' => 'Failed create medication history.',
        'response_code' => 500,
    ],
    'user_notfound' => [
        'type' => 'user_notfound',
        'message' => 'User notfound.',
        'response_code' => 404,
    ],
    'drug_notfound' => [
        'type' => 'drug_notfound',
        'message' => 'Drug notfound.',
        'response_code' => 404,
    ],
    'failed_update_drug' => [
        'type' => 'failed_update_drug',
        'message' => 'Failed update drug.',
        'response_code' => 500,
    ],
    'failed_register_drug' => [
        'type' => 'failed_register_drug',
        'message' => 'Failed register drug.',
        'response_code' => 500,
    ],
    'have_a_medication_history' => [
        'type' => 'have_a_medication_history',
        'message' => 'Have a medication history.',
        'response_code' => 400,
    ],
    'failed_to_delete' => [
        'type' => 'failed_to_delete',
        'message' => 'Failed to delete.',
        'response_code' => 400,
    ],
];

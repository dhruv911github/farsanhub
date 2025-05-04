<?php
return [
    // Login Validation
    'required_email' => 'Email is required.',
    'string_email' => 'Email must be a valid string.',
    'required_password' => 'Password is required.',

    // Registration Validation
    'email_unique' => 'Email is already taken.',
    'required_name' => 'Name is required.',
    'string_name' => 'Name must be a valid string.',
    'max_name' => 'Name must be at most :max characters.',
    'required_password' => 'Password is required.',
    'string_password' => 'Password must be a valid string.',
    'min_password' => 'Password must be at least :min characters.',
    'confirmed_password' => 'Password confirmation does not match.',
    'required_password_confirmation' => 'Password confirmation is required.',
    'string_password_confirmation' => 'Password confirmation must be a valid string.',
    'min_password_confirmation' => 'Password confirmation must be at least :min characters.',

    // change password validation
    'required_current_password' => 'current password is required',
    'string_current_password' => 'current password must be a valid string',

    'required_new_password' => 'new password is required',
    'string_new_password' => 'new password must be a valid string',

    'required_confirm_new_password' => 'confirm new password is required',
    'string_confirm_new_password' => 'confirm new password must be a valid string',

    // Donation Validation
    'required_receipt_number' => 'Receipt number is required.',
    'string_receipt_number' => 'Receipt number must be a valid string.',

    'required_date' => 'Date is required',
    'date_date' => 'Date must be a valid Date',

    'required_full_name' => 'Full name is required.',
    'size_full_name' => 'Full name must be between 1 and 255 characters.',

    'required_mobile_number' => 'Mobile number is required.',
    'size_mobile_number' => 'Mobile number must be exactly 10 digits.',
    'regex_mobile_number' => 'Mobile number must contain only digits.',

    'string_address' => 'Address must be a valid string.',

    'required_amount' => 'Amount is required.',
    'numeric_amount' => 'Amount must be a valid number.',
    'min_amount' => 'Amount must be at least :min.',

    'required_donation_for' => 'Donation for is required.',
    'string_donation_for' => 'Donation for must be a valid string.',

    'string_comment' => 'Comment must be a valid string.',

    // 'required_pan_number' => 'Pan number is required.',
    'regex_pan_number' => 'Pan number must be in the format XXXXX9999X.',

    'required_payment_mode' => 'Payment mode is required.',
    'in_payment_mode' => 'Payment mode must be one of the following: cash, cheque, or online.',

    'string_bank_name' => 'Bank name must be a valid string.',

    'string_cheque_number' => 'Check number must be a valid string.',

    'date_cheque_date' => 'Check date must be a valid date.',

    'string_transaction_id' => 'Transaction ID must be a valid string.',
    'date_transaction_date' => 'Transaction date must be a valid date.',
    'required_transaction_date' => 'Transaction date is required.',

    // Customer Validation
    'required_salary' => 'Salary is required.',
    'required_customer_image' => 'Image is required.',


    // contact us validation
    'required_name' => 'Name is required.',
    'string_name' => 'Name must be a valid string.',
    'max_name' => 'Name must be at most :max characters.',
    'required_email' => 'Email is required.',
    'string_email' => 'Email must be a valid string.',
    'required_mobile_number' => 'Mobile number is required.',
    'size_mobile_number' => 'Mobile number must be exactly 10 digits.',
    'regex_mobile_number' => 'Mobile number must contain only digits.',
    'required_address' => 'Address is required.',
    'string_address' => 'Address must be a valid string.',
    'required_phone' => 'Phone is required.',
    'string_phone' => 'Phone must be a valid string.',
    'required_message' => 'Message is required.',
    'string_message' => 'Message must be a valid string.',
    'required_subject' => 'Subject is required.',
    'string_subject' => 'Subject must be a valid string.',

    // service validation
    'required_title' => 'title is required.',
    'required_description' => 'description is required.',
    'required_status' => 'Status is required.',
    'required_image' => 'Image is required.',
    'image' => 'Image must be a valid image.',
    'max' => 'Image must be at most :max kilobytes.',
    'uploaded' => 'Image must be uploaded.',

    // Expense validation
    'required_purpose' => 'Purpose is required.',

    // testimonial validation
    'required_post' => 'Post is required.',
];

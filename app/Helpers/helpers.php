<?php

use App\Models\PortalActivities;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Hash;

if (!function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}

// encrypt string 
if (!function_exists('encryptResponse')) {
    function encryptResponse($responseData, $aesKey, $aesIv)
    {
        $encryptedResponse = openssl_encrypt($responseData, 'aes-256-cbc', $aesKey, 0, $aesIv);
        return $encryptedResponse;
    }
}

// decrypt string
if (!function_exists('decryptAesResponse')) {
    function decryptAesResponse($responseData, $aesKey, $aesIv)
    {
        // $encryptedResponse = openssl_encrypt($responseData, 'aes-256-cbc', $aesKey, 0, $aesIv);
        $decryptedResponse = openssl_decrypt(base64_decode($responseData['response']), 'AES-256-CBC', $aesKey, OPENSSL_RAW_DATA, $aesIv);
        return $decryptedResponse;
    }
}

if (!function_exists('plainAmount')) {
    function plainAmount($formattedAmount = 0)
    {
        return preg_replace('/[^\d.]/', '', $formattedAmount);
    }
}
if (!function_exists('formattedAmount')) {
    function formattedAmount($amount = 0)
    {
        return number_format($amount, 2);
    }
}

// format number by count of groups
if (!function_exists('formatByGroups')) {
    function formatByGroups($number = '', $group = 5)
    {
        if (!empty($number)) {
            return trim(preg_replace('/(\d{' . $group . '})(?=\d)/', '$1 ', $number));
        } else {
            return false;
        }
    }
}

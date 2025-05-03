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

// audit log
// if (!function_exists('createPortalActivity')) {
//     function createPortalActivity($userId = 0, $moduleName = '', $request_data = [], $response_data = [], $properties = [])
//     {
//         $device = Agent::device();
//         $browser = Agent::browser();
//         $version = Agent::version($browser);
//         $platform = Agent::platform();
//         $platformVersion = Agent::version($platform);

//         $requestVia = '';

//         if (Agent::isPhone()) {
//             $requestVia = 'Phone';
//         } else if (Agent::isTablet()) {
//             $requestVia = 'Tablet';
//         } else if (Agent::isDesktop()) {
//             $requestVia = 'Desktop';
//         }

//         $properties = array_merge($properties, [
//             'device' => $device,
//             'platform' => [
//                 'type' => $platform,
//                 'version' => $platformVersion,
//             ],
//             'browser' => [
//                 'type' => $browser,
//                 'version' => $version,
//             ],
//             'requestFrom' => $requestVia,
//             'ip_address' => getIp(),
//         ]);
//         // var_dump($response_data);
//         // dd($response_data);
//         $responseData = "";
//         if(!empty($response_data)){
//             if (is_array($response_data)) {
//                 $responseData = json_encode($response_data);
//             } elseif (is_object($response_data)) {
//                 $responseData = json_encode($response_data);
//             } else {
//                 $responseData = (string) $response_data;
//             }
//         }

//         $insActivity = new PortalActivities();
//         $insActivity->source_ip = getIp();
//         $insActivity->user_id = $userId;
//         $insActivity->module_name = $moduleName;
//         $insActivity->request_data = json_encode($request_data);
//         $insActivity->response_data = $responseData ?? "";
//         $insActivity->properties = json_encode($properties);
//         $insActivity->created_at = now();
//         $insActivity->updated_at = now();
//         $insActivity->save();
//     }
// }

// fetch ip address
// if (!function_exists('getIp')) {
//     function getIp()
//     {
//         try {
//             $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com")) ?? request()->ip();
//         } catch (Exception $th) {
//             $ip = request()->ip();
//         }
//         return $ip;
//     }
// }

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
// if (!function_exists('generateRandomIntUdid')) {
//     // Output: 0F239913-F9D6-4238-BA0B-6A6F03A575F8
//     function generateRandomIntUdid()
//     {
//         $part1 = strtoupper(bin2hex(random_bytes(4))); // 8 characters
//         $part2 = strtoupper(bin2hex(random_bytes(2))); // 4 characters
//         $part3 = strtoupper(bin2hex(random_bytes(2))); // 4 characters
//         $part4 = strtoupper(bin2hex(random_bytes(2))); // 4 characters
//         $part5 = strtoupper(bin2hex(random_bytes(6))); // 12 characters

//         // Combine parts with dashes
//         return "{$part1}-{$part2}-{$part3}-{$part4}-{$part5}";
//     }
// }

// if (!function_exists('generateIntUdid')) {
//     function generateIntUdid()
//     {
//         $ip = Request::ip();
//         $userAgent = Request::header('User-Agent');

//         $uniqueId = hash('sha256', $ip . $userAgent);
//         // dd($uniqueId);
//         return $uniqueId;
//     }
// }

// formate number as *****1234
// if (!function_exists('maskedLeftSide')) {
//     function maskedLeftSide($mobileNumber = '', $lastDigitsToShow = 3)
//     {
//         if (!empty($mobileNumber)) {
//             $totalLength = strlen($mobileNumber);

//             // Check if the number is long enough to hide some digits
//             if ($totalLength > $lastDigitsToShow) {
//                 // Calculate how many characters to mask
//                 $maskLength = $totalLength - $lastDigitsToShow;

//                 // Mask the middle part and keep the last digits
//                 $maskedNumber = str_repeat('*', $maskLength) . substr($mobileNumber, -$lastDigitsToShow);
//             } else {
//                 // If the number is too short, just return it as is
//                 $maskedNumber = $mobileNumber;
//             }

//             return $maskedNumber;
//         } else {
//             return false;
//         }
//     }
// }

// if (!function_exists('getInitials')) {
//     function getInitials($fullName)
//     {
//         $words = explode(' ', $fullName);
//         $initials = '';

//         foreach ($words as $word) {
//             if (!empty($word)) {
//                 $initials .= strtoupper($word[0]);
//             }
//         }

//         return substr($initials, 0, 2);
//     }
// }

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

// clearing string
// if (! function_exists('cleanString')) {
//     function cleanString($string, $removeChars = []) {
//         // Ensure the input array is not empty
//         if (!empty($removeChars)) {
//             return str_replace($removeChars, '', $string);
//         }
//         return $string; // Return the original string if no characters are specified
//     }
// }

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class SSLCertificateCheck extends Controller
{
    public function handle($domains)
    {
        $now = new DateTime('now', new DateTimeZone(config('app.timezone')));
        $expiringSoon = [];
        $errors = [];
        $certCount = 0;

        $resultArray = [];
        foreach ($domains as $domain) {
            $ips = $this->getIps($domain);
            if (count($ips) === 0) {
                $errors[] = $domain . " :: FAILED TO FIND SERVER IP";
            }
            foreach ($ips as $ip) {
                $certCount++;
                $cert = $this->getCert($ip, $domain);
                if (!$cert) {
                    $errors[] = $domain . '@' . $ip . " :: FAILED TO GET CERTIFICATE INFORMATION";
                    continue;
                }
                $validFrom = new DateTime("@" . $cert['validFrom_time_t']);
                $validTo = new DateTime("@" . $cert['validTo_time_t']);
                $diff = $now->diff($validTo);
                $daysLeft = $diff->invert ? 0 : $diff->days;
                if ($daysLeft <= 15) {
                    $expiringSoon[] = $domain;
                }
                $resultArray[] = [
                    'domain'=> $domain,
                    'valid_from'=> $validFrom->format('jS M Y'),
                    'valid_from_date_time'=> $validFrom->format('Y-m-d H:i:s'),
                    'valid_to'=> $validTo->format('jS M Y'),
                    'valid_to_date_time'=> $validTo->format('Y-m-d H:i:s'),
                    'days_left'=> $daysLeft,
                ];
            }
        }

        $expiringCount = count($expiringSoon);

        $resultArray[] = [
            'expiringCount' => "$expiringCount of $certCount certificate" . ($certCount > 1 ? 's' : '')
            . " across " . count($domains) . " domain" . (count($domains) > 1 ? 's' : '') . " expired or expiring soon",
        ];

        return $resultArray;
    }

    protected function getIps($domain)
    {
        $ips = [];
        $dnsRecords = @dns_get_record($domain, DNS_A + DNS_AAAA);
        // \Log::info(json_encode($dnsRecords )."gggg");
        $data = (is_array($dnsRecords) && count($dnsRecords) > 0) ? true : false;
        if($data){
            foreach ($dnsRecords as $record) {
                if (isset($record['ip'])) {
                    $ips[] = $record['ip'];
                }
                if (isset($record['ipv6'])) {
                    $ips[] = '[' . $record['ipv6'] . ']'; // bindto of 'stream_context_create' uses this format of ipv6
                }
            }
        }
        return $ips;
    }

    protected function getCert($ip, $domain)
    {
        $g = stream_context_create(["ssl" => ["capture_peer_cert" => true], 'socket' => ['bindto' => $ip]]);
        $r = stream_socket_client("ssl://{$domain}:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $g);
        $cont = stream_context_get_params($r);
        return openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"]);
    }

    protected function getOutputColor($daysLeft)
    {
        if ($daysLeft > 30) return "\e[32m";
        if ($daysLeft > 15) return "\e[33m";
        return "\e[31m";
    }
}

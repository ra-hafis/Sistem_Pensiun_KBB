<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // IDENTITAS PENGIRIM
    public $fromEmail = 'rwinandi01@gmail.com'; // Email Gmail
    public $fromName = 'BKPSDM Sistem';
    public $recipients = '';

    // KONFIGURASI SMTP
    public $userAgent = 'CodeIgniter';
    public $protocol = 'smtp';
    public $SMTPHost = 'smtp.gmail.com';
    public $SMTPUser = 'rwinandi01@gmail.com';
    public $SMTPPass = 'cjkeoeebqsejlbba'; // App Password
    public $SMTPPort = 587;
    public $SMTPCrypto = 'tls';
    public $SMTPTimeout = 30;
    public $SMTPKeepAlive = true; // 🔹 Penting supaya koneksi tidak mati terlalu cepat

    // FORMAT EMAIL
    public $wordWrap = true;
    public $wrapChars = 76;
    public $mailType = 'html';
    public $charset = 'UTF-8';
    public $validate = true;

    // PRIORITAS & NEWLINE
    public $priority = 3;
    public $CRLF = "\r\n";
    public $newline = "\r\n";

    // OPSI TAMBAHAN
    public $BCCBatchMode = false;
    public $BCCBatchSize = 200;
    public $DSN = false;
}

<?php
foreach (['data.php', 'careers.php'] as $f) {
    echo "== $f ==\n";
    $c = file_get_contents(__DIR__ . '/' . $f);
    $len = strlen($c);
    $found = [];
    for ($i = 0; $i < $len; $i++) {
        $o = ord($c[$i]);
        if ($o >= 0x80) {
            // decode utf-8 sequence
            $seq = "";
            $bytes = 1;
            if (($o >> 5) === 0b110) { $bytes = 2; }
            elseif (($o >> 4) === 0b1110) { $bytes = 3; }
            elseif (($o >> 3) === 0b11110) { $bytes = 4; }
            $seq = substr($c, $i, $bytes);
            $cp = ord($seq[0]);
            for ($k = 1; $k < strlen($seq); $k++) { $cp = ($cp << 6) | (ord($seq[$k]) & 0x3f); }
            $i += $bytes - 1;
            $count = array_count_values(array_column($found, null));
            $key = $seq;
            if (!isset($found[$key])) { $found[$key] = 1; }
        }
    }
    foreach ($found as $seq => $cnt) {
        $hex = implode(' ', array_map(function($b){ return strtoupper(str_pad(dechex(ord($b)),2,'0',STR_PAD_LEFT)); }, str_split($seq)));
        $u = mb_convert_encoding($seq, 'UCS-4BE', 'UTF-8');
        echo $seq . " | " . $hex . " | U+" . strtoupper(bin2hex($u)) . "\n";
    }
}
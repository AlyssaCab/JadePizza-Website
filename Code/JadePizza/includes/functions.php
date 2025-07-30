<?php
/*-------------------------------------------------------------
/* File: functions.php
/* Description: Checks if the current cart contents 
/*              fulfill all the requirements of a deal.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/
function cart_meets_deal(array $cart, array $requirements): bool {
    foreach ($requirements as $req) {
        $needed = $req['quantity'];
        $fulfilled = 0;

        foreach ($cart as $item) {
            // Match category
            if (strcasecmp($item['category'], $req['required_category']) !== 0) continue;

            // Match size if required
            if (!empty($req['required_size']) && strcasecmp($item['size'], $req['required_size']) !== 0) continue;

            // Match name if required
            if (!empty($req['required_name']) && strcasecmp(trim($item['name']), trim($req['required_name'])) !== 0) continue;

            $fulfilled += $item['quantity'];
        }

        if ($fulfilled < $needed) return false;
    }

    return true;
}
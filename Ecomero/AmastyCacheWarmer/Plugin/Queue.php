<?php
/**
 *           a88888P8
 *          d8'
 * .d8888b. 88        .d8888b. 88d8b.d8b. .d8888b. .dd888b. .d8888b.
 * 88ooood8 88        88'  `88 88'`88'`88 88ooood8 88'    ` 88'  `88
 * 88.  ... Y8.       88.  .88 88  88  88 88.  ... 88       88.  .88
 * `8888P'   Y88888P8 `88888P' dP  dP  dP `8888P'  dP       `88888P'
 *
 *           Copyright © eComero Management AB, All rights reserved.
 */
declare(strict_types=1);

namespace Ecomero\AmastyCacheWarmer\Plugin;

class Queue
{
    public function beforeProcessCombinations(
        $subject,
        $page,
        $stores,
        $currencies,
        $customerGroups
    ) {
        if (is_array($stores)) {
            if (count($stores) === 1) {
                $stores[] = null;
            }
        }

        return [$page,
                $stores,
                $currencies,
                $customerGroups];
    }

    public function afterGetSource($subject, $result)
    {
        $hashes = [];
        $rc = [];

        foreach ($result as $page) {
            $hash = md5($page['url'] . '-' . $page['store']);
            if (!in_array($hash, $hashes)) {
                $rc[] = $page;
                $hashes[] = $hash;
            }
        }

        return $rc;
    }
}

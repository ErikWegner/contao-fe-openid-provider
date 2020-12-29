<?php

declare(strict_types=1);

/*
 * This file is part of fe-openid-provider.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Service;

use Contao\MemberModel;

class DefaultProfileFields
{
    public static function generateFromMember(MemberModel $member)
    {
        $r = [];

        if ($member) {
            $r['given_name'] = $member->firstname;
            $r['family_name'] = $member->lastname;
        }

        return $r;
    }

    public static function generateContaoStructureFromMember(MemberModel $member)
    {
        $r = [];

        if ($member) {
            $r['ut'] = 'fe'; // User Type => Front End user
        }

        return $r;
    }
}

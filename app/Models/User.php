<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use JumpGate\Users\Models\User as BaseUser;
use JumpGate\Users\Traits\HasSocials;

class User extends BaseUser
{
    use Notifiable;

    use HasSocials;

    /**
     * Generate a gravatar from a user's email.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        $google    = $this->getProvider('google');
        $emailHash = md5(strtolower(trim($google->email)));

        return 'https://www.gravatar.com/avatar/' . $emailHash;
    }
}

<?php


namespace Megaverse\LaravelSesManager\Traits;


use Megaverse\LaravelSesManager\Eloquent\BlackListItem;
use Megaverse\LaravelSesManager\Eloquent\MailComplaint;

trait BlackListable
{

    public function getIsBlacklistedAttribute()
    {
        return BlackListItem::where('email', $this->email)->whereNotNull('blacklisted_at')->count() > 0;
    }

    public function getHasComplainedAttribute()
    {
        $complainedEmail = MailComplaint::where('email', $this->email)->first();

        return !is_null($complainedEmail);
    }
}
<?php


namespace Jfunu\LaravelSesManager\Traits;


use Jfunu\LaravelSesManager\Eloquent\BlackListItem;
use Jfunu\LaravelSesManager\Eloquent\MailComplaint;

trait BlackListable
{

    public function getIsBlacklistedAttribute()
    {
        $blacklistedEmail = BlackListItem::where('email', $this->email)->first();

        return !is_null($blacklistedEmail);
    }

    public function getHasComplainedAttribute()
    {
        $complainedEmail = MailComplaint::where('email', $this->email)->first();

        return !is_null($complainedEmail);
    }
}
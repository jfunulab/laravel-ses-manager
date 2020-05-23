<?php


namespace Jfunu\LaravelSesManager\Jobs;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jfunu\LaravelSesManager\Eloquent\BlackListGroup;
use Jfunu\LaravelSesManager\Eloquent\BlackListItem;

class HandleSESBounce
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        $bounce = $this->message;
        $bouncedEmails = collect($bounce['bouncedRecipients']);
        $bouncedAt = Carbon::parse($bounce['timestamp']);

        $useManualBlackList = $bounce['bounceType'] === 'Transient';


        DB::beginTransaction();
        $batchId = BlackListGroup::query()->create([
            'driver' => 'ses',
            'reason' => $bounce['bounceSubType'],
            'bounced_at' => $bouncedAt,
            'payload' => $this->message,
        ])->id;

        $now = now();
        $data = $bouncedEmails->map(
            function ($x) use ($useManualBlackList, $now, $batchId) {
                return $data[] = [
                    'email' => $x['emailAddress'],
                    'blacklisted_at' => $useManualBlackList ? null : $now,
                    'group_id' => $batchId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->toArray();
        BlackListItem::query()->insert($data);
        DB::commit();
    }
}
